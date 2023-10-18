<template>
    <table
        v-cloak
        v-show="table_ready"
        :id="tableId"
        class="text-left nowrap stripe hover"
        :class="tableClasses"
        width="100%"
        >
            <slot></slot>
    </table>
    <div v-if="viewFileModal">
        <jetin-modal
            :show="viewFileModal"
            corner-class="rounded-lg"
            position-class="align-middle"
            @close="viewFileModal = false">
            <div class="flex justify-center">
                <img class="drop-shadow-lg" :src="currentFile" />
            </div>
        </jetin-modal>
    </div>
</template>
<style>
.filters input{
text-align: center;
}
.bottom {
display: flex;
flex-direction: column;
}
</style>
<script>
import { onMounted } from "vue";
import { emitter } from "./eventHub.js";
import { defineComponent } from "vue";

import jszip from 'jszip';
window.JSZip = jszip;

import pdfmake from 'pdfmake';
window.pdfMake = pdfmake;

// import pdfFonts from "pdfmake/build/vfs_fonts";
// window.pdfMake.vfs = pdfFonts.pdfMake.vfs;

import dayjs from "dayjs";
import utc from 'dayjs/plugin/utc';
dayjs.extend(utc);
window.moment = dayjs;
import 'jquery/dist/jquery.min.js';
import $ from 'jquery';
window.jQuery = $;
import "datatables.net";
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
import 'datatables.net-buttons/js/buttons.colVis';
import 'datatables.net-responsive';
import 'datatables.net-datetime';


import JetinModal from "@/JetinComponents/JetinModal.vue";


import '../../css/buttons.dataTables.min.css';
import '../../css/jquery.dataTables.min.css';
import '../../css/responsive.dataTables.min.css';
import 'datatables.net-searchbuilder-dt/css/searchBuilder.dataTables.min.css'
import 'datatables.net-datetime/dist/dataTables.dateTime.css'


import 'datatables.net-searchbuilder';
import 'datatables.net-searchbuilder-dt';

var baseColspan = [];
var langFlag;
var searchBuilderOptions = {};

export default defineComponent({
name: "DtComponent",
props: {
    tableId: {
        required: true,
        type: String,
    },
    tableClasses: {
        required: false,
        default: "",
    },
    processing: {
        type: Boolean,
        required: false,
        default: true,
    },
    serverSide: {
        type: Boolean,
        required: false,
        default: true,
    },
    columns: {
        required: true,
        type: Array,
    },
    exheader: {
        required: false,
        type: Array,
    },
    columnDefs: {
        required: false,
        type: Array,
        default: () => {
            return [];
        },
    },
    actionButtons: {
        required: false,
        type: Array,
        default: () => {
            return [];
        },
    },
    ajaxUrl: {
        required: true,
        type: String,
    },
    ajaxParams: {
        required: false,
        type: Object,
        default: () => {
            return {};
        },
    },
    tenant: {
        required: false,
        type: String,
        default: null,
    },
    tenantHeaderName: {
        required: false,
        default: null,
    },
    tenantQueryParam: {
        required: false,
        default: null,
    },
    defaultOrderColumn: {
        type: Number,
        default: 1,
    },
    defaultOrderDirection: {
        type: String,
        default: "asc",
    },
    stateSave: {
        type: Boolean,
        default: true,
    },
},
components: {
    JetinModal
},
data() {


    return {
        viewFileModal: false,
        currentFile: null,
        item_id: null,
        table: null,
        table_ready: false,
        allColumns: [],
    };
},
async mounted() {
    const vm = this;
    let columns = vm.columns;


    window.__ = vm.__;

    await import('./assets/DtButton');

    await import('./assets/datetime-day');

    await import('./assets/select2');
    // vm.allColumns = columns;

    $.fn.dataTable.ext.searchBuilder.searchBuilderOptions = {};

    columns = [{data:"", type:"dtr-control", orderable:false,searchable:false, title:""}, ...columns];

    var colDefs = columns.map((col, idx) => {
        col['title'] = vm.__(col['title']);
        let render = col['render'];
        let $jsonData = null;
        if(col.defaultContent){
            $jsonData = JSON.parse(col.defaultContent);
        }
        // let data = col['data'];
        //  col['render'] = function ( data, type, row, meta ) { return '<a target="_blank" href="'+data+'">Download</a>' };

        // if(col['data'] == 'actions' && render){
        //     // col['data'] = null;
        //     // var fun = vm.renderActions
        //     var new_fn =  vm.renderActions
        //     col['render'] = JSON.parse(JSON.stringify(vm.renderActions));
        // }

        if(col['data'].toLowerCase().indexOf("file") !== -1 || col['data'].toLowerCase().indexOf("image") !== -1){
            // col['data'] = null;
            return {
                responsivePriority: col.responsivePriority || -1,
                // data:'actions',
                className: 'text-center',
                targets: idx,
                render: vm.renderFileView
            };
        }else if(col['data'].toLowerCase() == 'actions'){
            // col['data'] = null;
            return {
                responsivePriority: col.responsivePriority || -1,
                // data:'actions',
                className: 'text-center',
                targets: idx,
                render: vm.renderActions
            };
        }else if(col['data'].toLowerCase() == 'id'){
            // col['data'] = null;
            return {
                responsivePriority: col.responsivePriority || -1,
                // data:'actions',
                className: 'text-center',
                targets: idx,
                width: "70px"
            };
        }else if(col['render']){
            let render = col['render'];
            delete col['render'];
            let renderFun = new Function("return " + render)();
            return {
                responsivePriority: col.responsivePriority || -1,
                // data:'actions',
                className: 'text-center',
                targets: idx,
                render: (data, type, row, meta) => renderFun(data, type, row, meta, vm)
            };
        }else if(col['type'].toLowerCase() == "enum"){
            if( $jsonData.options){
                let $options = [];

                $jsonData.options.forEach(val => {
                    $options.push({
                        "value": val,
                        "label": vm.__(val)
                    });
                });
                $.fn.dataTable.ext.searchBuilder.searchBuilderOptions[col['data']] = $options;
            }
            return {
                responsivePriority: col.responsivePriority || -1,
                className: 'text-center',
                targets: idx,
                render: (data, type, row, meta) => {
                    if(data)
                        return vm.__(data);
                    return "";
                }
            };
        }else if(col['type'].toLowerCase() == "date"){
            return {
                responsivePriority: col.responsivePriority || -1,
                className: 'text-center',
                targets: idx,
                render: (data, type, row, meta) => {
                    if(data == null)
                        return "";
                    if(data.length > 17)
                        data = data.substring(16, -1);
                    return '<div class="date-row"><span>'+data.replace(" ","</span><span>")+"</span></div>";
                }
            };
        }else{
            return {
                responsivePriority: col.responsivePriority || -1,
                // data:col['data'],
                className: 'text-center',
                targets: idx
            };
        }

    });



    colDefs.push({ className: 'dtr-control fas', orderable: false, targets: 0, render: (data, type, row, meta) => {  return ""; } });

    $(document).ready( function () {

        let $createButton = "";
        $.fn.dataTable.moment('YYYY-MM-DD');
        $.fn.dataTable.Criteria._escapeHTML = function (txt) {
            if(txt)
                return txt
                    .toString()
                    .replace(/&amp;/g, '&')
                    .replace(/&lt;/g, '<')
                    .replace(/&gt;/g, '>')
                    .replace(/&quot;/g, '"');

            return null;
        };

        $.fn.dataTable.ext.searchBuilder.conditions.ENUM = {
            '=': {
                conditionName: function (dt, i18n) {
                    return dt.i18n('searchBuilder.conditions.string.equals', i18n.conditions.string.equals);
                },
                isInputValid: $.fn.dataTable.Criteria.inputValueSelect,

                init: function (that, fn, preDefined, array) {
                    if (preDefined === void 0) { preDefined = null; }
                    if (array === void 0) { array = false; }
                    // that.dom.valueTitle.prop('selected', true);

                    var el = $('<select/>')
                        .addClass(that.classes.value)
                        .addClass(that.classes.dropDown)
                        .addClass(that.classes.italic)
                        .addClass(that.classes.select)
                        .append(that.dom.valueTitle)
                        .on('change.dtsb', function () {
                            $(this).removeClass(that.classes.italic);
                            fn(that, this);
                        });



                    if (that.c.greyscale) {
                        el.addClass(that.classes.greyscale);
                    }

                    if(that.c.searchBuilderOptions){
                        that.c.searchBuilderOptions[that.s.origData].forEach(val => {
                        var opt = $('<option>', {
                                type: Array.isArray(val.value) ? 'Array' : 'String',
                                value: val.value
                            })
                                .data('sbv', val.value)
                                .addClass(that.classes.option)
                                .addClass(that.classes.notItalic)
                                // Have to add the text this way so that special html characters are not escaped - &amp; etc.
                                .html(typeof val.label === 'string' ?
                                val.label.replace(/(<([^>]+)>)/ig, '') :
                                val.label);
                        el.append(opt);
                        });
                    }

                    return el ;
                },

                inputValue: $.fn.dataTable.Criteria.inputValueSelect,
                search: function (value, comparison) {
                    return value === comparison[0];
                }
            },
            '!=': {
                conditionName: function (dt, i18n) {
                    return dt.i18n('searchBuilder.conditions.string.not', i18n.conditions.string.not);
                },
                isInputValid: $.fn.dataTable.Criteria.inputValueSelect,

                init: function (that, fn, preDefined, array) {
                    if (preDefined === void 0) { preDefined = null; }
                    if (array === void 0) { array = false; }
                    // that.dom.valueTitle.prop('selected', true);

                    var el = $('<select/>')
                        .addClass(that.classes.value)
                        .addClass(that.classes.dropDown)
                        .addClass(that.classes.italic)
                        .addClass(that.classes.select)
                        .append(that.dom.valueTitle)
                        .on('change.dtsb', function () {
                            $(this).removeClass(that.classes.italic);
                            fn(that, this);
                        });



                    if (that.c.greyscale) {
                        el.addClass(that.classes.greyscale);
                    }

                    if(that.c.searchBuilderOptions){
                        that.c.searchBuilderOptions[that.s.origData].forEach(val => {
                        var opt = $('<option>', {
                                type: Array.isArray(val.value) ? 'Array' : 'String',
                                value: val.value
                            })
                                .data('sbv', val.value)
                                .addClass(that.classes.option)
                                .addClass(that.classes.notItalic)
                                // Have to add the text this way so that special html characters are not escaped - &amp; etc.
                                .html(typeof val.label === 'string' ?
                                val.label.replace(/(<([^>]+)>)/ig, '') :
                                val.label);
                        el.append(opt);
                        });
                    }

                    return el ;
                },

                inputValue: $.fn.dataTable.Criteria.inputValueSelect,
                search: function (value, comparison) {
                    return value !== comparison[0];;
                }
            },
            'null': {
                conditionName: function (dt, i18n) {
                    return dt.i18n('searchBuilder.conditions.string.empty', i18n.conditions.string.empty);
                },
                init: $.fn.dataTable.Criteria.initNoValue,
                inputValue: function () {
                    return;
                },
                isInputValid: function () {
                    return true;
                },
                search: function (value) {
                    return value === null || value === undefined || value.length === 0;
                }
            },
            // eslint-disable-next-line sort-keys
            '!null': {
                conditionName: function (dt, i18n) {
                    return dt.i18n('searchBuilder.conditions.string.notEmpty', i18n.conditions.string.notEmpty);
                },
                init: $.fn.dataTable.Criteria.initNoValue,
                inputValue: function () {
                    return;
                },
                isInputValid: function () {
                    return true;
                },
                search: function (value) {
                    return !(value === null || value === undefined || value.length === 0);
                }
            }
        };

        if(vm.$page.props.can.create){
            $createButton = {
                extend: 'create',
                className:'btn btn-default btn-sm no-corner',
                text: '<i class="fa fa-plus"></i> '+vm.__('New')
            }
        }
        vm.table = $(`#${vm.tableId}`).DataTable({
            language: {
                search: vm.__("DBTAB-search"),
                processing: vm.__("DBTAB-processing"),
                loadingRecords: vm.__("DBTAB-loadingRecords"),
                emptyTable: vm.__("DBTAB-emptyTable"),
                zeroRecords: vm.__("DBTAB-zeroRecords"),
                infoEmpty: vm.__("DBTAB-infoEmpty"),
                infoFiltered: vm.__("DBTAB-infoFiltered"),
                paginate: {
                    first:vm.__("DBTAB-first"),
                    previous:vm.__("DBTAB-previous"),
                    next: vm.__("DBTAB-next"),
                    last:vm.__("DBTAB-last")
                },
                aria: {
                    sortAscending:  vm.__("DBTAB-sortAscending"),
                    sortDescending: vm.__("DBTAB-sortDescending")
                },
                info: vm.__("DBTAB-info"),
                lengthMenu:vm.__("DBTAB-lengthMenu"),
                searchPlaceholder: vm.__("DBTAB-searchPlaceholder"),
                searchBuilder: {
                    add: vm.__("DBTAB-add"),
                    condition: vm.__('DBTAB-condition'),
                    clearAll: vm.__('DBTAB-clearAll'),
                    delete: vm.__('DBTAB-delete'),
                    deleteTitle: vm.__('DBTAB-deleteTitle'),
                    data: vm.__('DBTAB-data'),
                    left: vm.__('DBTAB-left'),
                    leftTitle: vm.__('DBTAB-leftTitle'),
                    logicAnd: vm.__('DBTAB-logicAnd'),
                    logicOr: vm.__('DBTAB-logicOr'),
                    right: vm.__('DBTAB-right'),
                    rightTitle: vm.__('DBTAB-rightTitle'),
                    title: {
                        0: '<i class="fas fa-search"></i> ' +  vm.__('DBTAB-title0'),
                        _: '<i class="fas fa-search"></i> ' +  vm.__('DBTAB-title_')
                    },
                    value: vm.__('DBTAB-value'),
                    valueJoiner: vm.__('DBTAB-valueJoiner'),
                    button: {
                        0: '<i class="fas fa-search"></i> ' +  vm.__('DBTAB-title0'),
                        _: '<i class="fas fa-search"></i> ' +  vm.__('DBTAB-title_')
                    },
                    "conditions": {
                        "date": {
                            "equals":vm.__("DBTAB-equals"),
                            "after":vm.__("DBTAB-after"),
                            "before":vm.__("DBTAB-before"),
                            "between":vm.__("DBTAB-between"),
                            "empty":vm.__("DBTAB-empty"),
                            "not":vm.__("DBTAB-not"),
                            "notBetween":vm.__("DBTAB-notBetween"),
                            "notEmpty":vm.__("DBTAB-notEmpty")
                        },
                        "number": {
                            "between":vm.__("DBTAB-between"),
                            "empty":vm.__("DBTAB-empty"),
                            "equals":vm.__("DBTAB-equals"),
                            "gt":vm.__("DBTAB-gt"),
                            "gte":vm.__("DBTAB-gte"),
                            "lt":vm.__("DBTAB-lt"),
                            "lte":vm.__("DBTAB-lte"),
                            "not":vm.__("DBTAB-not"),
                            "notBetween":vm.__("DBTAB-notBetween"),
                            "notEmpty":vm.__("DBTAB-notEmpty")
                        },
                        "string": {
                            "contains":vm.__("DBTAB-contains"),
                            "empty":vm.__("DBTAB-empty"),
                            "endsWith":vm.__("DBTAB-endsWith"),
                            "equals":vm.__("DBTAB-equals"),
                            "not":vm.__("DBTAB-not"),
                            "notEmpty":vm.__("DBTAB-notEmpty"),
                            "startsWith":vm.__("DBTAB-startsWith"),
                            "notContains":vm.__("DBTAB-notContains"),
                            "notStartsWith":vm.__("DBTAB-notStartsWith"),
                            "notEndsWith":vm.__("DBTAB-notEndsWith")
                        },
                        "array": {
                            "equals":vm.__("DBTAB-equals"),
                            "empty":vm.__("DBTAB-empty"),
                            "contains":vm.__("DBTAB-contains"),
                            "not":vm.__("DBTAB-not"),
                            "notEmpty":vm.__("DBTAB-notEmpty"),
                            "without":vm.__("DBTAB-without")
                        }
                    },
                }
            },
            dom: 'B<"tab-overflow-x"t><"bottom"<"t"irp><"b"l>>',
            buttons: [
                $createButton,
                {
                    extend: 'export',
                    className:'btn btn-default btn-sm no-corner',
                    text: '<i class="fa fa-download"></i> ' + __('Export') + '&nbsp;<span class="caret"/>'
                },
                {
                    extend: 'print',
                    className:'btn btn-default btn-sm no-corner',
                    text: '<i class="fa fa-print"></i> '+ __('Print')
                },
                {
                    extend: 'reload',
                    className:'btn btn-default btn-sm no-corner',
                    text: '<i class="fas fa-redo"></i> '+ vm.__('Refresh')
                },
                {
                    extend: 'mySearchBuilder'
                },
                // {
                //     extend: 'tools',
                //     className:'btn btn-default btn-sm no-corner',
                //     text: '<i class="fas fa-tools"></i> ' + vm.__('Tools') + '&nbsp;<span class="caret"/>'
                // },
            ],
            processing: true,
            serverSide: true,
            stateSave: vm.stateSave,
            orderCellsTop: true,
            fixedHeader: true,
            responsive: {
                breakpoints: [
                    { name: "tv", width: Infinity },
                    { name: "desktop-l", width: 1536 },
                    { name: "desktop", width: 1280 },
                    { name: "tablet-l", width: 1024 },
                    { name: "tablet-p", width: 768 },
                    { name: "mobile-l", width: 480 },
                    { name: "mobile-p", width: 320 },
                ],
                details: {
                    type: 'column'
                }
            },
            pageLength: 20,
            lengthMenu: [5, 10, 15, 20, 50, 100, 200, 500],
            ajax: {
                url: vm.ajaxUrl,
                data: function (d) {
                    for (const [key, value] of Object.entries(
                        vm.ajaxParams
                    )) {
                        d[key] = value;
                    }
                },
                beforeSend: function (request) {
                    if (vm.tenant && vm.tenantHeaderName) {
                        request.setRequestHeader(
                            `${vm.tenantHeaderName}`,
                            `${vm.tenant}`
                        );
                    }
                },
                complete: function(xhr, responseText){
                        console.log(xhr);
                        console.log(responseText); //*** responseJSON: Array[0]

                        if(vm.exheader){
                            vm.updateExHeader();
                            window.addEventListener('resize', function(event) {
                                vm.updateExHeader();
                            }, true);
                        }

                }
            },
            columns: columns,
            // columnDefs:  [...vm.columnDefs],
            columnDefs:colDefs,
            order: [[vm.defaultOrderColumn, vm.defaultOrderDirection]],
            initComplete: function () {
                var api = this.api();

                let searchKeys = JSON.parse( localStorage.getItem(`DataTables_${vm.tableId}_`+window.location.pathname));
                if(searchKeys){
                    searchKeys = searchKeys.columns;
                }

                $(`#${vm.tableId} thead th`).each(function(colIdx) {
                    if(columns[colIdx].searchable){
                        var title = $(this).text();
                        let searchKey = "";
                        if(searchKeys && searchKeys[colIdx]){
                            searchKey = searchKeys[colIdx].search.search;
                        }
                        let hasKey = "";
                        if(searchKey != ""){
                            searchKey = searchKey.replace(/\(\(\(\(/g,'').replace(/\)\)\)\)/g,'').replace(/\\\(/g,'(').replace(/\\\)/g,')').replace(/\\\+/g,'+');
                            $('tfoot  tr.filters').addClass('has-search-keyword');
                            hasKey = "hasKey";
                        }

                        let $jsonData = null;

                        if(columns[colIdx].defaultContent){
                            $jsonData = JSON.parse(columns[colIdx].defaultContent);
                        }

                        if(columns[colIdx].type == "ENUM"){
                            let options = "";
                            $jsonData.options.forEach(val => {
                                let selected = '';
                                if(searchKey == val)
                                    selected = "selected";

                                options += `<option value="${val}" ${selected}>${vm.__(val)}</option>`;
                            });
                            $(this).html(`<h4>${title}</h4><select style="background-color: white;width: 100%;text-align: center;font-size: 12px;font-weight: normal;height: 25px; border: 1px solid #9c8647; padding-left: 0px; padding-right:0px;" id="${columns[colIdx].name}"><option/>${options}</select>`);

                        }else{
                            $(this).html(`<h4>${title}</h4><input style="width: 100%;text-align: center;font-size: 12px;font-weight: normal;height: 26px; border: 1px solid #9c8647; padding-left: 0px; padding-right:0px;" type="text" placeholder="${title}" value="${searchKey}" />`);
                        }

                    }
                });

                this.api().columns()
                    .every(function() {
                    var that = this;

                    $('select', this.header()).on('change', function(e) {
                        if (that.search() !== this.value) {
                        that.search(this.value).draw();
                        }
                    }).on('click', e => e.stopPropagation());

                    $('input', this.header()).on('input', function(e) {
                        if (that.search() !== this.value) {
                        that.search(this.value).draw();
                        }
                    }).on('click', e => e.stopPropagation());
                });

                if(vm.exheader){
                    let exheader = '<tr>';
                    let rightBorCunt = 0;
                    vm.exheader.forEach((element, index) => {
                        baseColspan[index] = element.len;
                        exheader += '<th class="'+element.class+'" colspan="'+element.len+'">'+vm.__(element.name)+'</th>';
                        rightBorCunt += element.len;
                        $('table thead tr th:nth-child('+rightBorCunt+')').addClass("right-bor");
                    });
                    exheader += '<th></th></tr>';
                    $( "table thead" ).prepend( exheader );
                    $( "table" ).addClass('ex-header');
                }
            },
        })
        .on( 'xhr', function (e, settings, data) {
            // console.log( 'Table initialisation complete: '+new Date().getTime() );
            // data['searchBuilder'] = { "options" : searchBuilderOptions };
            // settings.json['searchBuilder'] = { "options" : searchBuilderOptions };
        });
        vm.table.columns.adjust().responsive.recalc();
        vm.table.columns.adjust().responsive.rebuild();
        vm.table.on("click", ".view-file", function (e) {
            var ev = $(this);
            if (ev.data("tag") === "view-file") {
                vm.viewFile(ev.data("data"));
            }
        });


        vm.table.on("click", ".action-button", function (e) {
            var ev = $(this);
            if (ev.data("tag") === "button") {
                vm.$emit(`${ev.data("action")}`, {
                    id: ev.data("id"),
                });
            }
        });

        vm.table.on("click", ".filters input", function (e) {
            e.preventDefault();
        });

        vm.table.buttons().container().appendTo('.top-bar .left-side');

        vm.table_ready = true;


        $(document).on('DOMNodeInserted', function(e) {
            if ( $(e.target).hasClass('dt-datetime') ) {
                console.log('added');
                let width = $(e.target).css('width')?parseFloat($(e.target).css('width')):$(e.target).width();
                let offsetX = ( $(window).width() - width - $(e.target).offset().left - 10 );
                if(offsetX < 1){
                    e.target.style.left = ( parseFloat(e.target.style.left) + offsetX )+ "px";
                }

            }
        });

    });
    emitter.on("refresh-dt", function (e) {
        if (e.tableId === vm.tableId) {
            //Refresh Table here
            if (vm.table) {
                vm.table.ajax.reload(null, false);
            }
        }
    });
},
methods: {
    render(data, type, row, meta, ren){
        new Function("return " + ren)();
    },
    getLangFlag(props){
        if(this.$page.props.languages.find(i => i.code === props))
            return this.$page.props.languages.find(i => i.code === props).flag
        return props
    },
    viewFile(e){
        this.currentFile = e;
        this.viewFileModal = true;
    },
    renderRaw(data, type, row){
        return '<div>Test</div>';
    },
    renderActions(data, type, row){
        var regex = /(__\(")(.*?)("\))/g;

        [...data.matchAll(regex)].forEach(e => {
            data =  data.replace(e[0],this.__(e[2]));
        });

        return data;
    },
    renderFileView(data, type, row){
        if(data == null){
            return "";
        }
        let fileArr = data.split(".");
        let file_el = "";
        switch (fileArr[fileArr.length - 1].toLocaleLowerCase()) {
            case 'jpg':
            case 'png':
            case 'jpeg':
            case 'bmp':
            case 'svg':
            case 'gif':
                file_el =  `<div class="view-file" title="${this.__('View Image')}"  data-action="view-file" data-tag="view-file" data-data="${data}"><img class="shadow-md" src="${data}"></div>`;
                break;
            case 'html':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'"  href="'+data+'" ><img class="shadow-md" src="/assets/file_format/html.svg"></a>';
                break;
            case 'mov':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'"  href="'+data+'" ><img class="shadow-md" src="/assets/file_format/mov.svg"></a>';
                break;
            case 'mp3':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'"  href="'+data+'" ><img class="shadow-md" src="/assets/file_format/mp3.svg"></a>';
                break;
            case 'mp4':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/mp4.svg"></a>';
                break;
            case 'mpeg':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/mpeg.svg"></a>';
                break;
            case 'pdf':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/pdf.svg"></a>';
                break;
            case 'ppt':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/ppt.svg"></a>';
                break;
            case 'rar':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/rar.svg"></a>';
                break;
            case 'txt':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/txt.svg"></a>';
                break;
            case 'xml':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/xml.svg"></a>';
                break;
            case 'xsl':
            case 'xsls':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/xsl.svg"></a>';
                break;
            case 'zip':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/zip.svg"></a>';
                break;
            case 'csv':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/csv.svg"></a>';
                break;
            case 'doc':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/doc.svg"></a>';
                break;
            case 'docx':
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/docx.svg"></a>';
                break;
            default:
                file_el =  '<a target="_blank" title="'+this.__('Download File')+'" href="'+data+'" ><img class="shadow-md" src="/assets/file_format/file.svg"></a>';
                break;
        }
        return `<div class="att-file cursor-pointer">${file_el}</div>`;
    },
    updateExHeader(){
        var vm = this;
        let ii = 0;
        let preColspan = 0;
        baseColspan.forEach((e,i) => {
            let newColspan = e;
            for (ii ; ii < preColspan+e; ii++) {
                if($(`#${vm.tableId} thead tr`).eq(1).children( 0 ).eq(ii).hasClass("dtr-hidden"))
                newColspan--;
            }
            preColspan = e;
            $(`#${vm.tableId} thead tr`).eq(0).children( 0 ).eq(i).attr('colspan',newColspan);
        })
    }
},
});
</script>
<style>
/*Overrides for Tailwind CSS */
tfoot {
display: table-header-group;
}
/*Form fields*/
h3.p-4{
padding-bottom: 0rem;
}

.z-10 > div.p-4{
padding-top: 0rem;
}

thead th{
text-align: center;
}
.dataTables_wrapper .dbtbe-id{
width: 90px;
}
.dataTables_wrapper tbody  .dbtbe-id{
text-align:center;
}
.dataTables_wrapper .dataTables_filter input {
color: #4a5568; /*text-gray-700*/
padding-left: 1rem; /*pl-4*/
padding-right: 1rem; /*pl-4*/
padding-top: 0.5rem; /*pl-2*/
padding-bottom: 0.5rem; /*pl-2*/
line-height: 1.25; /*leading-tight*/
border-width: 2px; /*border-2*/
border-radius: 0.25rem;
border-color: #edf2f7; /*border-gray-200*/
background-color: #edf2f7; /*bg-gray-200*/
}
/*Form fields*/
.dataTables_wrapper select {
color: #4a5568; /*text-gray-700*/
padding-left: 2rem; /*pl-4*/
padding-right: 2rem; /*pl-4*/
padding-top: 0.5rem; /*pl-2*/
padding-bottom: 0.5rem; /*pl-2*/
line-height: 1.25; /*leading-tight*/
min-width: 4rem;
border-width: 2px; /*border-2*/
border-radius: 0.25rem;
border-color: #edf2f7; /*border-gray-200*/
background-color: #edf2f7; /*bg-gray-200*/
}

/*Row Hover*/
table.dataTable.hover tbody tr:hover,
table.dataTable.display tbody tr:hover {
background-color: #ebf4ff; /*bg-indigo-100*/
}

/*Pagination Buttons*/
.dataTables_wrapper .dataTables_paginate .paginate_button {
font-weight: 700; /*font-bold*/
border-radius: 0.25rem; /*rounded*/
border: 1px solid transparent; /*border border-transparent*/
}

/*Pagination Buttons - Current selected */
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
color: #fff !important; /*text-white*/
box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); /*shadow*/
font-weight: 700; /*font-bold*/
border-radius: 0.25rem; /*rounded*/
background: #667eea !important; /*bg-indigo-500*/
border: 1px solid transparent; /*border border-transparent*/
}

/*Pagination Buttons - Hover */
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
color: #fff !important; /*text-white*/
box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); /*shadow*/
font-weight: 700; /*font-bold*/
border-radius: 0.15rem; /*rounded*/
background: #667eea !important; /*bg-indigo-500*/
border: 1px solid transparent; /*border border-transparent*/
}

/*Add padding to bottom border */
table.dataTable.no-footer {
border-bottom: 1px solid #e2e8f0; /*border-b-1 border-gray-300*/
margin-top: 0.75em;
margin-bottom: 0.75em;
}

/*Change colour of responsive icon*/
table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before,
table.dataTable.dtr-inline.collapsed > tbody > tr > th:first-child:before {
background-color: #667eea !important; /*bg-indigo-500*/
}
.action-button {
@apply p-2 shadow rounded;
}
.has-search-keyword{
background-color:#ffff91;
}

table.ex-header .right-bor {
border-right: 1px black dashed;
}

table.ex-header thead tr th:first-child {
border-left: 0px black solid;
}

table.ex-header thead tr:first-child th {
border-top: 0px black solid;
border-bottom: 0px;
border-right: 1px black dashed;
}

table.ex-header thead tr th:last-child {
border-top: 0px;
border-right: 0px black solid;
text-align: center !important;;
}

table.dataTable tfoot th, table.dataTable tfoot td {
padding: 6px;
}
.att-file img{
width: 100px;
height: 50px;
}

div.dt-button-background{
    opacity: 0;
}
.dtsb-logicContainer .dtsb-button div{
    -webkit-transform: rotate(270deg);
    -moz-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    transform: rotate(270deg);
}

div.dt-buttons {
    position: unset;
    text-align: unset;
}

button.dt-button {
    margin-right: -5px;
    margin-bottom: 0em;
    padding: 0.4em 0.8em;
    border:unset;
    border-radius:unset;
}
.date-row{
    display: flex;
    flex-direction: column;
}
.child .min-tv .date-row{
    display: inherit;
}
.child .min-tv .date-row span{
    margin-right: 10px;
}

table.dataTable.dtr-column>tbody>tr.parent td.dtr-control:before{
    content: "\f410";
    box-shadow: unset;
    font-family: unset;
    background-color: unset;
    color: black;
    border: unset;
    border-radius: unset;
}

table.dataTable.dtr-column>tbody>tr>td.dtr-control:before{
    content: "\f550";
    box-shadow: unset;
    font-family: unset;
    background-color: unset;
    color: black;
    border: unset;
    border-radius: unset;
}
.dtr-control.fas{
    display: table-cell;
}
</style>
