<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-lg-6 main-header">
        <h2>المنخرطين</h2>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid">
    <dvi class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text">المنخرطين</h5>
                  
                    <div class="card-header-right">
                        <?php if ($add_scout) { ?>
                        <a href="?p=addMember" class="btn btn-primary">اضافة منخرط</a>
                        <?php } ?>
                        <a href="#" id="PrintIDCard" class="btn btn-warning" style="display: none;">طباعة بطاقات المنخرطين</a>


                    </div>


                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="members-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الرقم المنخرط</th>
                                    <th>الصورة</th>
                                    <th>الاسم</th>
                                    <th> اللقب</th>
                                    <th>الجنس</th>
                                    <th>تاريخ الميلاد</th>
                                    <th>اسم الأب</th>
                                    <th>رقم الهاتف</th>
                                    <th>العنوان</th>
                                    <th> مؤمن <sub> لهذه السنة</sub></th>
                                    <th>رقم التأمين<sub> لهذه السنة</sub></th>
                                    <th> دافع حقوق التأمين <sub> لهذه السنة</sub></th>
                                    <th> يمتلك لباس </th>
                                    <th> دافع حقوق لباس </th>
                                    <th>وحدة </th>
                                    <th>تاريخ الإلتحاق</th>
                                    <th>تاريخ الإضافة</th>
                                    <th>تاريخ آخر تحديث</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $members = Members::get_all();
                                
                                $filterGender = isset($_GET['gender']) ? $_GET['gender'] : '';
                                $filterScoutUnit = isset($_GET['scout_unit']) ? $_GET['scout_unit'] : '';
                                $filterInsurance = isset($_GET['insurance']) ? $_GET['insurance'] : '';
                                $filterInsurancePaid = isset($_GET['insurancePaid']) ? $_GET['insurancePaid'] : '';
                                
                                $filteredMembers = array_filter($members, function($member) use ($filterGender, $filterScoutUnit, $filterInsurance, $filterInsurancePaid) {
                                    $genderMatch = $filterGender == '' || $member['gender'] == $filterGender;
                                    $scoutUnitMatch = $filterScoutUnit == '' || $member['scout_unit'] == $filterScoutUnit;
                                    $member_id = intval($member['member_id']);

                                    $insuranceResult = DB::query('SELECT * FROM insurances WHERE member_id = '.$member_id.' AND year = '.date('Y').' LIMIT 1');
                                    $hasInsurance = $insuranceResult->num_rows > 0;
                                    $insuranceMatch = $filterInsurance == '' || ($filterInsurance == '1' && $hasInsurance) || ($filterInsurance == '0' && !$hasInsurance);
                                
                                    $insurance = $insuranceResult->fetch_assoc();
                                    $insurancePaid = $insurance && $insurance['paid'] == 1;
                                    $paidMatch = $filterInsurancePaid == '' || ($filterInsurancePaid == '1' && $insurancePaid) || ($filterInsurancePaid == '0' && !$insurancePaid);
                                    
                                    return $genderMatch && $scoutUnitMatch && $insuranceMatch && $paidMatch;
                                });


                                
                                foreach ($filteredMembers as $member) {
                                    $member_id = intval($member['member_id']);
                                    $InsuranceResult = DB::query('SELECT * FROM insurances WHERE member_id = '.$member_id.' AND year = '.date('Y').' LIMIT 1');
                                    $insurance = $InsuranceResult->fetch_assoc();
                                    
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="icon GetSpeedDataMember" data_memberid="<?=$member['member_id']?>" style="cursor: pointer;">
                                                <i class="fa fa-search"></i>
                                            </span>
                                        </td>
                                        
                                        <td data-memberid="<?=$member['member_id']?>">
                                            <?=$member['member_id']?>
                                        </td>
                                        <td class="media user-header"><img src="<?=$urlUploads?><?=$member['picture']?>" alt="<?=$member['first_name']?>" class="img-thumbnail picture" style="width: 50px !important;height: 50px !important;cursor: pointer;"  data-name="<?=$member['first_name']?> <?=$member['last_name']?>"></td>
                                        <td><?=$member['first_name']?></td>
                                        <td><?=$member['last_name']?></td>
                                        <td>

                                            <?php 
                                            if ($member['gender'] == 'ذكر') {
                                                echo '<span class="badge badge-info">ذكر</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">أنثى</span>';
                                            }
                                            ?>

                                        </td>

                                        <td><?=$member['dob']?> (<?=Members::getAge($member['dob'])?> سنة)</td>
                                        <td><?=$member['father_name']?></td>
                                        <td><?=$member['phone_number']?></td>
                                        <td><?=$member['address']?></td>
                                        <td>

                                            <?php 

                                         

                                            if ($InsuranceResult->num_rows > 0) {
                                                echo '<span class="badge badge-success">نعم</span>';
                                                
                                            } else {
                                                echo '<span class="badge badge-danger">لا</span>';
                                            }

                                            ?>

                                        </td>

                                        <td>

                                            <?php 


                                            if ($insurance && $insurance['insurance_number'] != '') {
                                                echo '<span class="badge badge-success">'.$insurance['insurance_number'].'</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">//<span>';
                                            }

                                            
                                            ?>
                                    
                                        </td>

                                        <td>

                                            <?php 

                                            if ($insurance && $insurance['paid'] == 1) {
                                                echo '<span class="badge badge-success">نعم</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">لا</span>';
                                            }

                                            ?>
                                        </td>

                                        <td>

                                            <?php 
                                            if (true) {
                                                echo '<span class="badge badge-success">نعم</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">لا</span>';
                                            }
                                            ?>
                                        </td>

                                        <td>

                                            <?php 
                                            if (true) {
                                                echo '<span class="badge badge-success">نعم</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">لا</span>';
                                            }
                                            ?>
                                        </td>

                                        <td><?=$member['scout_unit']?></td>
                                        <td><?=$member['joining_date']?></td>


                                        <td><?=$member['added_date']?></td>
                                        <td><?=$member['last_modified_date']?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">العمليات</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="?p=editMember&member_id=<?=$member['member_id']?>">تعديل</a>
                                                    <a class="dropdown-item deleteMember" href="#" data-id="<?=$member['member_id']?>">حذف</a>
                                                    <a class="dropdown-item PrintForm" href="#" data-id="<?=$member['member_id']?>">طباعة الاستمارة</a>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                                       
                        </table>
                    </div>
                </div>
            </div>
        </div>
                            
    </dvi>

</div>


<div class="modal fade" id="showFilterModal" tabindex="-1" role="dialog" aria-labelledby="showFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showFilterModalLabel">فلترة النتائج</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="filter-form" method="get" action="?p=members">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="gender-filter">فلترة الجنس</label>
                                <select name="gender" id="gender-filter" class="form-control">
                                    <option value="">الكل</option>
                                    <option value="ذكر" <?=isset($_GET['gender']) && $_GET['gender'] == 'ذكر' ? 'selected' : ''?>>ذكر</option>
                                    <option value="أنثى" <?=isset($_GET['gender']) && $_GET['gender'] == 'أنثى' ? 'selected' : ''?>>أنثى</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="scout-unit-filter">فلترة الوحدة</label>
                                <select name="scout_unit" id="scout-unit-filter" class="form-control">
                                    <option value="">الكل</option>
                                    <option value="أشبال" <?=isset($_GET['scout_unit']) && $_GET['scout_unit'] == 'أشبال' ? 'selected' : ''?>>أشبال</option>
                                    <option value="كشاف" <?=isset($_GET['scout_unit']) && $_GET['scout_unit'] == 'كشاف' ? 'selected' : ''?>>كشاف</option>
                                    <option value="جوال" <?=isset($_GET['scout_unit']) && $_GET['scout_unit'] == 'جوال' ? 'selected' : ''?>>جوال</option>
                                    <option value="زهرات" <?=isset($_GET['scout_unit']) && $_GET['scout_unit'] == 'زهرات' ? 'selected' : ''?>>زهرات</option>
                                    <option value="دليلات" <?=isset($_GET['scout_unit']) && $_GET['scout_unit'] == 'دليلات' ? 'selected' : ''?>>دليلات</option>
                                    <option value="مرشدات" <?=isset($_GET['scout_unit']) && $_GET['scout_unit'] == 'مرشدات' ? 'selected' : ''?>>مرشدات</option>
                                    <option value="قائد" <?=isset($_GET['scout_unit']) && $_GET['scout_unit'] == 'قائد' ? 'selected' : ''?>>قائد</option>
                                    <option value="عميد" <?=isset($_GET['scout_unit']) && $_GET['scout_unit'] == 'عميد' ? 'selected' : ''?>>عميد</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="insurance-filter">فلترة التأمين</label>
                                <select name="insurance" id="insurance-filter" class="form-control">
                                    <option value="">الكل</option>
                                    <option value="1" <?=isset($_GET['insurance']) && $_GET['insurance'] == '1' ? 'selected' : ''?>>مؤمن</option>
                                    <option value="0" <?=isset($_GET['insurance']) && $_GET['insurance'] == '0' ? 'selected' : ''?>>غير مؤمن</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="insurance-paid-filter">فلترة دفع حقوق التأمين</label>
                                <select name="insurancePaid" id="insurance-paid-filter" class="form-control">
                                    <option value="">الكل</option>
                                    <option value="1" <?=isset($_GET['insurancePaid']) && $_GET['insurancePaid'] == '1' ? 'selected' : ''?>>دافع</option>
                                    <option value="0" <?=isset($_GET['insurancePaid']) && $_GET['insurancePaid'] == '0' ? 'selected' : ''?>>لم يدفع</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary">تطبيق الفلترة</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

                        



<div class="modal fade" id="showMemberPicture" tabindex="-1" role="dialog" aria-labelledby="showMemberPictureLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showMemberPictureLabel">صورة المنخرط : <span id="memberName"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body" style="align-items: center;display: contents;justify-content: center;">
                        <img src="" alt="" class="img-fluid mx-auto d-bloc img-thumbnail" id="memberPicture" style="max-width: 200px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>