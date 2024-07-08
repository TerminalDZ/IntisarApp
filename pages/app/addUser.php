<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-lg-6 main-header">
				<h2>اضافة مستخدم</h2>
			</div>
		</div>
	</div>
</div>


<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>اضافة مستخدم</h5>
				</div>
				<div class="card-body">
					<form>
						<?=CSRF::create_token();?>
						<div class="form-row">
							<div class="col-md-6 mb-3">
								<label for="fr_name">الاسم الاول</label>
								<input class="form-control" id="fr_name" type="text" name="fr_name" placeholder="الاسم الاول" required="">
							</div>
							<div class="col-md-6 mb-3">
								<label for="ls_name">الاسم الاخير</label>
								<input class="form-control" id="ls_name" type="text" name="ls_name" placeholder="الاسم الاخير" required="">
							</div>
							<div class="col-md-6 mb-3">
								<label for="username">اسم المستخدم</label>
								<input class="form-control" id="username" type="text" name="username" placeholder="اسم المستخدم" required="">
							</div>
							<div class="col-md-6 mb-3">
								<label for="email">البريد الالكتروني</label>
								<input class="form-control" id="email" type="email" name="email" placeholder="البريد الالكتروني" required="">
							</div>
							<div class="col-md-12 mb-3">
								<label for="role">الدور</label>
								<select class="form-control" id="role" name="role" required="">
									<option value="">اختر الدور</option>
									<?php
										$roles = DB::query("SELECT * FROM roles");
										foreach ($roles as $role) {
											echo '<option value="'.$role['id'].'">'.$role['role_name'].'</option>';
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
									<option value="1">مفعل</option>
									<option value="0">غير مفعل</option>
								</select>
							</div>
						</div>
						<button class="btn btn-primary mt-1 mb-1" type="button" id="AddUser" name="addUser">اضافة مستخدم و البقاء في الصفحة</button>
                        <button class="btn btn-success" type="button" id="AddUserAndClose" name="addUserAndClose">اضافة مستخدم و الانتقال الى القائمة</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>