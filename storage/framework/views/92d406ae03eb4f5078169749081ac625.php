<template>
    <jetin-layout :title="<?php echo '__(\'' . $modelTitle. '\')'; ?>">
        <template <?php echo e('#'); ?>navbar-button>
            <h3 class="pt-1 pl-4 mb-2 text-lg font-black sm:rounded-t-lg bg-primary-100  right-side">
                
                <span> {{__('List of All')}}<?php echo '{{__("' . Str::plural($modelTitle) . '")}}'; ?></span>
            </h3>
        </template>
        <div v-if="can.viewAny" class="flex flex-wrap px-4">
            <div class="z-10 flex-auto bg-white md:rounded-md md:shadow-md w-full">
                <div class="flex w-full flex-col top-bar">
                    <div class="left-side flex-1 justify-center">
                    </div>
                    <div class="pt-1 pr-4 mb-2 text-lg text-right font-black sm:rounded-t-lg bg-primary-100  right-side">
                        
                    </div>
                </div>
                <div class="p-4">
                    <dt-component
                        :table-id="tableId"
                        :ajax-url="ajaxUrl"
                        :columns="columns.data"
                        :exheader="columns.exheader"
                        :ajax-params="tableParams"
                        <?php echo e('@'); ?>show-model="showModel"
                        <?php echo e('@'); ?>edit-model="editModel"
                        <?php echo e('@'); ?>delete-model="confirmDeletion"
<?php if(isset($rootOptions) && in_array('pdfview', $rootOptions)): ?>
                        <?php echo e('@'); ?>pdf-view-model="pdfViewModel"
<?php endif; ?>
                    />
                </div>
                <jet-confirmation-modal title="Confirm Deletion" :show="confirmDelete">
                    <template v-slot:content>
                        <div>{{__('Are you sure you want to delete this record?')}}</div>
                    </template>
                    <template v-slot:footer>
                        <div class="flex justify-end gap-x-2">
                            <inertia-button as="button" type="button" @click.native.stop="cancelDelete" class="bg-orange-500 text-white">{{__('Cancel')}}</inertia-button>
                            <inertia-button as="button" type="button" @click.native.prevent="deleteModel" class="bg-blue-500 text-white">{{__('Yes, Delete')}}</inertia-button>
                        </div>
                    </template>
                </jet-confirmation-modal>
                <div v-if="showModal && currentModel">
                    <jetin-modal
                        :show="showModal"
                        corner-class="rounded-lg"
                        position-class="align-middle"
                        @close="currentModel = null; showModal = false">

                        <template <?php echo e('#'); ?><?php echo e('title'); ?>>{{__('Show')}} <?php echo '{{__("' .$modelTitle. '")}}'; ?> <?php echo e('#'); ?><?php echo e('{{'); ?>currentModel.id}}</template>
                        <show-<?php echo e($modelRouteAndViewName); ?>-form :model="currentModel"></show-<?php echo e($modelRouteAndViewName); ?>-form>
                        <template <?php echo e('#'); ?><?php echo e('footer'); ?>>
                            <inertia-button class="px-4 text-white bg-primary" <?php echo e('@'); ?>click="showModal = false; currentModel = null">{{__('Close')}}</inertia-button>
                        </template>
                    </jetin-modal>
                </div>
            </div>
        </div>
        <div v-else class="p-4 font-bold text-red-500 bg-red-100 rounded-md shadow-md ">
        {{__('You are not authorized to view a list of')}} <?php echo '{{__("' .$modelTitlePlural. '")}}'; ?>

        </div>
    </jetin-layout>
</template>

<script>
    import JetinLayout from "@/Layouts/JetinLayout.vue";
    import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
    import JetDialogModal from "@/Jetstream/DialogModal.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import JetinToggle from "@/JetinComponents/JetinToggle.vue";
    import JetinModal from "@/JetinComponents/JetinModal.vue";
    import DtComponent from "@/JetinComponents/DtComponent.vue";
    import DisplayMixin from "@/Mixins/DisplayMixin.js";
    import Show<?php echo e($modelPlural); ?>Form from "@/Pages/<?php echo e($modelPlural); ?>/ShowForm.vue";
    import { defineComponent } from "vue";

    export default defineComponent({
        name: "Index",
        components: {
            DtComponent,
            JetinToggle,
            InertiaButton,
            JetConfirmationModal,
            JetDialogModal,
            JetinModal,
            JetinLayout,
            Show<?php echo e($modelPlural); ?>Form,
        },
        props: {
            can: Object,
            columns: Array,
        },
        inject: ["$refreshDt","$dayjs"],
        data() {
            return {
                tableId: '<?php echo e($modelRouteAndViewName); ?>-dt',
                tableParams: {},
                datatable: null,
                confirmDelete: false,
                currentModel: null,
                withDisabled: false,
                showModal: false,
            }
        },
        mixins: [
            DisplayMixin,
        ],
        mounted() {
            if(localStorage.getItem('notifyMessage')){
                let notifyMessage = JSON.parse(localStorage.getItem('notifyMessage'));
                if(notifyMessage.status == 'success'){
                    this.displayNotification(this.__('success'),notifyMessage.msg);
                }else{
                    this.displayNotification(this.__('error'),notifyMessage.msg);
                }
                localStorage.removeItem('notifyMessage');
            }
        },
        computed: {
            ajaxUrl() {
                const url = new URL(this.route('api.<?php echo e($modelRouteAndViewName); ?>.dt'));
                /*if (this.withDisabled) {
                    url.searchParams.append('include-disabled',true);
                }*/
                return url.href;
            }
        },
        methods: {
            showModel(model) {
                axios.get(route('api.<?php echo e($modelRouteAndViewName); ?>.show',model)).then(res => {
                    this.currentModel = res.data.payload;
                    this.showModal = true;
                })
                // this.$inertia.visit(this.route('admin.<?php echo e($modelRouteAndViewName); ?>.show',model.id));
            },
            editModel(model) {
                this.$inertia.visit(this.route('admin.<?php echo e($modelRouteAndViewName); ?>.edit',model.id));
            },
            confirmDeletion(model) {
                this.currentModel = model;
                this.confirmDelete = true;
            },
            cancelDelete() {
                this.currentModel = false;
                this.confirmDelete = false;
            },
            async deleteModel() {
                const vm = this;
                this.confirmDelete = false;
                if (this.currentModel) {
                    this.$inertia.delete(route('admin.<?php echo e($modelRouteAndViewName); ?>.destroy', vm.currentModel),{
                        onFinish: res => {
                            if(this.$page.props.flash && Object.keys(this.$page.props.flash)[0] == "success"){
                                this.displayNotification(vm.__("success"),vm.__("Item deleted."));
                            }else{
                                this.displayNotification(vm.__("error"),vm.__("There was an error while deleting the item.","error"));
                            }
                            vm.$refreshDt(vm.tableId);
                        },
                        onError: err => {
                            console.log(err);
                            this.displayNotification(vm.__("error"),vm.__("There was an error while deleting the item.","error"));
                        }
                    });
                }
            },
            async toggleActivation(enabled,model) {
                const vm = this;
                console.log(enabled);
                axios.put(route(`api.<?php echo e($modelRouteAndViewName); ?>.update`,model.id),{
                    enabled: enabled
                }).then(res => {
                    this.displayNotification(vm.__("success"),vm.__(res.data.message));
                    this.$refreshDt(this.tableId);
                })
            },
<?php if(isset($rootOptions) && in_array('pdfview', $rootOptions)): ?>
            pdfViewModel(model){
                const win = window.open(
                    this.route('admin.quotations.pdf.view',model.id),
                    "_blank"
                );
            },
<?php endif; ?>
        }
    });
</script>

<style scoped>

</style>
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/withChildren/index.blade.php ENDPATH**/ ?>