<div class="page-content">
    <div class="page-header">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12 main-header">
                <h2><i class="fas fa-tshirt me-2"></i>إضافة زي كشفي</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="?p=dashboard">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="?p=uniforms">الأزياء الكشفية</a></li>
                        <li class="breadcrumb-item active">إضافة زي كشفي</li>
                    </ol>
                </nav>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-12 text-end">
                <a href="?p=uniforms" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-1"></i>العودة
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<div id="alertContainer" class="container-fluid"></div>

<!-- Main Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa fa-plus-circle me-2"></i>بيانات المعاملة</h5>
                </div>
                <div class="card-body">
                    <form id="uniformTransactionForm">
                        <?=CSRF::create_token();?>
                        <!-- Transaction Type Section -->
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="transaction_type" class="form-label">نوع المعاملة <span class="text-danger">*</span></label>
                                    <select class="form-control form-select" id="transaction_type" name="transaction_type" required>
                                        <option value="">اختر نوع المعاملة</option>
                                        <option value="بيع">بيع</option>
                                        <option value="استلام">استلام</option>
                                        <option value="إرجاع">إرجاع</option>
                                        <option value="تلف">تلف</option>
                                        <option value="فقدان">فقدان</option>
                                    </select>
                                    <div class="invalid-feedback">يرجى اختيار نوع المعاملة</div>
                                    <small class="form-text text-muted">حدد نوع المعاملة التي ترغب في تنفيذها</small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="transaction_date" class="form-label">تاريخ المعاملة <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="transaction_date" name="transaction_date" required>
                                    <div class="invalid-feedback">يرجى إدخال تاريخ المعاملة</div>
                                    <small class="form-text text-muted">تاريخ تنفيذ المعاملة</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Member Selection Section -->
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="member_id" class="form-label">المنخرط <span class="text-danger">*</span></label>
                                    <select class="form-control form-select" id="member_id" name="member_id" required>
                                        <option value="">اختر المنخرط</option>
                                    </select>
                                    <div class="invalid-feedback">يرجى اختيار المنخرط</div>
                                    <small class="form-text text-muted">اختر المنخرط الذي تتعلق به هذه المعاملة</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Inventory Selection Section -->
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="inventory_id" class="form-label">الصنف <span class="text-danger">*</span></label>
                                    <select class="form-control form-select" id="inventory_id" name="inventory_id" required>
                                        <option value="">اختر الصنف</option>
                                    </select>
                                    <div class="invalid-feedback">يرجى اختيار الصنف</div>
                                    <small class="form-text text-muted">اختر الصنف الذي تتعلق به هذه المعاملة</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Inventory Info Section -->
                        <div class="row mb-3" id="inventoryInfo" style="display: none;">
                            <div class="col-lg-12">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle me-2"></i>
                                    <span id="stockInfo"></span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quantity and Price -->
                        <div class="row mb-3">
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="quantity" class="form-label">الكمية <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                                    <div class="invalid-feedback">يرجى إدخال كمية صحيحة</div>
                                    <small class="form-text text-muted">عدد القطع في هذه المعاملة</small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="unit_price" class="form-label">سعر الوحدة <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" min="0" required>
                                    <div class="invalid-feedback">يرجى إدخال سعر الوحدة</div>
                                    <small class="form-text text-muted">سعر كل قطعة بالدينار الجزائري</small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="total_amount" class="form-label">المبلغ الإجمالي</label>
                                    <input type="number" class="form-control" id="total_amount" name="total_amount" step="0.01" readonly>
                                    <small class="form-text text-muted">السعر الإجمالي بعد الخصم</small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="discount" class="form-label">الخصم</label>
                                    <input type="number" class="form-control" id="discount" name="discount" step="0.01" min="0" value="0">
                                    <small class="form-text text-muted">قيمة الخصم على المعاملة</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Section -->
                        <div class="payment-section card mb-3" id="paymentSection" style="display: none;">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fa fa-credit-card me-2"></i>معلومات الدفع</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="payment_status" class="form-label">حالة الدفع <span class="text-danger">*</span></label>
                                            <select class="form-control form-select" id="payment_status" name="payment_status">
                                                <option value="مدفوع">مدفوع</option>
                                                <option value="مدفوع جزئياً">مدفوع جزئياً</option>
                                                <option value="غير مدفوع">غير مدفوع</option>
                                            </select>
                                            <div class="invalid-feedback">يرجى اختيار حالة الدفع</div>
                                            <small class="form-text text-muted">حالة الدفع لهذه المعاملة</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="amount_paid" class="form-label">المبلغ المدفوع</label>
                                            <input type="number" class="form-control" id="amount_paid" name="amount_paid" step="0.01" min="0">
                                            <div class="invalid-feedback">يرجى إدخال المبلغ المدفوع</div>
                                            <small class="form-text text-muted">المبلغ الذي تم دفعه فعلاً</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label for="payment_method" class="form-label">طريقة الدفع</label>
                                            <select class="form-control form-select" id="payment_method" name="payment_method">
                                                <option value="">اختر طريقة الدفع</option>
                                                <option value="نقدي">نقدي</option>
                                                <option value="بنكي">تحويل بنكي</option>
                                                <option value="شيك">شيك</option>
                                                <option value="أخرى">أخرى</option>
                                            </select>
                                            <small class="form-text text-muted">طريقة استلام المبلغ</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Notes -->
                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="notes" class="form-label">ملاحظات</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="أدخل أي ملاحظات إضافية..."></textarea>
                                    <small class="form-text text-muted">أي معلومات إضافية تتعلق بهذه المعاملة</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-secondary me-2" onclick="window.history.back()">
                                        <i class="fa fa-times me-1"></i>إلغاء
                                    </button>
                                    <button type="submit" class="btn btn-success" id="submitBtn">
                                        <i class="fa fa-save me-1"></i>حفظ المعاملة
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }
    
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .form-control.is-valid, .form-select.is-valid {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    .btn {
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #adb5bd 100%);
        border: none;
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }
    
    .payment-section .card-header {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
        border-radius: 10px 10px 0 0 !important;
    }
    
    .alert {
        border-radius: 10px;
    }
    
    .breadcrumb {
        background-color: transparent;
        padding: 0;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        float: right;
        padding-left: 0.5rem;
        color: #6c757d;
        content: ">";
    }
    
    .text-end {
        text-align: left !important;
    }
    
    .me-2 {
        margin-left: 0.5rem !important;
    }
    
    .me-1 {
        margin-left: 0.25rem !important;
    }
    
    .form-text {
        font-size: 0.8rem;
    }
    
    @media (max-width: 768px) {
        .text-end {
            text-align: right !important;
        }
        
        .me-2 {
            margin-left: 0 !important;
            margin-right: 0.5rem !important;
        }
        
        .me-1 {
            margin-left: 0 !important;
            margin-right: 0.25rem !important;
        }
        
        .d-flex {
            flex-direction: column;
        }
        
        .btn {
            margin-bottom: 0.5rem;
            width: 100%;
        }
        
        .btn + .btn {
            margin-right: 0;
        }
    }
</style>

<!-- Include Select2 CSS and JS -->
<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
<script src="assets/plugins/select2/js/select2.min.js"></script>

<!-- Include the addUniform.js script -->
<script src="include/js/pages/addUniform.js"></script>