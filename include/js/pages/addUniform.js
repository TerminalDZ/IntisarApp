$(document).ready(function() {
    // Initialize the form
    initializeForm();
    
    // Load initial data
    loadMembers();
    loadInventoryItems();
    
    // Event handlers
    setupEventHandlers();
});

function initializeForm() {
    // Initialize Select2
    $('#member_id').select2({
        placeholder: 'اختر المنخرط',
        allowClear: true,
        width: '100%'
    });
    
    $('#inventory_id').select2({
        placeholder: 'اختر الصنف',
        allowClear: true,
        width: '100%'
    });
    
    // Set default values
    $('#transaction_date').val(new Date().toISOString().split('T')[0]);
    $('#quantity').val(1);
    $('#discount').val(0);
}

function setupEventHandlers() {
    // Transaction type change
    $('#transaction_type').on('change', function() {
        const transactionType = $(this).val();
        
        if (transactionType === 'بيع') {
            $('#paymentSection').show();
            $('#payment_status').prop('required', true);
        } else {
            $('#paymentSection').hide();
            $('#payment_status').prop('required', false);
        }
        
        // Reset payment fields
        $('#payment_status').val('مدفوع');
        $('#amount_paid').val('');
        updateAmountPaid();
    });
    
    // Inventory selection change
    $('#inventory_id').on('change', function() {
        const inventoryId = $(this).val();
        if (inventoryId) {
            loadInventoryDetails(inventoryId);
        } else {
            $('#inventoryInfo').hide();
            $('#unit_price').val('');
        }
    });
    
    // Quantity and price changes
    $('#quantity, #unit_price, #discount').on('input', function() {
        calculateTotal();
    });
    
    // Payment status change
    $('#payment_status').on('change', function() {
        updateAmountPaid();
    });
    
    // Form submission
    $('#uniformTransactionForm').on('submit', function(e) {
        e.preventDefault();
        submitForm();
    });
}

function loadMembers() {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getMembers',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const memberSelect = $('#member_id');
                memberSelect.empty().append('<option value="">اختر المنخرط</option>');
                
                response.data.forEach(function(member) {
                    memberSelect.append(`<option value="${member.id}">${member.full_name} - ${member.id}</option>`);
                });
            } else {
                showAlert('error', response.message || 'حدث خطأ في تحميل بيانات المنخرطين');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading members:', error);
            showAlert('error', 'حدث خطأ في تحميل بيانات المنخرطين');
        }
    });
}

function loadInventoryItems() {
    $.ajax({
        url: 'include/api/pages/uniforms.php?action=getInventoryItems',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const inventorySelect = $('#inventory_id');
                inventorySelect.empty().append('<option value="">اختر الصنف</option>');
                
                response.data.forEach(function(item) {
                    inventorySelect.append(`<option value="${item.id}" data-price="${item.unit_price}" data-stock="${item.quantity_in_stock}">${item.item_name} - ${item.item_type} (${item.size}) - متوفر: ${item.quantity_in_stock}</option>`);
                });
            } else {
                showAlert('error', response.message || 'حدث خطأ في تحميل بيانات المخزون');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading inventory items:', error);
            showAlert('error', 'حدث خطأ في تحميل بيانات المخزون');
        }
    });
}

function loadInventoryDetails(inventoryId) {
    $.ajax({
        url: 'include/api/pages/uniforms.php',
        type: 'POST',
        data: {
            action: 'getInventoryDetails',
            inventory_id: inventoryId,
            token: $('input[name="token"]').val()
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const item = response.data;
                
                // Set unit price
                $('#unit_price').val(item.unit_price);
                
                // Show inventory info
                $('#stockInfo').text(`المتوفر في المخزون: ${item.quantity_in_stock} قطعة`);
                $('#inventoryInfo').show();
                
                // Calculate total
                calculateTotal();
            } else {
                // Fallback: get price from option data
                const selectedOption = $('#inventory_id option:selected');
                const price = selectedOption.data('price');
                if (price) {
                    $('#unit_price').val(price);
                    calculateTotal();
                }
                showAlert('error', response.message || 'حدث خطأ في تحميل تفاصيل الصنف');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading inventory details:', error);
            // Fallback: get price from option data
            const selectedOption = $('#inventory_id option:selected');
            const price = selectedOption.data('price');
            if (price) {
                $('#unit_price').val(price);
                calculateTotal();
            }
            showAlert('error', 'حدث خطأ في تحميل تفاصيل الصنف');
        }
    });
}

function calculateTotal() {
    const quantity = parseFloat($('#quantity').val()) || 0;
    const unitPrice = parseFloat($('#unit_price').val()) || 0;
    const discount = parseFloat($('#discount').val()) || 0;
    
    const subtotal = quantity * unitPrice;
    const total = subtotal - discount;
    
    $('#total_amount').val(total.toFixed(2));
    
    // Update amount paid if payment status is 'مدفوع'
    updateAmountPaid();
}

function updateAmountPaid() {
    const paymentStatus = $('#payment_status').val();
    const totalAmount = parseFloat($('#total_amount').val()) || 0;
    
    if (paymentStatus === 'مدفوع') {
        $('#amount_paid').val(totalAmount.toFixed(2));
    } else if (paymentStatus === 'غير مدفوع') {
        $('#amount_paid').val('0.00');
    }
    // For 'مدفوع جزئياً', leave amount_paid as is for manual entry
}

function submitForm() {
    // Validate form
    if (!validateForm()) {
        return;
    }
    
    // Show loading state
    const submitBtn = $('#submitBtn');
    const originalText = submitBtn.html();
    submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>جاري الحفظ...').prop('disabled', true);
    
    // Prepare form data
    const formData = new FormData($('#uniformTransactionForm')[0]);
    formData.append('action', 'addTransaction');
    formData.append('token', $('input[name="token"]').val());
    
    $.ajax({
        url: 'include/api/pages/uniforms.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                
                // Reset form after successful submission
                setTimeout(function() {
                    resetForm();
                }, 1500);
            } else {
                showAlert('error', response.message || 'حدث خطأ أثناء حفظ المعاملة');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            showAlert('error', 'خطأ في الاتصال بالخادم');
        },
        complete: function() {
            // Restore button state
            submitBtn.html(originalText).prop('disabled', false);
        }
    });
}

function validateForm() {
    let isValid = true;
    const requiredFields = [
        { field: '#transaction_type', message: 'يرجى اختيار نوع المعاملة' },
        { field: '#member_id', message: 'يرجى اختيار المنخرط' },
        { field: '#inventory_id', message: 'يرجى اختيار الصنف' },
        { field: '#quantity', message: 'يرجى إدخال الكمية' },
        { field: '#unit_price', message: 'يرجى إدخال سعر الوحدة' }
    ];
    
    // Clear previous validation states
    $('.form-control, .form-select').removeClass('is-invalid');
    
    // Check required fields
    requiredFields.forEach(function(item) {
        const field = $(item.field);
        if (!field.val() || field.val().trim() === '') {
            field.addClass('is-invalid');
            showAlert('error', item.message);
            isValid = false;
        }
    });
    
    // Validate quantity
    const quantity = parseInt($('#quantity').val());
    if (quantity <= 0) {
        $('#quantity').addClass('is-invalid');
        showAlert('error', 'الكمية يجب أن تكون أكبر من الصفر');
        isValid = false;
    }
    
    // Validate unit price
    const unitPrice = parseFloat($('#unit_price').val());
    if (unitPrice < 0) {
        $('#unit_price').addClass('is-invalid');
        showAlert('error', 'سعر الوحدة لا يمكن أن يكون سالباً');
        isValid = false;
    }
    
    // Validate payment for sales transactions
    const transactionType = $('#transaction_type').val();
    if (transactionType === 'بيع') {
        const paymentStatus = $('#payment_status').val();
        const amountPaid = parseFloat($('#amount_paid').val()) || 0;
        const totalAmount = parseFloat($('#total_amount').val()) || 0;
        
        if (paymentStatus === 'مدفوع' && amountPaid < totalAmount) {
            $('#amount_paid').addClass('is-invalid');
            showAlert('error', 'المبلغ المدفوع يجب أن يساوي المبلغ الإجمالي للمعاملات المدفوعة');
            isValid = false;
        }
        
        if (paymentStatus === 'مدفوع جزئياً' && (amountPaid <= 0 || amountPaid >= totalAmount)) {
            $('#amount_paid').addClass('is-invalid');
            showAlert('error', 'المبلغ المدفوع يجب أن يكون أكبر من الصفر وأقل من المبلغ الإجمالي للمعاملات المدفوعة جزئياً');
            isValid = false;
        }
    }
    
    return isValid;
}

function resetForm() {
    // Reset form fields
    $('#uniformTransactionForm')[0].reset();
    
    // Reset Select2 fields
    $('#member_id').val(null).trigger('change');
    $('#inventory_id').val(null).trigger('change');
    
    // Hide sections
    $('#paymentSection').hide();
    $('#inventoryInfo').hide();
    
    // Reset default values
    $('#transaction_date').val(new Date().toISOString().split('T')[0]);
    $('#quantity').val(1);
    $('#discount').val(0);
    $('#total_amount').val('');
    
    // Clear validation states
    $('.form-control, .form-select').removeClass('is-invalid');
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="fas ${iconClass} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('#alertContainer').html(alertHtml);
    
    // Auto-hide success alerts after 5 seconds
    if (type === 'success') {
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    }
    
    // Scroll to top to show alert
    $('html, body').animate({ scrollTop: 0 }, 300);
}

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('ar-SA', {
        style: 'currency',
        currency: 'SAR'
    }).format(amount);
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('ar-SA');
}

// Handle page unload warning if form has unsaved changes
let formChanged = false;

$('#uniformTransactionForm input, #uniformTransactionForm select, #uniformTransactionForm textarea').on('change input', function() {
    formChanged = true;
});

$('#uniformTransactionForm').on('submit', function() {
    formChanged = false;
});

$(window).on('beforeunload', function(e) {
    if (formChanged) {
        const message = 'لديك تغييرات غير محفوظة. هل تريد المغادرة؟';
        e.returnValue = message;
        return message;
    }
});