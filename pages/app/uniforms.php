<div class="page-content">
    <div class="page-header">
        <div class="row">
            <div class="col-lg-6 main-header">
                <h2><i class="fa fa-tshirt mr-2"></i> نظام إدارة الأزياء الكشفية</h2>
                <p class="text-muted mt-2"><i class="fa fa-info-circle mr-1"></i> إدارة شاملة للمخزون والمبيعات والمعاملات</p>
            </div>
        </div>
    </div>
</div>
<?=CSRF::create_token();?>

<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0" id="totalInventoryItems">0</h4>
                            <p class="mb-0">إجمالي المخزون</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-boxes fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0" id="totalSales">0</h4>
                            <p class="mb-0">إجمالي المبيعات</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0" id="pendingPayments">0</h4>
                            <p class="mb-0">مدفوعات معلقة</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0" id="lowStockItems">0</h4>
                            <p class="mb-0">مخزون منخفض</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fa fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="uniformTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab">
                                <i class="fa fa-boxes mr-1"></i> إدارة المخزون
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="transactions-tab" data-toggle="tab" href="#transactions" role="tab">
                                <i class="fa fa-exchange-alt mr-1"></i> المعاملات
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="members-uniforms-tab" data-toggle="tab" href="#members-uniforms" role="tab">
                                <i class="fa fa-users mr-1"></i> أزياء المنخرطين
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reports-tab" data-toggle="tab" href="#reports" role="tab">
                                <i class="fa fa-chart-bar mr-1"></i> التقارير
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="uniformTabsContent">
                        <!-- Inventory Management Tab -->
                        <div class="tab-pane fade show active" id="inventory" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-12 mb-2">
                                    <h5><i class="fa fa-boxes mr-2"></i>إدارة المخزون</h5>
                                </div>
                                <div class="col-lg-6 col-md-12 text-lg-right text-center">
                                    <?php if ($add_uniform) { ?>
                                    <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#addInventoryModal">
                                        <i class="fa fa-plus mr-1"></i> إضافة صنف جديد
                                    </button>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#stockUpdateModal">
                                        <i class="fa fa-plus-circle mr-1"></i> تحديث المخزون
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table id="inventoryTable" class="table table-striped table-bordered table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>الصنف</th>
                                            <th>النوع</th>
                                            <th>المقاس</th>
                                            <th>الكمية المتاحة</th>
                                            <th>سعر الوحدة</th>
                                            <th>المورد</th>
                                            <th>تاريخ الشراء</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DataTables will populate this -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Transactions Tab -->
                        <div class="tab-pane fade" id="transactions" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-12 mb-2">
                                    <h5><i class="fa fa-exchange-alt mr-2"></i>المعاملات</h5>
                                </div>
                                <div class="col-lg-6 col-md-12 text-lg-right text-center">
                                    <?php if ($add_uniform) { ?>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#newTransactionModal">
                                        <i class="fa fa-plus mr-1"></i> معاملة جديدة
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <select id="transactionTypeFilter" class="form-control">
                                        <option value="">جميع المعاملات</option>
                                        <option value="بيع">بيع</option>
                                        <option value="استلام">استلام</option>
                                        <option value="إرجاع">إرجاع</option>
                                        <option value="تلف">تلف</option>
                                        <option value="فقدان">فقدان</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <select id="paymentStatusFilter" class="form-control">
                                        <option value="">جميع حالات الدفع</option>
                                        <option value="مدفوع">مدفوع</option>
                                        <option value="غير مدفوع">غير مدفوع</option>
                                        <option value="مدفوع جزئياً">مدفوع جزئياً</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <input type="date" id="dateFromFilter" class="form-control" placeholder="من تاريخ">
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                                    <input type="date" id="dateToFilter" class="form-control" placeholder="إلى تاريخ">
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table id="transactionsTable" class="table table-striped table-bordered table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>رقم المنخرط</th>
                                            <th>الصنف</th>
                                            <th>نوع المعاملة</th>
                                            <th>الكمية</th>
                                            <th>سعر الوحدة</th>
                                            <th>المبلغ الإجمالي</th>
                                            <th>حالة الدفع</th>
                                            <th>تاريخ المعاملة</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DataTables will populate this -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Members Uniforms Tab -->
                        <div class="tab-pane fade" id="members-uniforms" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-lg-6 col-md-12 mb-2">
                                    <h5><i class="fa fa-users mr-2"></i>أزياء المنخرطين</h5>
                                </div>
                                <div class="col-lg-6 col-md-12 text-lg-right text-center">
                                    <div class="input-group">
                                        <input type="text" id="memberSearch" class="form-control" placeholder="بحث عن منخرط...">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table id="memberUniformsTable" class="table table-striped table-bordered table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>رقم المنخرط</th>
                                            <th>الاسم الكامل</th>
                                            <th>الأزياء المملوكة</th>
                                            <th>إجمالي المدفوعات</th>
                                            <th>المبلغ المستحق</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- DataTables will populate this -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Reports Tab -->
                        <div class="tab-pane fade" id="reports" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h6><i class="fa fa-chart-pie mr-1"></i> توزيع المبيعات حسب النوع</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="salesByTypeChart" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h6><i class="fa fa-chart-line mr-1"></i> المبيعات الشهرية</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="monthlySalesChart" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6><i class="fa fa-table mr-1"></i> تقرير المخزون المنخفض</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="lowStockTable" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>الصنف</th>
                                                            <th>النوع</th>
                                                            <th>المقاس</th>
                                                            <th>الكمية المتاحة</th>
                                                            <th>الحد الأدنى المطلوب</th>
                                                            <th>الحالة</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Will be populated by JavaScript -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Inventory Modal -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus mr-2"></i>إضافة صنف جديد للمخزون</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addInventoryForm">
                    <?=CSRF::create_token();?>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>اسم الصنف <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="item_name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>نوع الصنف <span class="text-danger">*</span></label>
                                <select class="form-control" name="item_type" required>
                                    <option value="">اختر النوع</option>
                                    <option value="قميص">قميص</option>
                                    <option value="شارة">شارة</option>
                                    <option value="منديل">منديل</option>
                                    <option value="قبعة">قبعة</option>
                                    <option value="سترة">سترة</option>
                                    <option value="سروال">سروال</option>
                                    <option value="حزام">حزام</option>
                                    <option value="حذاء">حذاء</option>
                                    <option value="جوارب">جوارب</option>
                                    <option value="أخرى">أخرى</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>المقاس <span class="text-danger">*</span></label>
                                <select class="form-control" name="size" required>
                                    <option value="">اختر المقاس</option>
                                    <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                    <option value="XXXL">XXXL</option>
                                    <option value="واحد">مقاس واحد</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>الكمية الأولية <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="quantity_in_stock" min="0" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>سعر الوحدة (دج) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="unit_price" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>المورد</label>
                                <input type="text" class="form-control" name="supplier">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>تاريخ الشراء</label>
                                <input type="date" class="form-control" name="purchase_date">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>ملاحظات</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveInventoryItem">حفظ</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Inventory Modal -->
<div class="modal fade" id="editInventoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-edit mr-2"></i>تعديل صنف في المخزون</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editInventoryForm">
                    <?=CSRF::create_token();?>
                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>اسم الصنف <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="item_name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>نوع الصنف <span class="text-danger">*</span></label>
                                <select class="form-control" name="item_type" required>
                                    <option value="">اختر النوع</option>
                                    <option value="قميص">قميص</option>
                                    <option value="شارة">شارة</option>
                                    <option value="منديل">منديل</option>
                                    <option value="قبعة">قبعة</option>
                                    <option value="سترة">سترة</option>
                                    <option value="سروال">سروال</option>
                                    <option value="حزام">حزام</option>
                                    <option value="حذاء">حذاء</option>
                                    <option value="جوارب">جوارب</option>
                                    <option value="أخرى">أخرى</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>المقاس <span class="text-danger">*</span></label>
                                <select class="form-control" name="size" required>
                                    <option value="">اختر المقاس</option>
                                    <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                    <option value="XXXL">XXXL</option>
                                    <option value="واحد">مقاس واحد</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>الكمية في المخزون <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="quantity_in_stock" min="0" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>سعر الوحدة (دج) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="unit_price" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>المورد</label>
                                <input type="text" class="form-control" name="supplier">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>تاريخ الشراء</label>
                                <input type="date" class="form-control" name="purchase_date">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>ملاحظات</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="updateInventoryItem">تحديث</button>
            </div>
        </div>
    </div>
</div>

<!-- New Transaction Modal -->
<div class="modal fade" id="newTransactionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-exchange-alt mr-2"></i>معاملة جديدة</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newTransactionForm">
                    <?=CSRF::create_token();?>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>رقم المنخرط <span class="text-danger">*</span></label>
                                <select class="form-control" name="member_id" id="memberSelect" required>
                                    <option value="">اختر المنخرط</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>نوع المعاملة <span class="text-danger">*</span></label>
                                <select class="form-control" name="transaction_type" required>
                                    <option value="">اختر نوع المعاملة</option>
                                    <option value="بيع">بيع</option>
                                    <option value="استلام">استلام</option>
                                    <option value="إرجاع">إرجاع</option>
                                    <option value="تلف">تلف</option>
                                    <option value="فقدان">فقدان</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>الصنف <span class="text-danger">*</span></label>
                                <select class="form-control" name="inventory_id" id="inventorySelect" required>
                                    <option value="">اختر الصنف</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>الكمية <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="quantity" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>سعر الوحدة (دج) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="unit_price" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>المبلغ الإجمالي (دج)</label>
                                <input type="number" class="form-control" name="total_amount" step="0.01" readonly>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label>حالة الدفع <span class="text-danger">*</span></label>
                                <select class="form-control" name="payment_status" required>
                                    <option value="غير مدفوع">غير مدفوع</option>
                                    <option value="مدفوع">مدفوع</option>
                                    <option value="مدفوع جزئياً">مدفوع جزئياً</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>تاريخ الدفع</label>
                                <input type="date" class="form-control" name="transaction_date">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label>ملاحظات</label>
                                <textarea class="form-control" name="notes" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveTransaction">حفظ المعاملة</button>
            </div>
        </div>
    </div>
</div>

<!-- Stock Update Modal -->
<div class="modal fade" id="stockUpdateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-plus-circle mr-2"></i>تحديث المخزون</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="stockUpdateForm">
                    <?=CSRF::create_token();?>
                    <div class="form-group">
                        <label>الصنف <span class="text-danger">*</span></label>
                        <select class="form-control" name="inventory_id" required>
                            <option value="">اختر الصنف</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>الكمية المضافة <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="quantity_added" min="1" required>
                    </div>
                    <div class="form-group">
                        <label>ملاحظات</label>
                        <textarea class="form-control" name="notes" rows="2" placeholder="سبب إضافة المخزون..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-success" id="updateStock">تحديث المخزون</button>
            </div>
        </div>
    </div>
</div>

<!-- Member Uniform Details Modal -->
<div class="modal fade" id="memberUniformDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل أزياء المنخرط</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <h6>معلومات المنخرط</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>رقم المنخرط:</strong></td>
                                <td id="memberIdDisplay"></td>
                            </tr>
                            <tr>
                                <td><strong>الاسم الكامل:</strong></td>
                                <td id="memberNameDisplay"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <h6>الملخص المالي</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>إجمالي المدفوعات:</strong></td>
                                <td id="totalPaidDisplay"></td>
                            </tr>
                            <tr>
                                <td><strong>المبلغ المستحق:</strong></td>
                                <td id="amountDueDisplay"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <h6>الأزياء المملوكة</h6>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>الصنف</th>
                                <th>النوع</th>
                                <th>المقاس</th>
                                <th>الكمية</th>
                                <th>سعر الوحدة</th>
                                <th>المبلغ الإجمالي</th>
                                <th>تاريخ المعاملة</th>
                            </tr>
                        </thead>
                        <tbody id="memberUniformsTableBody">
                            <!-- Will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل المعاملة</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <h6>معلومات المعاملة</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>رقم المعاملة:</strong></td>
                                <td id="transactionIdDisplay"></td>
                            </tr>
                            <tr>
                                <td><strong>المنخرط:</strong></td>
                                <td id="memberNameDisplay"></td>
                            </tr>
                            <tr>
                                <td><strong>الصنف:</strong></td>
                                <td id="itemNameDisplay"></td>
                            </tr>
                            <tr>
                                <td><strong>نوع المعاملة:</strong></td>
                                <td id="transactionTypeDisplay"></td>
                            </tr>
                            <tr>
                                <td><strong>الكمية:</strong></td>
                                <td id="quantityDisplay"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <h6>معلومات الدفع</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>سعر الوحدة:</strong></td>
                                <td id="unitPriceDisplay"></td>
                            </tr>
                            <tr>
                                <td><strong>المبلغ الإجمالي:</strong></td>
                                <td id="totalAmountDisplay"></td>
                            </tr>
                            <tr>
                                <td><strong>حالة الدفع:</strong></td>
                                <td id="paymentStatusDisplay"></td>
                            </tr>
                            <tr>
                                <td><strong>المبلغ المدفوع:</strong></td>
                                <td id="amountPaidDisplay"></td>
                            </tr>
                            <tr>
                                <td><strong>تاريخ المعاملة:</strong></td>
                                <td id="transactionDateDisplay"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h6>ملاحظات</h6>
                        <p id="notesDisplay" class="border p-3 rounded"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">جاري التحميل...</span>
    </div>
</div>

<style>
#loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.nav-tabs .nav-link {
    border-radius: 0;
    border: none;
    border-bottom: 3px solid transparent;
    color: #6c757d;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    background-color: transparent;
    border-bottom-color: #007bff;
    color: #007bff;
}

.nav-tabs .nav-link:hover {
    border-bottom-color: #007bff;
    color: #007bff;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.table th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.75em;
}

.btn {
    border-radius: 0.25rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn:hover {
    transform: translateY(-1px);
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.form-control:focus, .form-control:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.text-danger {
    color: #dc3545 !important;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .modal-dialog {
        margin: 0.5rem;
    }
    
    .modal-lg {
        max-width: calc(100% - 1rem);
    }
    
    .nav-tabs .nav-link {
        font-size: 0.875rem;
        padding: 0.5rem 0.75rem;
    }
    
    .page-header h2 {
        font-size: 1.5rem;
    }
    
    .page-header p {
        font-size: 0.875rem;
    }
    
    .card .card-body {
        padding: 0.75rem;
    }
    
    .statistics-card {
        margin-bottom: 1rem;
    }
    
    .col-xl-3 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    
    .text-lg-right {
        text-align: right !important;
    }
    
    .mr-2 {
        margin-right: 0.5rem !important;
    }
}

@media (max-width: 576px) {
    .col-xl-3 {
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    .text-lg-right {
        text-align: center !important;
        margin-top: 1rem;
    }
    
    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
    
    .mr-2 {
        margin-right: 0 !important;
    }
    
    .card-header-tabs .nav-link {
        font-size: 0.8rem;
        padding: 0.5rem;
    }
}
</style>

