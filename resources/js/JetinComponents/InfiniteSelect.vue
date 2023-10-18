<template>
    <v-select
        :model-value="formatData(modelValue)"
        @update:modelValue="onSelect"
        :items="paginatedObject.data"
        :variant="variant"
        :multiple="multiple"
        :chips="chips"
        :readonly="readonly"
        :disabled="disabled"
    >
        <template #no-data v-if="hasNextPage" >
            <div  v-intersect="onIntersect" v-if="!loaded" class="loader">
                {{__('Loading more options...')}}
            </div>
            <div v-if="loaded"  class="loader">{{__('Sorry, no matching options.')}}</div>
        </template>
    </v-select>
</template>

<script>
// import vSelect from "vue-select";
import { defineComponent } from "vue";
export default defineComponent({
    name: "InfiniteSelect",
    emits: ["update:modelValue"],
    model: {
        prop: "modelValue",
        event: "update:modelValue",
    },
    props: {
        disabled:{
            required: false,
            default: () => {
                return false;
            },
        },
        readonly:{
            required: false,
            default: () => {
                return false;
            },
        },
        chips:{
            required: false,
            default: () => {
                return false;
            },
        },
        variant:{
            required: false,
            default: () => {
                return "outlined";
            },
        },
        apiUrl: {
            required: true,
            type: String,
        },
        queryParams: {
            required: false,
            default: () => {
                return {};
            },
        },
        perPage: {
            required: false,
            default: 15,
        },
        multiple: {
            type: Boolean,
            default: false,
        },
        modelValue: {
            default: null,
        },
        label: {
            required: false,
            type: String,
        },
        reduce: {
            type: Function,
        },
        placeholder: String,
    },
    data: () => ({
        observer: null,
        paginatedObject: {
            data: [],
        },
        loaded:false,
        searchQuery: null,
    }),
    mounted() {
        this.paginatedObject.per_page = parseInt(this.perPage) || 15;
        this.selected = this.initValue;
        this.observer = new IntersectionObserver(this.infiniteScroll);

    },
    methods: {
        async onIntersect(isIntersecting, entries, observer) {
            // More information about these options
            // is located here: https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API
            await this.fetchResults(null, true, true);
        },
        formatData(val){
            let data = val;
            if(typeof data == "string"){
                try {
                    data = JSON.parse(data);
                } catch (error) {
                    return data;
                }
            }

            return data;
        },
        async onOpen() {
            if (this.hasNextPage) {
                await this.$nextTick();
                this.observer.observe(this.$refs.infiniteSelectLoad);
            }
        },
        onClose() {
            this.observer.disconnect();
            this.searchQuery = null;
        },
        onSelect(value) {
            this.$emit("update:modelValue", value);
        },
        async fetchResults(query, loading, more = false) {
            const vm = this;
            if (query) {
                vm.searchQuery = query;
            }
            let params = {};
            if (vm.paginatedObject.current_page && more) {
                if (!vm.paginatedObject.next_page_url) {
                    return false;
                }
                params.page = vm.paginatedObject.current_page + 1;
                params.per_page = vm.paginatedObject.per_page;
            }
            if (vm.searchQuery) {
                params.search = vm.searchQuery;
            }
            params = { ...params, ...vm.queryParams };
            return new Promise((resolve, reject) => {
                const vm = this;
                loading = true;
                axios
                    .get(vm.apiUrl, {
                        params: params,
                    })
                    .then((res) => {
                        // process and store results.
                        const bak = vm.paginatedObject.data;
                        vm.paginatedObject = res.data.payload;
                        if (more) {
                            vm.paginatedObject.data = [
                                ...bak,
                                ...res.data.payload.data,
                            ];
                        }
                        resolve(res);
                    })
                    .catch((err) => {
                        // reset Object, report error.
                        reject(err);
                    })
                    .finally((res) => {
                        loading = false;
                        this.loaded = true;
                    });
            });
        },
        async infiniteScroll([{ isIntersecting, target }]) {
            if (isIntersecting) {
                const ul = target.offsetParent;
                const scrollTop = target.offsetParent.scrollTop;
                await this.fetchResults(null, true, true);
                ul.scrollTop = scrollTop;
            }
        },
    },
    computed: {
        hasNextPage() {
            let vm = this;
            return (
                (vm.paginatedObject.current_page &&
                    vm.paginatedObject.next_page_url) ||
                (!vm.paginatedObject.data.length &&
                    !vm.paginatedObject.current_page)
            );
        },
    },
    watch: {},
});
</script>

<style lang="scss">

.loader {
    text-align: center;
    color: #bbbbbb;
}
.vs__dropdown-toggle {
    border: none !important;
}
.v-select .v-field .v-field__input > input[inputmode*="none"]{
    display: none;
}
[type='checkbox'], [type='radio'] {
    -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button;
}
</style>
