$(document).ready(function() {
    // Initialize all components
    initializeStatistics();
    initializeInventoryTable();
    initializeTransactionsTable();
    initializeMemberUniformsTable();
    initializeReports();
    initializeModals();
    initializeEventHandlers();
    // Load initial data
    loadStatistics();
    loadMembers();
    loadInventoryItems();
});

// Statistics Management
function initializeStatistics() {
    loadStatistics();
    // Refresh statistics every 30 seconds
    setInterval(loadStatistics, 30000);
}

function loadStatistics() {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getStatistics',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#totalInventoryItems').text(response.data.totalInventoryItems || 0);
                $('#totalSales').text(response.data.totalSales || 0);
                $('#pendingPayments').text(response.data.pendingPayments || 0);
                $('#lowStockItems').text(response.data.lowStockItems || 0);
            }
        },
        error: function() {
            console.error('Failed to load statistics');
        }
    });
}

// Inventory Table Management
function initializeInventoryTable() {
    window.inventoryTable = $('#inventoryTable').DataTable({
        "processing": true,
        "serverSide": true,
        "language": {
            "sProcessing": "جارٍ التحميل...",
            "sLengthMenu": "أظهر _MENU_ سجل",
            "sZeroRecords": "لم يعثر على أية سجلات",
            "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ سجل",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sSearch": "ابحث:",
            "oPaginate": {
                "sFirst": "الأول",
                "sPrevious": "السابق",
                "sNext": "التالي",
                "sLast": "الأخير"
            },
            "sInfoEmpty": "عرض 0 الى 0 من 0 سجل",
            "sInfoFiltered": "(فلترة من اصل _MAX_ )",
            "sInfoPostFix": "",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "جاري التحميل...",
            "oAria": {
                "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
            },
            "buttons": {
                "copy": "نسخ",
                "colvis": "الاختيار",
                "print": "طباعة",
                "excel": "اكسيل",
                "pdf": "بي.دي.اف"
            },
            "select": {
                "rows": {
                    _: "تم تحديد %d أسطر",
                    0: "تفضل بتحديد سطر للتحديد",
                    1: "تم تحديد سطر"
                }
            }
            
        },
        "ajax": {
            "url": "include/api/pages/uniforms.php?action=getInventory",
            "type": "POST",
            "data": function(d) {
                d.token = $('input[name="token"]').val();
            }
        },
        "columns": [
            { "data": "item_name" },
            { "data": "item_type" },
            { "data": "size" },
            { 
                "data": "quantity_in_stock",
                "render": function(data, type, row) {
                    let badgeClass = 'badge-success';
                    if (data <= row.min_stock_level) {
                        badgeClass = 'badge-danger';
                    } else if (data <= row.min_stock_level * 2) {
                        badgeClass = 'badge-warning';
                    }
                    return `<span class="badge ${badgeClass}">${data}</span>`;
                }
            },
            { 
                "data": "unit_price",
                "render": function(data) {
                    return parseFloat(data).toFixed(2) + ' دج';
                }
            },
            { "data": "supplier" },
            { 
                "data": "purchase_date",
                "render": function(data) {
                    return data ? new Date(data).toLocaleDateString('ar-DZ') : '-';
                }
            },
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    let actions = '<div class="btn-group btn-group-sm" role="group">';
                    if (window.edit_uniform) {
                        actions += `<button class="btn btn-outline-primary" onclick="editInventoryItem(${row.id})" title="تعديل">
                                      <i class="fa fa-edit"></i>
                                    </button>`;
                    }
                    if (window.delete_uniform) {
                        actions += `<button class="btn btn-outline-danger" onclick="deleteInventoryItem(${row.id})" title="حذف">
                                      <i class="fa fa-trash"></i>
                                    </button>`;
                    }
                    actions += '</div>';
                    return actions;
                }
            }
        ],
    
        "order": [[0, "asc"]],
        "pageLength": 25,
        "responsive": true
    });
}

// Transactions Table Management
function initializeTransactionsTable() {
    window.transactionsTable = $('#transactionsTable').DataTable({
        "processing": true,
        "language": {
            "sProcessing": "جارٍ التحميل...",
            "sLengthMenu": "أظهر _MENU_ سجل",
            "sZeroRecords": "لم يعثر على أية سجلات",
            "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ سجل",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sSearch": "ابحث:",
            "oPaginate": {
                "sFirst": "الأول",
                "sPrevious": "السابق",
                "sNext": "التالي",
                "sLast": "الأخير"
            },
            "sInfoEmpty": "عرض 0 الى 0 من 0 سجل",
            "sInfoFiltered": "(فلترة من اصل _MAX_ )",
            "sInfoPostFix": "",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "جاري التحميل...",
            "oAria": {
                "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
            },
            "buttons": {
                "copy": "نسخ",
                "colvis": "الاختيار",
                "print": "طباعة",
                "excel": "اكسيل",
                "pdf": "بي.دي.اف"
            },
            "select": {
                "rows": {
                    _: "تم تحديد %d أسطر",
                    0: "تفضل بتحديد سطر للتحديد",
                    1: "تم تحديد سطر"
                }
            }
            
        },
        "serverSide": true,
        "ajax": {
            "url": "include/api/pages/uniforms.php?action=getTransactions",
            "type": "POST",
            "data": function(d) {
                d.token = $('input[name="token"]').val();
                d.transaction_type = $('#transactionTypeFilter').val();
                d.payment_status = $('#paymentStatusFilter').val();
                d.date_from = $('#dateFromFilter').val();
                d.date_to = $('#dateToFilter').val();
            }
        },
        "columns": [
            { "data": "member_id" },
            { 
                "data": null,
                "render": function(data, type, row) {
                    return `${row.item_name} (${row.item_type} - ${row.size})`;
                }
            },
            { 
                "data": "transaction_type",
                "render": function(data) {
                    let badgeClass = 'badge-primary';
                    switch(data) {
                        case 'بيع': badgeClass = 'badge-success'; break;
                        case 'إرجاع': badgeClass = 'badge-warning'; break;
                        case 'تلف': case 'فقدان': badgeClass = 'badge-danger'; break;
                    }
                    return `<span class="badge ${badgeClass}">${data}</span>`;
                }
            },
            { "data": "quantity" },
            { 
                "data": "unit_price",
                "render": function(data) {
                    return parseFloat(data).toFixed(2) + ' دج';
                }
            },
            { 
                "data": "total_amount",
                "render": function(data) {
                    return parseFloat(data).toFixed(2) + ' دج';
                }
            },
            { 
                "data": "payment_status",
                "render": function(data) {
                    let badgeClass = 'badge-danger';
                    if (data === 'مدفوع') badgeClass = 'badge-success';
                    else if (data === 'مدفوع جزئياً') badgeClass = 'badge-warning';
                    return `<span class="badge ${badgeClass}">${data}</span>`;
                }
            },
            { 
                "data": "transaction_date",
                "render": function(data) {
                    return new Date(data).toLocaleDateString('ar-DZ');
                }
            },
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    let actions = '<div class="btn-group btn-group-sm" role="group">';
                    if (window.edit_uniform) {
                        actions += `<button class="btn btn-outline-primary" onclick="editTransaction(${row.id})" title="تعديل">
                                      <i class="fa fa-edit"></i>
                                    </button>`;
                    }
                    actions += `<button class="btn btn-outline-info" onclick="viewTransactionDetails(${row.id})" title="التفاصيل">
                                  <i class="fa fa-eye"></i>
                                </button>`;
                    if (window.delete_uniform) {
                        actions += `<button class="btn btn-outline-danger" onclick="deleteTransaction(${row.id})" title="حذف">
                                      <i class="fa fa-trash"></i>
                                    </button>`;
                    }
                    actions += '</div>';
                    return actions;
                }
            }
        ],
      
        "order": [[7, "desc"]],
        "pageLength": 25,
        "responsive": true
    });

    // Add filters event handlers
    $('#transactionTypeFilter, #paymentStatusFilter, #dateFromFilter, #dateToFilter').on('change', function() {
        window.transactionsTable.ajax.reload();
    });
}

// Member Uniforms Table Management
function initializeMemberUniformsTable() {
    window.memberUniformsTable = $('#memberUniformsTable').DataTable({
        "processing": true,
        "serverSide": true,
        "language": {
            "sProcessing": "جارٍ التحميل...",
            "sLengthMenu": "أظهر _MENU_ سجل",
            "sZeroRecords": "لم يعثر على أية سجلات",
            "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ سجل",
            "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
            "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
            "sSearch": "ابحث:",
            "oPaginate": {
                "sFirst": "الأول",
                "sPrevious": "السابق",
                "sNext": "التالي",
                "sLast": "الأخير"
            },
            "sInfoEmpty": "عرض 0 الى 0 من 0 سجل",
            "sInfoFiltered": "(فلترة من اصل _MAX_ )",
            "sInfoPostFix": "",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "جاري التحميل...",
            "oAria": {
                "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
            },
            "buttons": {
                "copy": "نسخ",
                "colvis": "الاختيار",
                "print": "طباعة",
                "excel": "اكسيل",
                "pdf": "بي.دي.اف"
            },
            "select": {
                "rows": {
                    _: "تم تحديد %d أسطر",
                    0: "تفضل بتحديد سطر للتحديد",
                    1: "تم تحديد سطر"
                }
            }
            
        },
        "ajax": {
            "url": "include/api/pages/uniforms.php?action=getMemberUniforms",
            "type": "POST",
            "data": function(d) {
                d.token = $('input[name="token"]').val();
                d.search_member = $('#memberSearch').val();
            }
        },
        "columns": [
            { "data": "member_id" },
            { "data": "full_name" },
            { 
                "data": "uniforms_owned",
                "render": function(data) {
                    if (!data || data.length === 0) {
                        return '<span class="text-muted">لا توجد أزياء</span>';
                    }
                    let html = '';
                    data.forEach(function(uniform) {
                        html += `<span class="badge badge-info mr-1 mb-1">${uniform.item_type} (${uniform.size})</span>`;
                    });
                    return html;
                }
            },
            { 
                "data": "total_paid",
                "render": function(data) {
                    return parseFloat(data || 0).toFixed(2) + ' دج';
                }
            },
            { 
                "data": "amount_due",
                "render": function(data) {
                    let amount = parseFloat(data || 0);
                    let badgeClass = amount > 0 ? 'badge-danger' : 'badge-success';
                    return `<span class="badge ${badgeClass}">${amount.toFixed(2)} دج</span>`;
                }
            },
            {
                "data": null,
                "orderable": false,
                "render": function(data, type, row) {
                    let actions = '<div class="btn-group btn-group-sm" role="group">';
                    actions += `<button class="btn btn-outline-info" onclick="viewMemberUniformDetails('${row.member_id}')" title="التفاصيل">
                                     <i class="fa fa-eye"></i>
                                   </button>`;
                    if (window.add_uniform) {
                        actions += `<button class="btn btn-outline-success" onclick="addUniformToMember('${row.member_id}')" title="إضافة زي">
                                      <i class="fa fa-plus"></i>
                                    </button>`;
                    }
                    actions += '</div>';
                    return actions;
                }
            }
        ],
    
        "order": [[0, "asc"]],
        "pageLength": 25,
        "responsive": true
    });

    // Member search handler
    $('#memberSearch').on('keyup', function() {
        clearTimeout(window.memberSearchTimeout);
        window.memberSearchTimeout = setTimeout(function() {
            window.memberUniformsTable.ajax.reload();
        }, 500);
    });
}

// Reports Management
function initializeReports() {
    loadSalesByTypeChart();
    loadMonthlySalesChart();
    loadLowStockReport();
}

function loadSalesByTypeChart() {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getSalesByType',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data) {
                const ctx = document.getElementById('salesByTypeChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: response.data.labels,
                        datasets: [{
                            data: response.data.values,
                            backgroundColor: [
                                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        }
    });
}

function loadMonthlySalesChart() {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getMonthlySales',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data) {
                const ctx = document.getElementById('monthlySalesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: response.data.labels,
                        datasets: [{
                            label: 'المبيعات الشهرية',
                            data: response.data.values,
                            borderColor: '#36A2EB',
                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        }
    });
}

function loadLowStockReport() {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getLowStockItems',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data) {
                let tbody = $('#lowStockTable tbody');
                tbody.empty();
                
                response.data.forEach(function(item) {
                    let statusBadge = 'badge-danger';
                    let statusText = 'مخزون منخفض';
                    
                    if (item.quantity_in_stock === 0) {
                        statusBadge = 'badge-dark';
                        statusText = 'نفد المخزون';
                    }
                    
                    tbody.append(`
                        <tr>
                            <td>${item.item_name}</td>
                            <td>${item.item_type}</td>
                            <td>${item.size}</td>
                            <td>${item.quantity_in_stock}</td>
                            <td>${item.min_stock_level}</td>
                            <td><span class="badge ${statusBadge}">${statusText}</span></td>
                        </tr>
                    `);
                });
            }
        }
    });
}

// Modal Management
function initializeModals() {
    // Load members for transaction modal
    loadMembers();
    
    // Load inventory items for selects
    loadInventoryItems();
}

function loadMembers() {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getMembers',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data) {
                let memberSelect = $('#memberSelect');
                memberSelect.empty().append('<option value="">اختر المنخرط</option>');
                
                response.data.forEach(function(member) {
                    memberSelect.append(`<option value="${member.id}">${member.id} - ${member.full_name}</option>`);
                });
            }
        }
    });
}

function loadInventoryItems() {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getInventoryItems',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success && response.data) {
                let inventorySelects = $('#inventorySelect, #stockUpdateForm select[name="inventory_id"]');
                inventorySelects.empty().append('<option value="">اختر الصنف</option>');
                
                response.data.forEach(function(item) {
                    inventorySelects.append(`<option value="${item.id}" data-price="${item.unit_price}">${item.item_name} (${item.item_type} - ${item.size})</option>`);
                });
            }
        }
    });
}

// Event Handlers
function initializeEventHandlers() {
    // Inventory form submission
    $('#saveInventoryItem').on('click', function() {
        saveInventoryItem();
    });
    
    // Update inventory form submission
    $('#updateInventoryItem').on('click', function() {
        updateInventoryItem();
    });
    
    // Transaction form submission
    $('#saveTransaction').on('click', function() {
        saveTransaction();
    });
    
    // Stock update form submission
    $('#updateStock').on('click', function() {
        updateStock();
    });
    
    // Auto-calculate total amount in transaction form
    $('#newTransactionForm input[name="quantity"], #newTransactionForm input[name="unit_price"]').on('input', function() {
        calculateTotalAmount();
    });
    
    // Auto-fill unit price when inventory item is selected
    $('#inventorySelect').on('change', function() {
        let selectedOption = $(this).find('option:selected');
        let price = selectedOption.data('price');
        if (price) {
            $('#newTransactionForm input[name="unit_price"]').val(price);
            calculateTotalAmount();
        }
    });
    
    // Tab change handlers
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        let target = $(e.target).attr('href');
        
        if (target === '#inventory' && window.inventoryTable) {
            window.inventoryTable.columns.adjust().responsive.recalc();
        } else if (target === '#transactions' && window.transactionsTable) {
            window.transactionsTable.columns.adjust().responsive.recalc();
        } else if (target === '#members-uniforms' && window.memberUniformsTable) {
            window.memberUniformsTable.columns.adjust().responsive.recalc();
        } else if (target === '#reports') {
            loadLowStockReport();
        }
    });
}

// Inventory Management Functions
function saveInventoryItem() {
    let formData = new FormData($('#addInventoryForm')[0]);
    formData.append('token', $('input[name="token"]').val());
    
    showLoading();
    
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=addInventoryItem',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            hideLoading();
            
            if (response.success) {
                $('#addInventoryModal').modal('hide');
                $('#addInventoryForm')[0].reset();
                window.inventoryTable.ajax.reload();
                loadStatistics();
                loadInventoryItems();
                
                swal({
                    title: 'تم بنجاح',
                    text: 'تم إضافة الصنف للمخزون بنجاح',
                    icon: 'success',
                    timer: 2000
                });
            } else {
                swal({
                    title: 'خطأ',
                    text: response.message || 'حدث خطأ أثناء إضافة الصنف',
                    icon: 'error'
                });
            }
        },
        error: function() {
            hideLoading();
            swal({
                title: 'خطأ',
                text: 'حدث خطأ في الاتصال بالخادم',
                icon: 'error'
            });
        }
    });
}

function editInventoryItem(id) {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getInventoryItem',
        method: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const item = response.data;
                // Populate the edit form with item data
                $('#editInventoryForm input[name="id"]').val(item.id);
                $('#editInventoryForm input[name="item_name"]').val(item.item_name);
                $('#editInventoryForm select[name="item_type"]').val(item.item_type);
                $('#editInventoryForm select[name="size"]').val(item.size);
                $('#editInventoryForm input[name="quantity_in_stock"]').val(item.quantity_in_stock);
                $('#editInventoryForm input[name="unit_price"]').val(item.unit_price);
                $('#editInventoryForm input[name="supplier"]').val(item.supplier);
                $('#editInventoryForm input[name="purchase_date"]').val(item.purchase_date);
                $('#editInventoryForm textarea[name="notes"]').val(item.notes);
                
                // Show the edit modal
                $('#editInventoryModal').modal('show');
            } else {
                swal({
                    title: 'خطأ',
                    text: response.message || 'حدث خطأ أثناء جلب بيانات الصنف',
                    icon: 'error'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading inventory item:', error);
            swal({
                title: 'خطأ',
                text: 'حدث خطأ في الاتصال بالخادم',
                icon: 'error'
            });
        }
    });
}

function updateInventoryItem() {
    let formData = new FormData($('#editInventoryForm')[0]);
    formData.append('token', $('input[name="token"]').val());
    formData.append('action', 'updateInventoryItem');
    
    showLoading();
    
    $.ajax({
        url: 'include/api/pages/uniforms.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            hideLoading();
            
            if (response.success) {
                $('#editInventoryModal').modal('hide');
                $('#editInventoryForm')[0].reset();
                window.inventoryTable.ajax.reload();
                loadStatistics();
                loadInventoryItems();
                
                swal({
                    title: 'تم بنجاح',
                    text: 'تم تحديث الصنف بنجاح',
                    icon: 'success',
                    timer: 2000
                });
            } else {
                swal({
                    title: 'خطأ',
                    text: response.message || 'حدث خطأ أثناء تحديث الصنف',
                    icon: 'error'
                });
            }
        },
        error: function(xhr, status, error) {
            hideLoading();
            console.error('Error updating inventory item:', error);
            swal({
                title: 'خطأ',
                text: 'حدث خطأ في الاتصال بالخادم',
                icon: 'error'
            });
        }
    });
}

function deleteInventoryItem(id) {
    swal({
        title: 'هل أنت متأكد؟',
        text: 'سيتم حذف هذا الصنف من المخزون نهائياً',
        icon: 'warning',
        buttons: {
            cancel: 'إلغاء',
            confirm: {
                text: 'نعم، احذف',
                className: 'btn-danger'
            }
        },
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: 'include/api/pages/uniforms.php?action=deleteInventoryItem',
                method: 'POST',
                data: {
                    id: id,
                    token: $('input[name="token"]').val()
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.inventoryTable.ajax.reload();
                        loadStatistics();
                        loadInventoryItems();
                        
                        swal({
                            title: 'تم الحذف',
                            text: 'تم حذف الصنف بنجاح',
                            icon: 'success',
                            timer: 2000
                        });
                    } else {
                        swal({
                            title: 'خطأ',
                            text: response.message || 'حدث خطأ أثناء الحذف',
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    swal({
                        title: 'خطأ',
                        text: 'حدث خطأ في الاتصال بالخادم',
                        icon: 'error'
                    });
                }
            });
        }
    });
}

function updateStock() {
    let formData = new FormData($('#stockUpdateForm')[0]);
    formData.append('token', $('input[name="token"]').val());
    formData.append('action', 'updateStock');
    // Fix field name to match what the API expects
    
    showLoading();
    
    $.ajax({
        url: 'include/api/pages/uniforms.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            hideLoading();
            
            if (response.success) {
                $('#stockUpdateModal').modal('hide');
                $('#stockUpdateForm')[0].reset();
                window.inventoryTable.ajax.reload();
                loadStatistics();
                
                swal({
                    title: 'تم بنجاح',
                    text: 'تم تحديث المخزون بنجاح',
                    icon: 'success',
                    timer: 2000
                });
            } else {
                swal({
                    title: 'خطأ',
                    text: response.message || 'حدث خطأ أثناء تحديث المخزون',
                    icon: 'error'
                });
            }
        },
        error: function(xhr, status, error) {
            hideLoading();
            console.error('Error updating stock:', error);
            swal({
                title: 'خطأ',
                text: 'حدث خطأ في الاتصال بالخادم',
                icon: 'error'
            });
        }
    });
}

// Transaction Management Functions
function saveTransaction() {
    let formData = new FormData($('#newTransactionForm')[0]);
    formData.append('token', $('input[name="token"]').val());
    
    showLoading();
    
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=addTransaction',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            hideLoading();
            
            if (response.success) {
                $('#newTransactionModal').modal('hide');
                $('#newTransactionForm')[0].reset();
                window.transactionsTable.ajax.reload();
                window.memberUniformsTable.ajax.reload();
                window.inventoryTable.ajax.reload();
                loadStatistics();
                
                swal({
                    title: 'تم بنجاح',
                    text: 'تم حفظ المعاملة بنجاح',
                    icon: 'success',
                    timer: 2000
                });
            } else {
                swal({
                    title: 'خطأ',
                    text: response.message || 'حدث خطأ أثناء حفظ المعاملة',
                    icon: 'error'
                });
            }
        },
        error: function() {
            hideLoading();
            swal({
                title: 'خطأ',
                text: 'حدث خطأ في الاتصال بالخادم',
                icon: 'error'
            });
        }
    });
}

function calculateTotalAmount() {
    let quantity = parseFloat($('#newTransactionForm input[name="quantity"]').val()) || 0;
    let unitPrice = parseFloat($('#newTransactionForm input[name="unit_price"]').val()) || 0;
    let totalAmount = quantity * unitPrice;
    
    $('#newTransactionForm input[name="total_amount"]').val(totalAmount.toFixed(2));
}

function editTransaction(id) {
    // Implementation for editing transaction
    console.log('Edit transaction:', id);
}

function viewTransactionDetails(id) {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getTransactionDetails',
        method: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const transaction = response.data;
                // Populate the details modal with transaction data
                $('#transactionDetailsModal .modal-title').text(`تفاصيل المعاملة: ${transaction.id}`);
                $('#transactionIdDisplay').text(transaction.id);
                $('#memberNameDisplay').text(transaction.member_name);
                $('#itemNameDisplay').text(`${transaction.item_name} (${transaction.item_type} - ${transaction.size})`);
                $('#transactionTypeDisplay').html(`<span class="badge badge-${getTransactionTypeBadgeClass(transaction.transaction_type)}">${transaction.transaction_type}</span>`);
                $('#quantityDisplay').text(transaction.quantity);
                $('#unitPriceDisplay').text(parseFloat(transaction.unit_price).toFixed(2) + ' دج');
                $('#totalAmountDisplay').text(parseFloat(transaction.total_amount).toFixed(2) + ' دج');
                $('#paymentStatusDisplay').html(`<span class="badge badge-${getPaymentStatusBadgeClass(transaction.payment_status)}">${transaction.payment_status}</span>`);
                $('#amountPaidDisplay').text(parseFloat(transaction.amount_paid).toFixed(2) + ' دج');
                $('#transactionDateDisplay').text(transaction.transaction_date);
                $('#notesDisplay').text(transaction.notes || 'لا توجد ملاحظات');
                
                // Show the details modal
                $('#transactionDetailsModal').modal('show');
            } else {
                swal({
                    title: 'خطأ',
                    text: response.message || 'حدث خطأ أثناء جلب تفاصيل المعاملة',
                    icon: 'error'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading transaction details:', error);
            swal({
                title: 'خطأ',
                text: 'حدث خطأ في الاتصال بالخادم',
                icon: 'error'
            });
        }
    });
}

function deleteTransaction(id) {
    swal({
        title: 'هل أنت متأكد؟',
        text: 'سيتم حذف هذه المعاملة نهائياً',
        icon: 'warning',
        buttons: {
            cancel: 'إلغاء',
            confirm: {
                text: 'نعم، احذف',
                className: 'btn-danger'
            }
        },
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: 'include/api/pages/uniforms.php?action=deleteTransaction',
                method: 'POST',
                data: {
                    id: id,
                    token: $('input[name="token"]').val()
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.transactionsTable.ajax.reload();
                        window.memberUniformsTable.ajax.reload();
                        window.inventoryTable.ajax.reload();
                        loadStatistics();
                        
                        swal({
                            title: 'تم الحذف',
                            text: 'تم حذف المعاملة بنجاح',
                            icon: 'success',
                            timer: 2000
                        });
                    } else {
                        swal({
                            title: 'خطأ',
                            text: response.message || 'حدث خطأ أثناء الحذف',
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    swal({
                        title: 'خطأ',
                        text: 'حدث خطأ في الاتصال بالخادم',
                        icon: 'error'
                    });
                }
            });
        }
    });
}

// Member Uniform Management Functions
function viewMemberUniformDetails(memberId) {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getMemberUniformDetails',
        method: 'GET',
        data: { member_id: memberId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const member = response.data;
                // Populate the details modal with member uniform data
                $('#memberUniformDetailsModal .modal-title').text(`تفاصيل أزياء المنخرط: ${member.full_name}`);
                $('#memberIdDisplay').text(member.member_id);
                $('#memberNameDisplay').text(member.full_name);
                $('#totalPaidDisplay').text(parseFloat(member.total_paid || 0).toFixed(2) + ' دج');
                $('#amountDueDisplay').text(parseFloat(member.amount_due || 0).toFixed(2) + ' دج');
                
                // Populate uniforms table
                const uniformsTableBody = $('#memberUniformsTableBody');
                uniformsTableBody.empty();
                
                if (member.uniforms && member.uniforms.length > 0) {
                    member.uniforms.forEach(function(uniform) {
                        uniformsTableBody.append(`
                            <tr>
                                <td>${uniform.item_name}</td>
                                <td>${uniform.item_type}</td>
                                <td>${uniform.size}</td>
                                <td>${uniform.quantity}</td>
                                <td>${parseFloat(uniform.unit_price).toFixed(2)} دج</td>
                                <td>${parseFloat(uniform.total_amount).toFixed(2)} دج</td>
                                <td>${uniform.transaction_date}</td>
                            </tr>
                        `);
                    });
                } else {
                    uniformsTableBody.append(`
                        <tr>
                            <td colspan="7" class="text-center">لا توجد أزياء لهذا المنخرط</td>
                        </tr>
                    `);
                }
                
                // Show the details modal
                $('#memberUniformDetailsModal').modal('show');
            } else {
                swal({
                    title: 'خطأ',
                    text: response.message || 'حدث خطأ أثناء جلب تفاصيل أزياء المنخرط',
                    icon: 'error'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading member uniform details:', error);
            swal({
                title: 'خطأ',
                text: 'حدث خطأ في الاتصال بالخادم',
                icon: 'error'
            });
        }
    });
}

function addUniformToMember(memberId) {
    // Pre-fill member in transaction modal and open it
    $('#memberSelect').val(memberId);
    $('#newTransactionModal').modal('show');
}

// Utility Functions
function showLoading() {
    $('#loading-overlay').show();
}

function hideLoading() {
    $('#loading-overlay').hide();
}

// Utility functions for badge classes
function getTransactionTypeBadgeClass(type) {
    switch(type) {
        case 'بيع': return 'success';
        case 'إرجاع': return 'warning';
        case 'تلف': 
        case 'فقدان': return 'danger';
        default: return 'primary';
    }
}

function getPaymentStatusBadgeClass(status) {
    switch(status) {
        case 'مدفوع': return 'success';
        case 'مدفوع جزئياً': return 'warning';
        case 'غير مدفوع': return 'danger';
        default: return 'secondary';
    }
}

// Export functions for global access
window.editInventoryItem = editInventoryItem;
window.deleteInventoryItem = deleteInventoryItem;
window.editTransaction = editTransaction;
window.viewTransactionDetails = viewTransactionDetails;
window.deleteTransaction = deleteTransaction;
window.viewMemberUniformDetails = viewMemberUniformDetails;
window.addUniformToMember = addUniformToMember;