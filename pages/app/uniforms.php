<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-lg-6 main-header">
        <h2><i class="fa fa-tshirt mr-2"></i> إدارة الزي الكشفي</h2>
        <p class="text-muted mt-2"><i class="fa fa-info-circle mr-1"></i> عرض وإدارة الأزياء الكشفية لجميع المنخرطين</p>
      </div>
      <div class="col-lg-6">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/"><i class="fa fa-home"></i></a></li>
          <li class="breadcrumb-item">إدارة الزي الكشفي</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<?=CSRF::create_token();?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h5><i class="fa fa-list-alt mr-2"></i>قائمة الأزياء الكشفية</h5>
                  <div class="card-header-right">
                    <?php if (Permission::YouHavePermission('add_uniform')) { ?>
                      <a class="btn btn-primary" href="/?p=addUniform">
                        <i class="fa fa-plus-circle mr-1"></i>
                        إضافة زي جديد
                      </a>
                    <?php } ?>
                  </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                                <input type="text" id="globalSearch" class="form-control" placeholder="بحث عن منخرط...">
                            </div>
                            <small class="form-text text-muted">ابحث عن طريق رقم المنخرط أو الاسم</small>
                        </div>
                        <div class="col-md-4">
                            <select id="uniformTypeFilter" class="form-control">
                                <option value="">جميع أنواع الزي</option>
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
                            <small class="form-text text-muted">تصفية حسب نوع الزي</small>
                        </div>
                        <div class="col-md-4">
                            <select id="paymentStatusFilter" class="form-control">
                                <option value="">جميع حالات الدفع</option>
                                <option value="1">مدفوع</option>
                                <option value="0">غير مدفوع</option>
                            </select>
                            <small class="form-text text-muted">تصفية حسب حالة الدفع</small>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table id="UniformsTable" class="display table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="15%">رقم المنخرط</th>
                                    <th width="20%">الاسم الكامل</th>
                                    <th width="65%">معلومات الزي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTables will populate this area -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Notes -->
<div class="modal fade" id="notesModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-sticky-note mr-2"></i>ملاحظات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <p id="noteContent"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<!-- Loading spinner -->
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
        background-color: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .uniforms-info {
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
    }
    
    .uniforms-info:hover {
        background-color: rgba(0, 123, 255, 0.1);
        border-radius: 4px;
        padding-right: 5px;
    }
    
    .uniform-details {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin: 10px 0;
        border-left: 4px solid #007bff;
    }
    
    .badge {
        font-size: 85%;
    }
    
    tr.shown {
        background-color: #f8f9fa;
    }
    
    .dataTables_filter_custom {
        margin-left: 15px;
    }
    
    /* Responsive improvements */
    @media (max-width: 767px) {
        .col-md-4 {
            margin-bottom: 15px;
        }
    }
</style>
