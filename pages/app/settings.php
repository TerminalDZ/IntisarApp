<style>
        .position-relative {
            position: relative;
        }
        .edit-icon {
            position: absolute;
            top: 0;
            right: 18px;
            background-color: rgba(128, 128, 128, 0.5); 
            padding: 25px;
            border-radius: 50%;
            color: white;
            cursor: pointer;
        }
        .edit-icon:hover {
            background-color: rgba(128, 128, 128, 0.7); 
        }
</style>

<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-lg-6 main-header">
        <h2>الاعدادات</h2>
      </div>
    </div>
  </div>
</div>


<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="edit-profile">
      <div class="row">
        <div class="col-lg-4">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title mb-0">حسابي</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
            <?=CSRF::create_token();?>
              <form class="theme-form">
                <div class="row mb-2">
                <div class="col-auto position-relative">
                    <img class="img-70 rounded-circle" alt="" src="<?=$urlUploads?><?=$profile['avatar']?>" style="width: 66px !important;height: 71px !important;">
                    <div class="edit-icon" id="ProfileImage">
                        <i class="pe-7s-camera"></i>
                    </div>
                </div>                  
                  <div class="col">
                    <h3 class="mb-1" id="nameProfile"><?=$profile['fr_name']?> <?=$profile['ls_name']?></h3>
                  </div>
                </div>
                <div class="form-group">
                  <h6 class="form-label">البايو</h6>
                  <textarea class="form-control" rows="5" id="BioP">
                    <?=$profile['bio']?>
                  </textarea>
                </div>
                <div class="form-group">
                  <label class="form-label"> بريد الالكتروني</label>
                  <input class="form-control" type="email" placeholder="your-email@domain.com" id="EmailP" value="<?=$profile['email']?>">
                </div>
              
                <div class="form-footer">
                  <button class="btn btn-primary btn-block btn-pill" id="UpdateAcount" type="button">تحديث الحساب</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <form class="card theme-form">
            <div class="card-header">
              <h4 class="card-title mb-0">تعديل الملف الشخصي</h4>
              <div class="card-options"><a class="card-options-collapse" href="#" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-toggle="card-remove"><i class="fe fe-x"></i></a></div>
            </div>
            <div class="card-body">
              <div class="row">

                <div class="col-sm-12 col-md-12">
                  <div class="form-group">
                    <label class="form-label">اسم المستخدم</label>
                    <input class="form-control" type="text" placeholder="اسم المستخدم" id="usernameP" value="<?=$profile['username']?>">
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label"> الاسم الاول</label>
                    <input class="form-control" type="text" placeholder="الاسم الاول" id="First_Name" value="<?=$profile['fr_name']?>">
                  </div>
                </div>
                <div class="col-sm-6 col-md-6">
                  <div class="form-group">
                    <label class="form-label">الاسم الاخير</label>
                    <input class="form-control" type="text" placeholder=" الاسم الاخير" id="Last_Name" value="<?=$profile['ls_name']?>">
                  </div>
                </div>

                  <p id="EditPassWordShow" class="text-primary" style="cursor:pointer;">
                    <i class="fe fe-edit"></i>
                   > تعديل كلمة المرور
                  </p>

                  
                  <div class="col-12 mt-5 mb-5" id="EditPassWord" style="display:none;">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-label ">كلمة المرور الحالية</label>
                        <input class="form-control" type="password" placeholder="كلمة المرور الحالية" id="OldPassword">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group ">
                        <label class="form-label">كلمة المرور الجديدة</label>
                        <input class="form-control" type="password" placeholder="كلمة المرور الجديدة" id="NewPassword">
                      </div>
                    </div>
                    <div class=" col-md-12">
                      <div class="form-group ">
                        <label class="form-label ">تأكيد كلمة المرور</label>
                        <input class="form-control" type="password" placeholder="تأكيد كلمة المرور" id="ConfirmPassword">
                      </div>
                    </div>

                    <div class="col-md-12 text-right">
                      <button class="btn btn-primary btn-pill" type="button" id="UpdatePassword">تحديث كلمة المرور</button>
                    </div>

                  </div>
                  
              
               
                <div class="col-md-12 text-right">
                  <button class="btn btn-primary btn-pill" type="button" id="UpdateProfile">تحديث الملف الشخصي</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
<!-- Container-fluid Ends-->




<div class="modal fade" id="UploadImage" tabindex="-1" role="dialog" aria-labelledby="UploadImage" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">تحميل الصورة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
          <div class="form-group">
            <label for="exampleFormControlFile1">اختر صورة</label>
            <input type="file" class="form-control-file" id="FileAvatar" name="Avatar">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="UploadAvatar">تحميل</button>
      </div>
    </div>
  </div>
</div>

