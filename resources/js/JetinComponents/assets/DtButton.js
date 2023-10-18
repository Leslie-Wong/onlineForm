(function ($, DataTable, __) {
    "use strict";

    var _buildParams = function (dt, action, onlyVisibles) {
        var params = dt.ajax.params();
        params.action = action;
        params._token = $('meta[name="csrf-token"]').attr('content');

        if (onlyVisibles) {
            params.visible_columns = _getVisibleColumns();
        } else {
            params.visible_columns = null;
        }

        return params;
    };

    var _getVisibleColumns = function () {

        var visible_columns = [];
        $.each(DataTable.settings[0].aoColumns, function (key, col) {
            if (col.bVisible) {
                visible_columns.push(col.name);
            }
        });

        return visible_columns;
    };

    var _downloadFromUrl = function (url, params) {
        var postUrl = url + '/export';
        var xhr = new XMLHttpRequest();
        xhr.open('POST', postUrl, true);
        xhr.responseType = 'arraybuffer';
        xhr.onload = function () {
            if (this.status === 200) {
                var filename = "";
                var disposition = xhr.getResponseHeader('Content-Disposition');
                if (disposition && disposition.indexOf('attachment') !== -1) {
                    var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                    var matches = filenameRegex.exec(disposition);
                    if (matches != null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                }
                var type = xhr.getResponseHeader('Content-Type');

                var blob = new Blob([this.response], {type: type});
                if (typeof window.navigator.msSaveBlob !== 'undefined') {
                    // IE workaround for "HTML7007: One or more blob URLs were revoked by closing the blob for which they were created. These URLs will no longer resolve as the data backing the URL has been freed."
                    window.navigator.msSaveBlob(blob, filename);
                } else {
                    var URL = window.URL || window.webkitURL;
                    var downloadUrl = URL.createObjectURL(blob);

                    if (filename) {
                        // use HTML5 a[download] attribute to specify filename
                        var a = document.createElement("a");
                        // safari doesn't support this yet
                        if (typeof a.download === 'undefined') {
                            window.location = downloadUrl;
                        } else {
                            a.href = downloadUrl;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                        }
                    } else {
                        window.location = downloadUrl;
                    }

                    setTimeout(function () {
                        URL.revokeObjectURL(downloadUrl);
                    }, 100); // cleanup
                }
            }
        };
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send($.param(params));
    };

    var _buildUrl = function(dt, action) {
        var url = dt.ajax.url() || '';
        var params = dt.ajax.params();
        params.action = action;

        if (url.indexOf('?') > -1) {
            return url + '&' + $.param(params);
        }

        return url + '?' + $.param(params);
    };

    // DataTable.ext.buttons.excel = {
    //     className: 'buttons-excel',

    //     text: function (dt) {
    //         return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.excel', 'Excel');
    //     },

    // };

    // DataTable.ext.buttons.importExcel = {
    //     className: 'buttons-excel',

    //     text: function (dt) {
    //         return `<label for="myfile">Select a file:</label>
    //         <input type="file" id="myfile" name="myfile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
    //         <input type="submit">`;
    //     },

    //     action: function (e, dt, button, config) {
    //         // var url = _buildUrl(dt, 'excel');
    //         // window.location = url;
    //     }
    // };

    // DataTable.ext.buttons.postExcel = {
    //     className: 'buttons-excel',

    //     text: function (dt) {
    //         return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.excel', 'Excel');
    //     },

    //     action: function (e, dt, button, config) {
    //         var url = dt.ajax.url() || window.location.href;
    //         var params = _buildParams(dt, 'excel');

    //         _downloadFromUrl(url, params);
    //     }
    // };

    // DataTable.ext.buttons.postExcelVisibleColumns = {
    //     className: 'buttons-excel',

    //     text: function (dt) {
    //         return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.excel', 'Excel (only visible columns)');
    //     },

    //     action: function (e, dt, button, config) {
    //         var url = dt.ajax.url() || window.location.href;
    //         var params = _buildParams(dt, 'excel', true);

    //         _downloadFromUrl(url, params);
    //     }
    // };

    DataTable.ext.buttons.import = {
        extend: 'collection',

        className: 'buttons-import',

        text: function (dt) {
            return `<i class="fa fa-upload"></i> ` + dt.i18n('buttons.import', 'Import') + `&nbsp;<span class="caret"/>`;
        },

        // dom: ['importExcel']
        // action: function (e, dt, button, config) {
        //     $('#myModal').modal('show');
        // }
    };

    DataTable.ext.buttons.tools = {
        extend: 'collection',
        className: 'buttons-tools',
        buttons: [
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
                extend: 'mySearchBuilder'
            },
        ]
    }

    DataTable.ext.buttons.mySearchBuilder = {
        extend: 'searchBuilder',
        config: {
            depthLimit: 1,
        },
        className:'btn btn-default btn-sm no-corner',
        text: '<i class="fas fa-search"></i> ' +  __('DBTAB-title0'),
        action:function (e, dt, node, config) {
            this.popover(config._searchBuilder.getNode(), {
                position: 'flex',
                align: 'container',
                span: 'container'
            });

            var topGroup = config._searchBuilder.s.topGroup;
            // Need to redraw the contents to calculate the correct positions for the elements
            if (topGroup !== undefined) {
                topGroup.dom.container.trigger('dtsb-redrawContents-noDraw');
            }
            if (topGroup.s.criteria.length === 0) {
                $('.' + $.fn.dataTable.Group.classes.add.replace(/ /g, '.')).click();
            }
        }
    };

    DataTable.ext.buttons.export = {
        extend: 'collection',

        className: 'buttons-export',

        buttons: [

            {
                extend: 'csv',
                text: `<svg id="File_Csv_24" width="80" height="24" viewBox="0 0 40 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><rect width="24" height="24" stroke="none" fill="#000000" opacity="0"></rect>
                <g transform="matrix(0.83 0 0 0.83 12 12)">
                <g style="">
                <g transform="matrix(1 0 0 1 0 0)">
                <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -12)" d="M 20.5 23.5 C 21.052284749830793 23.5 21.5 23.052284749830793 21.5 22.5 L 21.5 6.478 C 21.500795910517265 4.892811752949617 20.87164017029034 3.3722763005683714 19.751024031588003 2.2510975094114567 C 18.630407892885668 1.129918718254542 17.110188446860555 0.49999980018981827 15.525000000000002 0.5000000000000018 L 3.5 0.5 C 2.9477152501692068 0.5 2.5 0.9477152501692065 2.5 1.5 L 2.5 22.5 C 2.5 23.052284749830793 2.9477152501692068 23.5 3.5 23.5 Z" stroke-linecap="round"></path>
                </g>
                <g transform="matrix(1 0 0 1 6.96 -8.96)">
                <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-18.96, -3.04)" d="M 16.5 0.584 L 16.5 4.5 C 16.5 5.052284749830793 16.947715250169207 5.5 17.5 5.5 L 21.42 5.5" stroke-linecap="round"></path>
                </g>
                <g transform="matrix(1 0 0 1 -5 3.5)">
                <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-7, -15.5)" d="M 8.5 18.5 C 6.843145750507619 18.5 5.5 17.15685424949238 5.5 15.5 C 5.5 13.84314575050762 6.843145750507619 12.5 8.5 12.5" stroke-linecap="round"></path>
                </g>
                <g transform="matrix(1 0 0 1 0 3.5)">
                <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-12, -15.5)" d="M 13.5 12.5 L 11.8 12.5 C 11.224115708452805 12.49624497796352 10.7143953327098 12.871828243717589 10.547387490124066 13.422977223537174 C 10.380379647538334 13.974126203356759 10.595892653678511 14.569467949874257 11.077 14.886 L 12.917 16.113 C 13.398118564766802 16.4285953161616 13.614538804316306 17.022920985634745 13.449010638540624 17.57398895175267 C 13.283482472764941 18.125056917870598 12.77538890844386 18.501755273822496 12.2 18.5 L 10.5 18.5" stroke-linecap="round"></path>
                </g>
                <g transform="matrix(1 0 0 1 5 3.5)">
                <path style="stroke: rgb(0,0,0); stroke-width: 1; stroke-dasharray: none; stroke-linecap: round; stroke-dashoffset: 0; stroke-linejoin: round; stroke-miterlimit: 4; fill: none; fill-rule: nonzero; opacity: 1;" transform=" translate(-17, -15.5)" d="M 18.5 12.5 L 18.5 14 C 18.5 15.622776601683793 17.973665961010276 17.201778718652964 17 18.5 C 16.026334038989724 17.201778718652964 15.5 15.622776601683793 15.5 14 L 15.5 12.5" stroke-linecap="round"></path>
                </g>
                </g>
                </g>
                <text x="30" y="19" class="small">CSV</text>
                </svg>`
            },
            {
                extend: 'excelHtml5',
                text: `<svg id='File_Excel_24' width='80' height='24' viewBox='0 0 40 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>


                <g transform="matrix(0.77 0 0 0.77 12 12)" >
                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-16, -16)" d="M 6 3 L 6 29 L 26 29 L 26 9.5996094 L 25.699219 9.3007812 L 19.699219 3.3007812 L 19.400391 3 L 6 3 z M 8 5 L 18 5 L 18 11 L 24 11 L 24 27 L 8 27 L 8 5 z M 20 6.4003906 L 22.599609 9 L 20 9 L 20 6.4003906 z M 11 13 L 14.800781 18.5 L 11 24 L 13.400391 24 L 16 20.199219 L 18.599609 24 L 21 24 L 17.199219 18.5 L 21 13 L 18.599609 13 L 16 16.800781 L 13.400391 13 L 11 13 z" stroke-linecap="round" />
                </g>
                <text x="30" y="19" class="small">Excel</text>
                </svg>`
            },
            {
                extend: 'pdfHtml5',
                text: `<svg id='PDF_24' width='80' height='24' viewBox='0 0 40 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>


                <g transform="matrix(0.43 0 0 0.43 12 12)" >
                <path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-25, -25)" d="M 7 2 L 7 48 L 43 48 L 43 15.410156 L 29.183594 2 Z M 9 4 L 28 4 L 28 17 L 41 17 L 41 46 L 9 46 Z M 30 5.578125 L 39.707031 15 L 30 15 Z M 23.769531 19.875 C 23.019531 19.875 22.242188 20.300781 21.902344 20.933594 C 21.558594 21.5625 21.535156 22.238281 21.621094 22.941406 C 21.753906 24.050781 22.257813 25.304688 22.910156 26.589844 C 22.585938 27.683594 22.429688 28.636719 21.941406 29.804688 C 21.320313 31.292969 20.558594 32.472656 19.828125 33.710938 C 18.875 34.15625 17.671875 34.554688 16.96875 35.015625 C 16.179688 35.535156 15.554688 36 15.1875 36.738281 C 15.007813 37.105469 14.914063 37.628906 15.09375 38.101563 C 15.273438 38.574219 15.648438 38.882813 16.035156 39.082031 C 16.855469 39.515625 17.800781 39.246094 18.484375 38.785156 C 19.167969 38.324219 19.777344 37.648438 20.390625 36.824219 C 20.699219 36.40625 20.945313 35.730469 21.25 35.242188 C 22.230469 34.808594 22.925781 34.359375 24.039063 33.976563 C 25.542969 33.457031 26.882813 33.238281 28.289063 32.933594 C 29.464844 33.726563 30.714844 34.34375 32.082031 34.34375 C 32.855469 34.34375 33.453125 34.308594 34.035156 33.992188 C 34.621094 33.675781 34.972656 32.914063 34.972656 32.332031 C 34.972656 31.859375 34.765625 31.355469 34.4375 31.03125 C 34.105469 30.707031 33.714844 30.535156 33.3125 30.425781 C 32.515625 30.210938 31.609375 30.226563 30.566406 30.332031 C 30.015625 30.390625 29.277344 30.683594 28.664063 30.796875 C 28.582031 30.734375 28.503906 30.707031 28.421875 30.636719 C 27.175781 29.5625 26.007813 28.078125 25.140625 26.601563 C 25.089844 26.511719 25.097656 26.449219 25.046875 26.359375 C 25.257813 25.570313 25.671875 24.652344 25.765625 23.960938 C 25.894531 23.003906 25.921875 22.167969 25.691406 21.402344 C 25.574219 21.019531 25.378906 20.632813 25.039063 20.335938 C 24.699219 20.039063 24.21875 19.875 23.769531 19.875 Z M 23.6875 21.867188 C 23.699219 21.867188 23.71875 21.875 23.734375 21.878906 C 23.738281 21.886719 23.746094 21.882813 23.777344 21.980469 C 23.832031 22.164063 23.800781 22.683594 23.78125 23.144531 C 23.757813 23.027344 23.621094 22.808594 23.609375 22.703125 C 23.550781 22.238281 23.625 21.941406 23.65625 21.890625 C 23.664063 21.871094 23.675781 21.867188 23.6875 21.867188 Z M 24.292969 28.882813 C 24.910156 29.769531 25.59375 30.597656 26.359375 31.359375 C 25.335938 31.632813 24.417969 31.730469 23.386719 32.085938 C 23.167969 32.160156 23.042969 32.265625 22.828125 32.34375 C 23.132813 31.707031 23.511719 31.234375 23.785156 30.578125 C 24.035156 29.980469 24.078125 29.476563 24.292969 28.882813 Z" stroke-linecap="round" />
                </g>
                <text x="30" y="19" class="small">PDF</text>
                </svg>`,
                action: async function (e, dt, button, config) {
                    this.processing(true);

                    var that = this;
                    var data = dt.buttons.exportData(config.exportOptions);
                    var info = dt.buttons.exportInfo(config);
                    var rows = [];

                    if (config.header) {
                        rows.push(
                            $.map(data.header, function (d) {
                                return {
                                    text: typeof d === 'string' ? d : d + '',
                                    style: 'tableHeader'
                                };
                            })
                        );
                    }

                    for (var i = 0, ien = data.body.length; i < ien; i++) {
                        rows.push(
                            $.map(data.body[i], function (d) {
                                if (d === null || d === undefined) {
                                    d = '';
                                }
                                return {
                                    text: typeof d === 'string' ? d : d + '',
                                    style: i % 2 ? 'tableBodyEven' : 'tableBodyOdd'
                                };
                            })
                        );
                    }

                    if (config.footer && data.footer) {
                        rows.push(
                            $.map(data.footer, function (d) {
                                return {
                                    text: typeof d === 'string' ? d : d + '',
                                    style: 'tableFooter'
                                };
                            })
                        );
                    }

                    var doc = {
                        pageSize: config.pageSize,
                        pageOrientation: config.orientation,
                        content: [
                            {
                                table: {
                                    headerRows: 1,
                                    body: rows
                                },
                                layout: 'noBorders'
                            }
                        ],
                        styles: {
                            tableHeader: {
                                bold: true,
                                fontSize: 11,
                                color: 'white',
                                fillColor: '#2d4154',
                                alignment: 'center'
                            },
                            tableBodyEven: {},
                            tableBodyOdd: {
                                fillColor: '#f3f3f3'
                            },
                            tableFooter: {
                                bold: true,
                                fontSize: 11,
                                color: 'white',
                                fillColor: '#2d4154'
                            },
                            title: {
                                alignment: 'center',
                                fontSize: 15
                            },
                            message: {}
                        },
                        defaultStyle: {
                            fontSize: 10
                        }
                    };

                    if (info.messageTop) {
                        doc.content.unshift({
                            text: info.messageTop,
                            style: 'message',
                            margin: [0, 0, 0, 12]
                        });
                    }

                    if (info.messageBottom) {
                        doc.content.push({
                            text: info.messageBottom,
                            style: 'message',
                            margin: [0, 0, 0, 12]
                        });
                    }

                    if (info.title) {
                        doc.content.unshift({
                            text: info.title,
                            style: 'title',
                            margin: [0, 0, 0, 12]
                        });
                    }

                    if (config.customize) {
                       await config.customize(doc, config, dt);
                    }



                    var pdf = window.pdfMake.createPdf(doc);

                    if (config.download === 'open' && !_isDuffSafari()) {
                        pdf.open();
                    }
                    else {
                        pdf.download(info.filename);
                    }

                    this.processing(false);
                },
                customize: async function ( doc ) {
                    console.log(" start loading");
                    await loadScript(window.location.origin + "/assets/fonts/vfs_fonts.js")
                    .then( data  => {
                        console.log(" start loaded");
                        window.pdfMake.fonts = {
                            AlibabaPuHuiTi: {
                                normal: 'AlibabaPuHuiTi-3-55-Regular.woff2',
                                bold: 'AlibabaPuHuiTi-3-55-Regular.woff2',
                                italics: 'AlibabaPuHuiTi-3-55-Regular.woff2',
                                bolditalics: 'AlibabaPuHuiTi-3-55-Regular.woff2'
                            }
                        }
                        doc.defaultStyle = {...doc.defaultStyle, font: 'AlibabaPuHuiTi'}
                        console.log("Script loaded successfully", data);
                    })
                    .catch( err => {
                        console.error(err);
                    });

                    console.log(" end ~~~");
                }
            },
        ]
    };

    // DataTable.ext.buttons.csv = {
    //     className: 'buttons-csv',

    //     text: function (dt) {
    //         return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.csv', 'CSV');
    //     },

    //     action: function (e, dt, button, config) {
    //         var url = _buildUrl(dt, 'csv');
    //         window.location = url;
    //     }
    // };

    // DataTable.ext.buttons.postCsvVisibleColumns = {
    //     className: 'buttons-csv',

    //     text: function (dt) {
    //         return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.csv', 'CSV (only visible columns)');
    //     },

    //     action: function (e, dt, button, config) {
    //         var url = dt.ajax.url() || window.location.href;
    //         var params = _buildParams(dt, 'csv', true);

    //         _downloadFromUrl(url, params);
    //     }
    // };

    // DataTable.ext.buttons.postCsv = {
    //     className: 'buttons-csv',

    //     text: function (dt) {
    //         return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.csv', 'CSV');
    //     },

    //     action: function (e, dt, button, config) {
    //         var url = dt.ajax.url() || window.location.href;
    //         var params = _buildParams(dt, 'csv');

    //         _downloadFromUrl(url, params);
    //     }
    // };

    DataTable.ext.buttons.pdf = {
        className: 'buttons-pdf',

        text: function (dt) {
            return '<i class="far fa-file-pdf"></i> ' + dt.i18n('buttons.pdf', 'PDF');
        },
        action: async function (e, dt, button, config) {
            this.processing(true);

            var that = this;
            var data = dt.buttons.exportData(config.exportOptions);
            var info = dt.buttons.exportInfo(config);
            var rows = [];

            if (config.header) {
                rows.push(
                    $.map(data.header, function (d) {
                        return {
                            text: typeof d === 'string' ? d : d + '',
                            style: 'tableHeader'
                        };
                    })
                );
            }

            for (var i = 0, ien = data.body.length; i < ien; i++) {
                rows.push(
                    $.map(data.body[i], function (d) {
                        if (d === null || d === undefined) {
                            d = '';
                        }
                        return {
                            text: typeof d === 'string' ? d : d + '',
                            style: i % 2 ? 'tableBodyEven' : 'tableBodyOdd'
                        };
                    })
                );
            }

            if (config.footer && data.footer) {
                rows.push(
                    $.map(data.footer, function (d) {
                        return {
                            text: typeof d === 'string' ? d : d + '',
                            style: 'tableFooter'
                        };
                    })
                );
            }

            var doc = {
                pageSize: config.pageSize,
                pageOrientation: config.orientation,
                content: [
                    {
                        table: {
                            headerRows: 1,
                            body: rows
                        },
                        layout: 'noBorders'
                    }
                ],
                styles: {
                    tableHeader: {
                        bold: true,
                        fontSize: 11,
                        color: 'white',
                        fillColor: '#2d4154',
                        alignment: 'center'
                    },
                    tableBodyEven: {},
                    tableBodyOdd: {
                        fillColor: '#f3f3f3'
                    },
                    tableFooter: {
                        bold: true,
                        fontSize: 11,
                        color: 'white',
                        fillColor: '#2d4154'
                    },
                    title: {
                        alignment: 'center',
                        fontSize: 15
                    },
                    message: {}
                },
                defaultStyle: {
                    fontSize: 10
                }
            };

            if (info.messageTop) {
                doc.content.unshift({
                    text: info.messageTop,
                    style: 'message',
                    margin: [0, 0, 0, 12]
                });
            }

            if (info.messageBottom) {
                doc.content.push({
                    text: info.messageBottom,
                    style: 'message',
                    margin: [0, 0, 0, 12]
                });
            }

            if (info.title) {
                doc.content.unshift({
                    text: info.title,
                    style: 'title',
                    margin: [0, 0, 0, 12]
                });
            }

            if (config.customize) {
               await config.customize(doc, config, dt);
            }



            var pdf = window.pdfMake.createPdf(doc);

            if (config.download === 'open' && !_isDuffSafari()) {
                pdf.open();
            }
            else {
                pdf.download(info.filename);
            }

            this.processing(false);
        },
        customize: async function ( doc ) {
        //    await loadScript(window.location.origin + "/assets/fonts/vfs_fonts.js")
        //     .then( data  => {
        //         window.pdfMake.fonts = {
        //             Hyzh: {
        //                 normal: 'hyzjh_zh.ttf',
        //                 bold: 'hylxt_bold.ttf',
        //                 italics: 'hyzjh_zh.ttf',
        //                 bolditalics: 'hylxt_bold.ttf'
        //             },
        //             Roboto: {
        //                 normal: 'Roboto-Regular.ttf',
        //                 bold: 'Roboto-Medium.ttf',
        //                 italics: 'Roboto-Italic.ttf',
        //                 bolditalics: 'Roboto-MediumItalic.ttf'
        //             }
        //         }
        //         doc.defaultStyle = {...doc.defaultStyle, font: 'Hyzh'}
        //         console.log("Script loaded successfully", data);
        //     })
        //     .catch( err => {
        //         console.error(err);
        //     });
        },

        // action: function (e, dt, button, config) {
        //     loadScript(window.location.origin + "/assets/font/vfs_fonts.js")
        //     .then( data  => {
        //         window.pdfMake.fonts = {
        //             Hyzh: {
        //                 normal: 'hyzjh_zh.ttf',
        //                 bold: 'hylxt_bold.ttf',
        //                 italics: 'hyzjh_zh.ttf',
        //                 bolditalics: 'hylxt_bold.ttf'
        //             },
        //             Roboto: {
        //                 normal: 'Roboto-Regular.ttf',
        //                 bold: 'Roboto-Medium.ttf',
        //                 italics: 'Roboto-Italic.ttf',
        //                 bolditalics: 'Roboto-MediumItalic.ttf'
        //             }
        //         }
        //         console.log("Script loaded successfully", data);
        //     })
        //     .catch( err => {
        //         console.error(err);
        //     });
        // }
    };

    // DataTable.ext.buttons.postPdf = {
    //     className: 'buttons-pdf',

    //     text: function (dt) {
    //         return '<i class="fa fa-file-pdf-o"></i> ' + dt.i18n('buttons.pdf', 'PDF');
    //     },

    //     action: function (e, dt, button, config) {
    //         var url = dt.ajax.url() || window.location.href;
    //         var params = _buildParams(dt, 'pdf');

    //         _downloadFromUrl(url, params);
    //     }
    // };

    // DataTable.ext.buttons.print = {
    //     className: 'buttons-print',

    //     text: function (dt) {
    //         return  '<i class="fa fa-print"></i> ' + dt.i18n('buttons.print', 'Print');
    //     },

    //     action: function (e, dt, button, config) {
    //         var url = _buildUrl(dt, 'print');
    //         window.location = url;
    //     }
    // };

    // DataTable.ext.buttons.reset = {
    //     className: 'buttons-reset',

    //     text: function (dt) {
    //         return '<i class="fa fa-undo"></i> ' + dt.i18n('buttons.reset', 'Reset');
    //     },

    //     action: function (e, dt, button, config) {
    //         dt.search('');
    //         dt.columns().search('');
    //         dt.draw();
    //     }
    // };

    DataTable.ext.buttons.reload = {
        className: 'buttons-reload',

        action: function (e, dt, button, config) {
            dt.draw(false);
        }
    };

    DataTable.ext.buttons.create = {
        className: 'buttons-create',

        text: function (dt) {
            return '<i class="fa fa-plus"></i> ' + dt.i18n('buttons.create', 'Create');
        },

        action: function (e, dt, button, config) {
            window.location = window.location.href.replace(/\/+$/, "") + '/create';
        }
    };

    const loadScript = (FILE_URL, async = true, type = "text/javascript") => {
        return new Promise((resolve, reject) => {
            try {
                const scriptEle = document.createElement("script");
                scriptEle.type = type;
                scriptEle.async = async;
                scriptEle.src =FILE_URL;

                scriptEle.addEventListener("load", (ev) => {
                    resolve({ status: true });
                });

                scriptEle.addEventListener("error", (ev) => {
                    reject({
                        status: false,
                        message: `Failed to load the script ＄{FILE_URL}`
                    });
                });

                document.body.appendChild(scriptEle);
            } catch (error) {
                reject(error);
            }
        });
    };

    // if (typeof DataTable.ext.buttons.copyHtml5 !== 'undefined') {
    //     $.extend(DataTable.ext.buttons.copyHtml5, {
    //         text: function (dt) {
    //             return '<i class="fa fa-copy"></i> ' + dt.i18n('buttons.copy', 'Copy');
    //         }
    //     });
    // }

    if (typeof DataTable.ext.buttons.colvis !== 'undefined') {
        $.extend(DataTable.ext.buttons.colvis, {
            text: function (dt) {
                return '<i class="fa fa-eye"></i> ' + dt.i18n('buttons.colvis', 'Column visibility');
            }
        });
    }
})(jQuery, jQuery.fn.dataTable, __);
