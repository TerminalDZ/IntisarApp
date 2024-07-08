<?php
if (!isset($_GET['id'])) {
    
    echo '<script>window.location.href = "'.$base_url.'?p=users";</script>';


    exit; 
}

$id = $_GET['id'];

$user = User::get_data_id($id);

if ($user == null) {
    echo '<script>window.location.href = "'.$base_url.'?p=users";</script>';
    exit;
}

?>

<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-lg-6 main-header">
				<h2>تعديل المستخدم</h2>
			</div>
		</div>
	</div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card"> 
                <div class="card-header">
                    <h5>تعديل المستخدم</h5> 
                </div>
                <div class="card-body">
                    <form>
                        <?=CSRF::create_token();?>
                        <input type="hidden" name="userId" id="userId" value="<?=$user['id']?>">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="fr_name">الاسم الاول</label>
                                <input class="form-control" id="fr_name" type="text" name="fr_name" placeholder="الاسم الاول" required="" value="<?=$user['fr_name']?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ls_name">الاسم الاخير</label>
                                <input class="form-control" id="ls_name" type="text" name="ls_name" placeholder="الاسم الاخير" required="" value="<?=$user['ls_name']?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username">اسم المستخدم</label>
                                <input class="form-control" id="username" type="text" name="username" placeholder="اسم المستخدم" required="" value="<?=$user['username']?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email">البريد الالكتروني</label>
                                <input class="form-control" id="email" type="email" name="email" placeholder="البريد الالكتروني" required="" value="<?=$user['email']?>">
                            </div>
                            <div class="col-md-12 mb-3">
								<label for="role">الدور</label>
								<select class="form-control" id="role" name="role" required="">
									<option value="">اختر الدور</option>
									<?php
										$roles = DB::query("SELECT * FROM roles");
                                        $roleU = User::getUserRoles($user['id']);
										foreach ($roles as $role) {
                                            echo '<option value="'.$role['id'].'"';
                                            if ($roleU[0]['id'] == $role['id']) {
                                                echo 'selected';
                                            }
                                            echo '>'.$role['role_name'].'</option>';
                                            
                                            
                                        }
									?>
								</select> 
							</div>

                            <div class="col-md-4 mb-3">
                                <label for="password">كلمة المرور</label>
                                <div class="input-group">
                                    <input class="form-control" id="password" type="password" name="password" placeholder="كلمة المرور" required="">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="ShowPassword" style="cursor: pointer;"><i class="fa fa-eye" id="IconShowPassword"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="password2">تأكيد كلمة المرور</label>
                                <input class="form-control" id="confirmPassword" type="password" name="password2" placeholder="تأكيد كلمة المرور" required="">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="password2">توليد كلمة مرور</label><br>
                                <button class="btn btn-primary" type="button" id="genratePassword" name="genratePassword">توليد كلمة مرور</button>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="access">الحالة</label>
                                <select class="form-control" id="access" name="access" required="">
                                    <option value="1" <?php if ($user['access'] == 1) { echo 'selected'; } ?>>مفعل</option>
                                    <option value="0" <?php if ($user['access'] == 0) { echo 'selected'; } ?>>غير مفعل</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button class="btn btn-primary mb-1 mt-1" type="button" id="EditUser" name="editUser">تعديل المستخدم وبقاء في الصفحة</button>
                                <button class="btn btn-success" type="button" id="EditUserAndClose" name="editUserAndClose">تعديل المستخدم والرجوع للقائمة</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
