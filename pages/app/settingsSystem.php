<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-lg-6 main-header">
        <h2>الاعدادات الموقع</h2>
      </div>
    </div>
  </div>
</div>



<!-- Container-fluid starts-->
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title mb-0">الاعدادات الأساسية</h4>
            </div>
            <div class="card-body">
               <?=CSRF::create_token();?>
               <form class="theme-form settingsSystem">
                  
                  <div class="form-group">
                     <h6 class="form-label">اسم الموقع</h6>
                     <input type="text" class="form-control" id="site_name" value="<?=$settings['site_name']?>">
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">اللوجو</h6>
                     <input type="file" class="form-control dropify" id="logo" data-default-file="<?=$urlUploads?><?=$settings['logo']?>" data-max-file-size="3M" data-allowed-file-extensions="png jpg gif">

                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">الايقونة</h6>
                     <div class="col-auto position-relative">
                     <input type="file" class="form-control dropify" id="icon" data-default-file="<?=$urlUploads?><?=$settings['icon']?>" data-max-file-size="3M" data-allowed-file-extensions="png jpg gif">
                     </div>
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">الوصف</h6>
                     <textarea class="form-control" rows="5" id="description"><?=$settings['description']?></textarea>
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">الكلمات الدلالية</h6>
                     <input type="text" class="keywords" id="keywords" value="<?=$settings['keywords']?>">
                     
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">البريد الالكتروني</h6>
                     <input type="email" class="form-control" id="email" value="<?=$settings['email']?>">
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">الهاتف</h6>
                     <input type="text" class="form-control" id="phone" value="<?=$settings['phone']?>">
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">العنوان</h6>
                     <input type="text" class="form-control" id="address" value="<?=$settings['address']?>">
                  </div>
               </form>
               <div class="form-footer mt-3 mb-3">
                  <button class="btn btn-primary btn-block btn-pill" id="UpdateSettings" type="button">تحديث الاعدادات</button>
               </div>
            </div>
         </div>
      </div>

      <!-- اعدادات Smtp -->
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title mb-0">اعدادات SMTP</h4>
               <div class="card-options"><a class="card-options-collapse" href="#" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
               <form class="theme-form settingsSmtp">
                  <div class="form-group">
                     <h6 class="form-label d-block">البريد الالكتروني</h6>
                     <input type="email" class="form-control" id="smtp_email" value="<?=$settings['smtp_email']?>">
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">كلمة المرور</h6>
                     <input type="text" class="form-control" id="smtp_password" value="<?=$settings['smtp_password']?>">
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">المضيف</h6> 
                     <input type="text" class="form-control" id="smtp_host" value="<?=$settings['smtp_host']?>">
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">المنفذ</h6>
                     <input type="text" class="form-control" id="smtp_port" value="<?=$settings['smtp_port']?>">
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">التشفير</h6>
                     <select class="form-control" id="smtp_encryption">
                        <option value="ssl" <?php if($settings['smtp_encryption'] == 'ssl'){echo 'selected';}?>>SSL</option>
                        <option value="tls" <?php if($settings['smtp_encryption'] == 'tls'){echo 'selected';}?>>TLS</option>
                     </select>
                  </div>
               </form>
               <div class="form-footer mt-3 mb-3">
                  <button class="btn btn-info btn-block btn-pill" id="TestSmtp" type="button">اختبار SMTP</button>
               </div>
               <div class="form-footer mt-3 mb-3">
                  <button class="btn btn-primary btn-block btn-pill" id="UpdateSmtp" type="button">تحديث الاعدادات</button>
               </div>
            </div>
         </div>
      </div>






   </div>
</div>
<!-- Container-fluid Ends-->




<div class="modal" id="modalTestSmtp" tabindex="-1" role="dialog" aria-labelledby="UploadImage" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">اختبار SMTP</h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body text-center">
            <div id="contentSmtp">
               <form class="theme-form settingsSmtp">
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">البريد الالكتروني</h6>
                     <input type="email" class="form-control" id="test_email" placeholder="البريد الالكتروني">
                  </div>
               </form>
               <div class="form-footer mt-3 mb-3">
                  <button class="btn btn-primary btn-block btn-pill" id="TestSend" type="button">ارسال</button>
               </div>
            </div>
            
            <div id="ReloadSend" style="display:none;">
               <div class="spinner-border text-primary" role="status">
                  <span class="sr-only">Loading...</span>
               </div>
               <p class="text-center mt-2">جاري اختبار الاعدادات</p> 
            </div>
           
         </div>
      </div>
   </div>
</div>


