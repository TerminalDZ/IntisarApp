$(document).ready(function () {
    // Initialize DataTable with proper configuration
    var table = $("#UniformsTable").DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "/include/api/pages/uniforms.php",
            type: "POST",
            data: function(d) {
                d.action = 'getUniforms';
                d.csrf_token = $('input[name="csrf_token"]').val();
                d.uniformType = $('#uniformTypeFilter').val();
                d.paymentStatus = $('#paymentStatusFilter').val();
                d.search = $('#globalSearch').val();
            },
            beforeSend: function() {
                $('#loading-overlay').show();
            },
            complete: function() {
                $('#loading-overlay').hide();
            },
            dataSrc: function(response) {
                return response.data || [];
            }
        },
        columns: [
            { 
                data: "member.member_id",
                width: "15%",
                render: function(data, type, row) {
                    if (type === 'display') {
                        return `<div class="uniforms-info" data-member-id="${data}">
                            <i class="fa fa-chevron-down mr-1"></i>
                            ${data}
                            <span class="badge badge-primary ml-1">${row.uniforms.length}</span>
                        </div>`;
                    }
                    return data;
                }
            },
            { 
                data: "member",
                width: "20%",
                render: function(data, type, row) {
                    if (type === 'display') {
                        return `<strong>${data.first_name} ${data.last_name}</strong>`;
                    }
                    return data.first_name + ' ' + data.last_name;
                }
            },
            { 
                data: null,
                width: "65%",
                defaultContent: "",
                orderable: false,
                render: function(data, type, row) {
                    if (type === 'display') {
                        return renderUniformDetails(row.uniforms);
                    }
                    return '';
                }
            }
        ],
        order: [[0, "desc"]],
        language: {
            processing: "جارٍ التحميل...",
            search: "بحث:",
            lengthMenu: "عرض _MENU_ سجل",
            info: "عرض _START_ إلى _END_ من _TOTAL_ سجل",
            infoEmpty: "لا توجد سجلات متاحة",
            infoFiltered: "(تمت التصفية من _MAX_ سجل)",
            loadingRecords: "جارٍ التحميل...",
            zeroRecords: "لم يتم العثور على سجلات",
            emptyTable: "لا توجد بيانات متاحة في الجدول",
            paginate: {
                first: "الأول",
                previous: "السابق",
                next: "التالي",
                last: "الأخير"
            }
        },
        dom: '<"top d-flex justify-content-between"<"mr-2"B><"d-flex"f>>rt<"bottom"lip><"clear">',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o mr-1"></i> تصدير Excel',
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: [0, 1],
                    format: {
                        body: function (data, row, column) {
                            return $(data).text().trim();
                        }
                    }
                },
                title: 'قائمة الأزياء الكشفية - ' + new Date().toLocaleDateString('ar-SA')
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print mr-1"></i> طباعة',
                className: 'btn btn-info btn-sm',
                exportOptions: {
                    columns: [0, 1],
                    format: {
                        body: function (data, row, column) {
                            return $(data).text().trim();
                        }
                    }
                },
                title: 'قائمة الأزياء الكشفية',
                customize: function (win) {
                    $(win.document.body).addClass('rtl');
                    $(win.document.body).css('font-size', '10pt');
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ],
        responsive: true,
        initComplete: function() {
            // Move filters to the top right of the datatable
            var filterContainer = $('<div class="dataTables_filter_custom d-flex mr-2"></div>');
            $('#uniformTypeFilter, #paymentStatusFilter').appendTo(filterContainer);
            filterContainer.insertBefore($('.dataTables_filter'));
            
            // Apply Bootstrap classes
            $('.dataTables_filter input').addClass('form-control form-control-sm');
            $('.dataTables_length select').addClass('form-control form-control-sm');
        }
    });

    // Function to render uniform details
    function renderUniformDetails(uniforms) {
        return `<div class="uniform-details">
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>نوع الزي</th>
                            <th>المقاس</th>
                            <th>السعر</th>
                            <th>حالة الدفع</th>
                            <th>حالة الاستلام</th>
                            <th>تاريخ الإضافة</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${uniforms.map(uniform => `
                            <tr>
                                <td><i class="fa fa-tshirt mr-1"></i>${uniform.uniform_type}</td>
                                <td><span class="badge badge-info">${uniform.size}</span></td>
                                <td>${uniform.amount_paid} دج</td>
                                <td>${uniform.paid == "1" ? 
                                    '<span class="badge badge-success"><i class="fa fa-check mr-1"></i> مدفوع</span>' : 
                                    '<span class="badge badge-danger"><i class="fa fa-times mr-1"></i> غير مدفوع</span>'
                                }</td>
                                <td>${uniform.received == "1" ? 
                                    '<span class="badge badge-success"><i class="fa fa-check mr-1"></i> مستلم</span>' : 
                                    '<span class="badge badge-danger"><i class="fa fa-times mr-1"></i> غير مستلم</span>'
                                }</td>
                                <td>${moment(uniform.created_at).format('DD/MM/YYYY HH:mm')}</td>
                                <td>${uniform.note ? 
                                    `<button class="btn btn-primary btn-sm show-note" data-note="${uniform.note.replace(/"/g, '&quot;')}">
                                        <i class="fa fa-sticky-note"></i>
                                    </button>` : 
                                    '<span class="text-muted">-</span>'
                                }</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        </div>`;
    }

    // Handle click on uniforms info row
    $('#UniformsTable tbody').on('click', '.uniforms-info', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var icon = $(this).find('i');
        
        if (row.child.isShown()) {
            // Close the row
            row.child.hide();
            tr.removeClass('shown');
            icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
        } else {
            // Open the row
            row.child(renderUniformDetails(row.data().uniforms)).show();
            tr.addClass('shown');
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }
    });

    // Handle click on notes button
    $('#UniformsTable').on('click', '.show-note', function(e) {
        e.stopPropagation();
        var note = $(this).data('note');
        $('#noteContent').text(note);
        $('#notesModal').modal('show');
    });

    // Refresh table data periodically (every 5 minutes)
    setInterval(function() {
        table.ajax.reload(null, false);
    }, 300000);

    // Filter handlers
    $('#uniformTypeFilter').on('change', function() {
        applyFilters();
    });

    $('#paymentStatusFilter').on('change', function() {
        applyFilters();
    });

    $('#globalSearch').on('keyup', function() {
        table.search($(this).val()).draw();
    });

    // Apply all filters
    function applyFilters() {
        table.ajax.reload();
        
        // Apply custom filtering (client-side)
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var row = table.row(dataIndex).data();
                
                // Type filter
                var typeFilter = $('#uniformTypeFilter').val();
                if (typeFilter && typeFilter !== '') {
                    var matchFound = false;
                    for (var i = 0; i < row.uniforms.length; i++) {
                        if (row.uniforms[i].uniform_type === typeFilter) {
                            matchFound = true;
                            break;
                        }
                    }
                    if (!matchFound) return false;
                }
                
                // Payment status filter
                var paymentFilter = $('#paymentStatusFilter').val();
                if (paymentFilter && paymentFilter !== '') {
                    var matchFound = false;
                    for (var i = 0; i < row.uniforms.length; i++) {
                        if (row.uniforms[i].paid === paymentFilter) {
                            matchFound = true;
                            break;
                        }
                    }
                    if (!matchFound) return false;
                }
                
                return true;
            }
        );
        
        table.draw();
        
        // Clear custom filter after application
        $.fn.dataTable.ext.search.pop();
    }

    // Initial table setup - show all expanded rows by default
    setTimeout(function() {
        table.rows().every(function(rowIdx, tableLoop, rowLoop) {
            var data = this.data();
            var tr = $(this.node());
            var icon = tr.find('.uniforms-info i');
            
            this.child(renderUniformDetails(data.uniforms)).show();
            tr.addClass('shown');
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
        });
    }, 500);
});