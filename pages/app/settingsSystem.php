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
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">المحافظة الولائية</h6>
                     <select class="form-control" id="governorate_state">
                        <?php 
                        
                        $wilay = Wilaya::get_all();
                        foreach ($wilay as $wilaya) {
                           echo '<option value="'.$wilaya['wilaya_name'].'" '.($settings['governorate_state'] == $wilaya['wilaya_name'] ? 'selected' : '').'> ('.$wilaya['wilaya_code'].') محافظة '.$wilaya['wilaya_name'].'</option>';
                        }
                        ?>
                        
                     </select>
                        
                     
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
                  <div class="smtp-field form-group mb-2" id="smtp_email_field">
                     <h6 class="form-label d-block">البريد الالكتروني</h6>
                     <input type="email" class="form-control" id="smtp_email" value="<?=$settings['smtp_email']?>">
                  </div>
                  <div class="smtp-field form-group mb-2" id="smtp_password_field">
                     <h6 class="form-label d-block">كلمة المرور</h6>
                     <input type="password" class="form-control" id="smtp_password" value="<?=$settings['smtp_password']?>">
                  </div>
                  <div class="smtp-field form-group mb-2" id="smtp_host_field">
                     <h6 class="form-label d-block">الخادم</h6>
                     <input type="text" class="form-control" id="smtp_host" value="<?=$settings['smtp_host']?>" placeholder="مثال: smtp.gmail.com">
                  </div>
                  <div class="smtp-field form-group mb-2" id="smtp_port_field">
                     <h6 class="form-label d-block">المنفذ</h6>
                     <input type="number" class="form-control" id="smtp_port" value="<?=$settings['smtp_port']?>" min="1" max="65535" placeholder="مثال: 587">
                  </div>
                  <div class="smtp-field form-group mb-2" id="smtp_encryption_field">
                     <h6 class="form-label d-block">التشفير</h6>
                     <select class="form-control" id="smtp_encryption">
                        <option value="" <?php if(empty($settings['smtp_encryption']) || $settings['smtp_encryption'] == 'null'){echo 'selected';}?>>بدون تشفير</option>
                        <option value="ssl" <?php if($settings['smtp_encryption'] == 'ssl'){echo 'selected';}?>>SSL</option>
                        <option value="tls" <?php if($settings['smtp_encryption'] == 'tls'){echo 'selected';}?>>TLS</option>
                        <option value="starttls" <?php if($settings['smtp_encryption'] == 'starttls'){echo 'selected';}?>>STARTTLS</option>
                     </select>
                  </div>
                  <div class="form-group mb-2">
                     <h6 class="form-label d-block">نوع الخدمة</h6>
                     <select class="form-control" id="smtp_service_type">
                        <option value="smtp" <?php if(empty($settings['smtp_service_type']) || $settings['smtp_service_type'] == 'smtp'){echo 'selected';}?>>SMTP عادي</option>
                        <option value="mailpit" <?php if($settings['smtp_service_type'] == 'mailpit'){echo 'selected';}?>>Mailpit (للاختبار)</option>
                        <option value="mailtrap" <?php if($settings['smtp_service_type'] == 'mailtrap'){echo 'selected';}?>>Mailtrap</option>
                        <option value="sendmail" <?php if($settings['smtp_service_type'] == 'sendmail'){echo 'selected';}?>>Sendmail</option>
                     </select>
                  </div>
                  <div class="smtp-field form-group mb-2" id="smtp_timeout_field">
                     <h6 class="form-label d-block">مهلة الاتصال (ثانية)</h6>
                     <input type="number" class="form-control" id="smtp_timeout" value="<?=isset($settings['smtp_timeout']) ? $settings['smtp_timeout'] : '30'?>" min="5" max="300">
                  </div>
                  <div class="smtp-field form-group mb-2" id="smtp_auth_field">
                     <h6 class="form-label d-block">تفعيل المصادقة</h6>
                     <select class="form-control" id="smtp_auth">
                        <option value="1" <?php if(empty($settings['smtp_auth']) || $settings['smtp_auth'] == '1'){echo 'selected';}?>>مفعل</option>
                        <option value="0" <?php if($settings['smtp_auth'] == '0'){echo 'selected';}?>>معطل</option>
                     </select>
                  </div>
                  <div class="form-group mb-2" id="smtp_debug_field">
                     <h6 class="form-label d-block">مستوى التصحيح</h6>
                     <select class="form-control" id="smtp_debug">
                        <option value="0" <?php if(empty($settings['smtp_debug']) || $settings['smtp_debug'] == '0'){echo 'selected';}?>>معطل</option>
                        <option value="1" <?php if($settings['smtp_debug'] == '1'){echo 'selected';}?>>أساسي</option>
                        <option value="2" <?php if($settings['smtp_debug'] == '2'){echo 'selected';}?>>متقدم</option>
                        <option value="3" <?php if($settings['smtp_debug'] == '3'){echo 'selected';}?>>مفصل</option>
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

<style>
.smtp-field {
    transition: all 0.3s ease;
}

.smtp-field.hidden {
    display: none !important;
}

#smtp_service_type {
    font-weight: 600;
    border: 2px solid #e0e6ed;
}

#smtp_service_type:focus {
    border-color: #7366ff;
    box-shadow: 0 0 0 0.2rem rgba(115, 102, 255, 0.25);
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
}

.form-control {
    border-radius: 6px;
    border: 1px solid #e0e6ed;
    padding: 10px 12px;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #7366ff;
    box-shadow: 0 0 0 0.2rem rgba(115, 102, 255, 0.15);
}

.card {
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: linear-gradient(135deg, #106138 0%, #55872e 100%);
    color: white;
    border-radius: 10px 10px 0 0 !important;
}

.btn-primary {
    background:linear-gradient(135deg, #106138 0%, #55872e 100%);
    border: none;
    border-radius: 6px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(115, 102, 255, 0.3);
}

.service-info {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 10px;
    margin-top: 10px;
    font-size: 0.9em;
    color: #6c757d;
}
</style>


