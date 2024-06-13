<?php
if (!isset($_GET['member_id'])) {
    
    echo '<script>window.location.href = "'.$base_url.'?p=members";</script>';


    exit; 
}

$id = $_GET['member_id'];

$member = Members::get_data_member_id($id);

if ($member == null) {
    echo '<script>window.location.href = "'.$base_url.'?p=members";</script>';
    exit;
}
?>

<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-lg-6 main-header">
				<h2>تعديل المنخرط</h2>
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
                                <input class="form-control" id="member_id" type="text" name="member_id" placeholder="رقم العضو" required="" readonly="" value="<?= $member['member_id']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="first_name">الاسم الاول <span class="text-danger">*</span></label>
                                <input class="form-control" id="first_name" type="text" name="first_name" placeholder="الاسم الاول" required="" value="<?= $member['first_name']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">الاسم الاخير <span class="text-danger">*</span></label>
                                <input class="form-control" id="last_name" type="text" name="last_name" placeholder="الاسم الاخير" required="" value="<?= $member['last_name']; ?>">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="gender">الجنس <span class="text-danger">*</span></label>
                                <select class="form-control" id="gender" name="gender" required="">
                                    <option value="">اختر</option>
                                    <option value="ذكر" <?= $member['gender'] == 'ذكر' ? 'selected' : ''; ?>>ذكر</option>
                                    <option value="أنثى" <?= $member['gender'] == 'أنثى' ? 'selected' : ''; ?>>أنثى</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob">تاريخ الميلاد <span class="text-danger">*</span></label>
                                <input class="form-control" id="dob" type="date" name="dob" required="" placeholder="تاريخ الميلاد" max="<?= date('Y-m-d', strtotime('-3 years')); ?>" min="<?= date('Y-m-d', strtotime('-105 years')); ?>" value="<?= $member['dob']; ?>">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="place_of_increase">مكان الزيادة <span class="text-danger">*</span></label>
                                <input class="form-control" id="place_of_increase" type="text" name="place_of_increase" placeholder="مكان الزيادة" required="" value="<?= $member['place_of_increase']; ?>">
                            </div>

                 

                            <div class="col-md-12 mb-3">
                                <label for="father_name">اسم الاب <span class="text-danger">*</span></label>
                                <input class="form-control" id="father_name" type="text" name="father_name" placeholder="اسم الاب" required="" value="<?= $member['father_name']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mother_name">اسم الام <span class="text-danger">*</span></label>
                                <input class="form-control" id="mother_name" type="text" name="mother_name" placeholder="اسم الام" required="" value="<?= $member['mother_name']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mother_last_name">اسم العائلة للام <span class="text-danger">*</span></label>
                                <input class="form-control" id="mother_last_name" type="text" name="mother_last_name" placeholder="اسم العائلة للام" required="" value="<?= $member['mother_last_name']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="job_father">وظيفة الاب <span class="text-danger">*</span></label>
                                <input class="form-control" id="job_father" type="text" name="job_father" placeholder="وظيفة الاب" value="<?= $member['job_father']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="job_mother">وظيفة الام <span class="text-danger">*</span></label>
                                <input class="form-control" id="job_mother" type="text" name="job_mother" placeholder="وظيفة الام" value="<?= $member['job_mother']; ?>">
                            </div>


                            <div class="col-md-6 mb-3">
                                <label for="family_status">الحالة الاجتماعية <span class="text-danger">*</span></label>
                                <select class="form-control" id="family_status" name="family_status" required="">
                                    <option value="">اختر</option>
                                    <option value="لا شي" <?= $member['family_status'] == 'لا شي' ? 'selected' : ''; ?>>لا شي</option>
                                    <option value="مطلقان" <?= $member['family_status'] == 'مطلقان' ? 'selected' : ''; ?>>مطلقان</option>
                                    <option value="وفاة الأب" <?= $member['family_status'] == 'وفاة الأب' ? 'selected' : ''; ?>>وفاة الأب</option>
                                    <option value="وفاة الأم" <?= $member['family_status'] == 'وفاة الأم' ? 'selected' : ''; ?>>وفاة الأم</option>
                                    <option value="وفاة كلا الوالدين" <?= $member['family_status'] == 'وفاة كلا الوالدين' ? 'selected' : ''; ?>>وفاة كلا الوالدين</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3" style="display: none;" id="caregiver_div">
                                <label for="caregiver">المتكفل <span class="text-danger">*</span></label>
                                <input class="form-control" id="caregiver" type="text" name="caregiver" placeholder="المتكفل" value="<?= $member['caregiver']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="living_condition">الحالة المعيشية <span class="text-danger">*</span></label>
                                <select class="form-control" id="living_condition" name="living_condition" required="">
                                    <option value="">اختر</option>
                                    <option value="جيدة" <?= $member['living_condition'] == 'جيدة' ? 'selected' : ''; ?>>جيدة</option>
                                    <option value="عادية" <?= $member['living_condition'] == 'عادية' ? 'selected' : ''; ?>>عادية</option>
                                    <option value="تحت المتوسط" <?= $member['living_condition'] == 'تحت المتوسط' ? 'selected' : ''; ?>>تحت المتوسط</option>
                                    <option value="سيئة" <?= $member['living_condition'] == 'سيئة' ? 'selected' : ''; ?>>سيئة</option>
                                    <option value="سيئة جدا" <?= $member['living_condition'] == 'سيئة جدا' ? 'selected' : ''; ?>>سيئة جدا</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="chronic_diseases">الامراض المزمنة</label>
                                <input class="form-control" id="chronic_diseases" type="text" name="chronic_diseases" placeholder="الامراض المزمنة" value="<?= $member['chronic_diseases']; ?>">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="hobbies">الهوايات</label>
                                <input class="form-control" id="hobbies" type="text" name="hobbies" placeholder="الهوايات" value="<?= $member['hobbies']; ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sport">الرياضة المفضلة</label>
                                <input class="form-control" id="sport" type="text" name="sport" placeholder="الرياضة المفضلة" value="<?= $member['sport']; ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="educational_institution">المؤسسة التعليمية</label>
                                <input class="form-control" id="educational_institution" type="text" name="educational_institution" placeholder="المؤسسة التعليمية" value="<?= $member['educational_institution']; ?>">
                            </div>


                            <div class="col-md-12 mb-3 card bg-dark p-3 border text-center">
                                <h5 class="text-white fw-bold">بيانات الاتصال</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="guardian_id_number">رقم الهوية للولي <span class="text-danger">*</span></label>
                                <input class="form-control" id="guardian_id_number" type="text" name="guardian_id_number" placeholder="رقم الهوية للولي" required="" value="<?= $member['guardian_id_number']; ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone_number">رقم الهاتف <span class="text-danger">*</span></label>
                                <input class="form-control" id="phone_number" type="text" name="phone_number" placeholder="رقم الهاتف" required="" value="<?= $member['phone_number']; ?>">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address">العنوان <span class="text-danger">*</span></label>
                                <input class="form-control" id="address" type="text" name="address" placeholder="العنوان" required="" value="<?= $member['address']; ?>">
                            </div>

                            <div class="col-md-12 mb-3 card bg-dark p-3 border text-center">
                                <h5 class="text-white fw-bold"> بيانات التأمين</h5>
                            </div>
                           

                            <div class="col-md-6 mb-3">
                                <label for="insurance_payer">هل منخرط دافع التأمين <span class="text-danger">*</span></label>
                                <select class="form-control" id="insurance_payer" name="insurance_payer" required="">
                                    <option value="">اختر</option>
                                    <option value="1" <?= $member['insurance_payer'] == 1 ? 'selected' : ''; ?>>نعم</option>
                                    <option value="0" <?= $member['insurance_payer'] == 0 ? 'selected' : ''; ?>>لا</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="insurance"> هل المنخرط مؤمن <span class="text-danger">*</span></label>
                                <select class="form-control" id="insurance" name="insurance" required="">
                                    <option value="">اختر</option>
                                    <option value="1" <?= $member['insurance'] == 1 ? 'selected' : ''; ?>>نعم</option>
                                    <option value="0" <?= $member['insurance'] == 0 ? 'selected' : ''; ?>>لا</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3" style="display: none;" id="insurance_number_div">
                                <label for="insurance_number">رقم التأمين <span class="text-danger">*</span></label>
                                <input class="form-control" id="insurance_number" type="text" name="insurance_number" placeholder="رقم التأمين" value="<?= $member['insurance_number']; ?>">
                            </div>

                            <div class="col-md-12 mb-3 card bg-dark p-3 border text-center">
                                <h5 class="text-white fw-bold">بيانات الكشفية</h5>
                            </div>
                            
                           
                            <div class="col-md-6 mb-3">
                                <label for="has_scout_uniform">هل لديه زي كشفي <span class="text-danger">*</span></label>
                                <select class="form-control" id="has_scout_uniform" name="has_scout_uniform" required="">
                                    <option value="">اختر</option>
                                    <option value="1" <?= $member['has_scout_uniform'] == 1 ? 'selected' : ''; ?>>نعم</option>
                                    <option value="0" <?= $member['has_scout_uniform'] == 0 ? 'selected' : ''; ?>>لا</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="scout_uniform_size">مقاس الزي الكشفي</label>
                                <input class="form-control" id="scout_uniform_size" type="text" name="scout_uniform_size" placeholder="مقاس الزي الكشفي" value="<?= $member['scout_uniform_size']; ?>">
                            </div>


                            <div class="col-md-12 mb-3">
                                <label for="scout_uniform_payer"> هل منخرط دافع ثمن الزي الكشفي <span class="text-danger">*</span></label>
                                <select class="form-control" id="scout_uniform_payer" name="scout_uniform_payer" required="">
                                    <option value="">اختر</option>
                                    <option value="1" <?= $member['scout_uniform_payer'] == 1 ? 'selected' : ''; ?>>نعم</option>
                                    <option value="0" <?= $member['scout_uniform_payer'] == 0 ? 'selected' : ''; ?>>لا</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="scout_unit">الوحدة الكشفية <span class="text-danger">*</span></label>
                                <select class="form-control" id="scout_unit" name="scout_unit" required="">
                                    <option value="">اختر</option>
                                    <optgroup label="من 06 الى 09 سنوات">
                                        <option value="أشبال" <?= $member['scout_unit'] == 'أشبال' ? 'selected' : ''; ?>>أشبال</option>
                                        <option value="زهرات" <?= $member['scout_unit'] == 'زهرات' ? 'selected' : ''; ?>>زهرات</option>
                                    <optgroup label="من 10 الى 14 سنة">
                                        <option value="كشاف" <?= $member['scout_unit'] == 'كشاف' ? 'selected' : ''; ?>>كشاف</option>
                                        <option value="دليلات" <?= $member['scout_unit'] == 'دليلات' ? 'selected' : ''; ?>>دليلات</option>
                                    <optgroup label="من 15 الى 18 سنة">
                                        <option value="جوال" <?= $member['scout_unit'] == 'جوال' ? 'selected' : ''; ?>>جوال</option>
                                        <option value="مرشدات" <?= $member['scout_unit'] == 'مرشدات' ? 'selected' : ''; ?>>مرشدات</option>
                                    <optgroup label="من 18 الى 99 سنة">
                                        <option value="قائد" <?= $member['scout_unit'] == 'قائد' ? 'selected' : ''; ?>>قائد</option>
                                        <option value="عميد" <?= $member['scout_unit'] == 'عميد' ? 'selected' : ''; ?>>عميد</option>
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
                            <div class="col-md-12 mb-3" id="capturedImageContainer">
                                <img id="capturedImage" src="<?=$urlUploads?><?= $member['picture']; ?>" alt="صورة ملتقطة" class="img-thumbnail" style="width: 100px;">
                                <button type="button" class="btn btn-secondary mt-2" id="retakePictureButton">إعادة إلتقاط</button>
                                <button type="button" class="btn btn-danger mt-2" id="deletePictureButton" style="display: none;">حذف </button>
                            </div>

                            <div class="col-md-12 mb-3 card bg-dark p-3 border text-center">
                                <h5 class="text-white fw-bold"> تاريخ الإلتحاق والانضمام للفوج </h5>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="joining_date">تاريخ الإلتحاق <span class="text-danger">*</span></label>
                                <input class="form-control" id="joining_date" type="date" name="joining_date" required="" placeholder="تاريخ الإلتحاق" max="<?= date('Y-m-d'); ?>" value="<?= $member['joining_date']; ?>">
                            </div>


                            
                        </div>
                    </form>
                    <div class="card-footer">
                        <button class="btn btn-primary btn-block mt-3 mb-3" type="button" id="UpdateMember" name="UpdateMember">تعديل وبقاء في الصفحة</button>
                        <button class="btn btn-success btn-block mt-3 mb-3" type="button" id="UpdateMemberAndClose" name="UpdateMemberAndClose"> تعديل والانتقال الى القائمة</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>