<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-lg-6 main-header">
				<h2> اضافة منخرط</h2>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card"> 
                <div class="card-header">
                    <h5>اضافة منخرط</h5>
                </div>
                <div class="card-body">
                    <form id="addMemberForm">
                        <?=CSRF::create_token();?>
                        <div class="form-row">

                            <div class="col-md-12 mb-3 card bg-dark p-3 border text-center">
                                <h5 class="text-white fw-bold">بيانات العضو</h5>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="member_id">رقم العضو <span class="text-danger">*</span></label>
                                <input class="form-control" id="member_id" type="text" name="member_id" placeholder="رقم العضو" required="" readonly="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="first_name">الاسم الاول <span class="text-danger">*</span></label>
                                <input class="form-control" id="first_name" type="text" name="first_name" placeholder="الاسم الاول" required="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">الاسم الاخير <span class="text-danger">*</span></label>
                                <input class="form-control" id="last_name" type="text" name="last_name" placeholder="الاسم الاخير" required="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="gender">الجنس <span class="text-danger">*</span></label>
                                <select class="form-control" id="gender" name="gender" required="">
                                    <option value="">اختر</option>
                                    <option value="ذكر">ذكر</option>
                                    <option value="أنثى">أنثى</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob">تاريخ الميلاد <span class="text-danger">*</span></label>
                                <input class="form-control" id="dob" type="date" name="dob" required="" placeholder="تاريخ الميلاد" max="<?= date('Y-m-d', strtotime('-3 years')); ?>" min="<?= date('Y-m-d', strtotime('-105 years')); ?>">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="place_of_increase">مكان الزيادة <span class="text-danger">*</span></label>
                                <input class="form-control" id="place_of_increase" type="text" name="place_of_increase" placeholder="مكان الزيادة">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="has_been_entered">هل سبق تسجيل عائلة من قبل <span class="text-danger">*</span></label> 
                                <div class="form-check form-check-inline">
                                    <input class="form-check input" type="checkbox" name="has_been_entered" id="has_been_entered_yes" value="0" required="">
                                </div>
                               
                            </div>

                            <div class="col-md-12 mb-3" style="display: none;" id="family_id_div">
                                <label for="family_details">اختر العائلة</label>
                                <select class="form-control" id="family_id" name="family_id">
                                    <option value="">اختر</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="father_name">اسم الاب <span class="text-danger">*</span></label>
                                <input class="form-control" id="father_name" type="text" name="father_name" placeholder="اسم الاب" required="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mother_name">اسم الام <span class="text-danger">*</span></label>
                                <input class="form-control" id="mother_name" type="text" name="mother_name" placeholder="اسم الام" required="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mother_last_name">اسم العائلة للام <span class="text-danger">*</span></label>
                                <input class="form-control" id="mother_last_name" type="text" name="mother_last_name" placeholder="اسم العائلة للام" required="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="job_father">وظيفة الاب <span class="text-danger">*</span></label>
                                <input class="form-control" id="job_father" type="text" name="job_father" placeholder="وظيفة الاب">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="job_mother">وظيفة الام <span class="text-danger">*</span></label>
                                <input class="form-control" id="job_mother" type="text" name="job_mother" placeholder="وظيفة الام">
                            </div>


                            <div class="col-md-6 mb-3">
                                <label for="family_status">الحالة الاجتماعية <span class="text-danger">*</span></label>
                                <select class="form-control" id="family_status" name="family_status" required="">
                                    <option value="">اختر</option>
                                    <option value="لا شي">لا شي</option>
                                    <option value="مطلقان">مطلقان</option>
                                    <option value="وفاة الأب">وفاة الأب</option>
                                    <option value="وفاة الأم">وفاة الأم</option>
                                    <option value="وفاة كلا الوالدين">وفاة كلا الوالدين</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3" style="display: none;" id="caregiver_div">
                                <label for="caregiver">المتكفل <span class="text-danger">*</span></label>
                                <input class="form-control" id="caregiver" type="text" name="caregiver" placeholder="المتكفل">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="living_condition">الحالة المعيشية <span class="text-danger">*</span></label>
                                <select class="form-control" id="living_condition" name="living_condition" required="">
                                    <option value="">اختر</option>
                                    <option value="جيدة">جيدة</option>
                                    <option value="عادية">عادية</option>
                                    <option value="تحت المتوسط">تحت المتوسط</option>
                                    <option value="سيئة">سيئة</option>
                                    <option value="سيئة جدا">سيئة جدا</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="chronic_diseases">الامراض المزمنة</label>
                                <input class="form-control" id="chronic_diseases" type="text" name="chronic_diseases" placeholder="الامراض المزمنة">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="hobbies">الهوايات</label>
                                <input class="form-control" id="hobbies" type="text" name="hobbies" placeholder="الهوايات">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sport">الرياضة المفضلة</label>
                                <input class="form-control" id="sport" type="text" name="sport" placeholder="الرياضة المفضلة">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="educational_institution">المؤسسة التعليمية</label>
                                <input class="form-control" id="educational_institution" type="text" name="educational_institution" placeholder="المؤسسة التعليمية">
                            </div>


                            <div class="col-md-12 mb-3 card bg-dark p-3 border text-center">
                                <h5 class="text-white fw-bold">بيانات الاتصال</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="guardian_id_number">رقم الهوية للولي <span class="text-danger">*</span></label>
                                <input class="form-control" id="guardian_id_number" type="text" name="guardian_id_number" placeholder="رقم الهوية للولي" required="">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone_number">رقم الهاتف <span class="text-danger">*</span></label>
                                <input class="form-control" id="phone_number" type="text" name="phone_number" placeholder="رقم الهاتف" required="">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address">العنوان <span class="text-danger">*</span></label>
                                <input class="form-control" id="address" type="text" name="address" placeholder="العنوان" required="">
                            </div>

                           

                            <div class="col-md-12 mb-3 card bg-dark p-3 border text-center">
                                <h5 class="text-white fw-bold">بيانات الكشفية</h5>
                            </div>
                            
                       

                            <div class="col-md-12 mb-3">
                                <label for="scout_unit">الوحدة الكشفية <span class="text-danger">*</span></label>
                                <select class="form-control" id="scout_unit" name="scout_unit" required="">
                                    <option value="">اختر</option>
                                    <optgroup label="من 06 الى 09 سنوات">
                                        <option value="أشبال">أشبال</option>
                                        <option value="زهرات">زهرات</option>
                                    <optgroup label="من 10 الى 14 سنة">
                                        <option value="كشاف">كشاف</option>
                                        <option value="دليلات">دليلات</option>
                                    <optgroup label="من 15 الى 18 سنة">
                                        <option value="جوال">جوال</option>
                                        <option value="مرشدات">مرشدات</option>
                                    <optgroup label="من 18 الى 99 سنة">
                                        <option value="قائد">قائد</option>
                                        <option value="عميد">عميد</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3 card bg-dark p-3 border text-center">
                                <h5 class="text-white fw-bold">الصورة</h5>
                            </div>

                            <div class="col-md-12 mb-3">
                                <input class="form-control" id="picture" type="file" name="picture" accept="image/*">
                                <button type="button" class="btn btn-secondary mt-2" id="openCameraButton">إلتقاط صورة</button>
                            </div>
                            <div class="col-md-12 mb-3" id="camera" style="display: none;">
                                <div id="my_camera"></div>
                                <button type="button" class="btn btn-primary mt-2" id="takePictureButton">إلتقاط</button>
                                
                            </div>
                            <div class="col-md-12 mb-3" id="capturedImageContainer" style="display: none;">
                                <img id="capturedImage" src="" alt="صورة ملتقطة" class="img-thumbnail">
                                <button type="button" class="btn btn-secondary mt-2" id="retakePictureButton">إعادة إلتقاط</button>
                                <button type="button" class="btn btn-danger mt-2" id="deletePictureButton">حذف</button>
                            </div>

                            <div class="col-md-12 mb-3 card bg-dark p-3 border text-center">
                                <h5 class="text-white fw-bold"> تاريخ الإلتحاق والانضمام للفوج </h5>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="joining_date">تاريخ الإلتحاق <span class="text-danger">*</span></label>
                                <input class="form-control" id="joining_date" type="date" name="joining_date" required="" placeholder="تاريخ الإلتحاق" max="<?= date('Y-m-d'); ?>">
                            </div>


                            
                        </div>
                    </form>
                    <div class="card-footer">
                        <button class="btn btn-primary btn-block mt-3 mb-3" type="button" id="AddMember" name="addMember">اضافة وبقاء في الصفحة</button>
                        <button class="btn btn-success btn-block mt-3 mb-3" type="button" id="AddMemberAndClose" name="addMemberAndClose"> اضافة والانتقال الى القائمة</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>