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
                        <a href="#" id="PrintIDCard" class="btn btn-warning" style="display: none;">طباعة بطاقات المنخرطين</a>
                        <a href="#" id="PrintFormEmpty" class="btn btn-info">طباعة الاستمارة الفارغة</a>
                        <a href="?p=addMember" class="btn btn-primary">إضافة منخرط</a>

                    </div>


                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="members-table">
                            <thead>
                                <tr>
                                    <th># <input type="checkbox" id="CheckAllMembers"></th>
                                    <th>الرقم المنخرط</th>
                                    <th>الصورة</th>
                                    <th>الاسم</th>
                                    <th> اللقب</th>
                                    <th>الجنس</th>
                                    <th>تاريخ الميلاد</th>
                                    <th>اسم الأب</th>
                                    <th>رقم الهاتف</th>
                                    <th>العنوان</th>
                                    <th> مؤمن</th>
                                    <th>رقم التأمين</th>
                                    <th> دافع حقوق التأمين </th>
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
                                foreach ($members as $member) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input MBCHeck" id="member-<?=$member['member_id']?>" value="<?=$member['member_id']?>">
                                        </td>
                                        <td>
                                            <span class="icon GetSpeedDataMember" data_memberid="<?=$member['member_id']?>" style="cursor: pointer;">
                                                <i class="fa fa-search"></i>
                                            </span>
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
                                        <td class="toggle-text" data-fulltext="<?=$member['phone_number']?>"></td>
                                        <td class="toggle-text" data-fulltext="<?=$member['address']?>"></td>
                                        <td>

                                            <?php 
                                            if ($member['insurance'] == 1) {
                                                echo '<span class="badge badge-success">نعم</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">لا</span>';
                                            }
                                            ?>

                                        </td>

                                        <td>

                                            <?php 
                                            if ($member['insurance_number'] != '') {
                                                echo '<span class="badge badge-success">'.$member['insurance_number'].'</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">//<span>';
                                            }
                                            ?>
                                    
                                        </td>

                                        <td>

                                            <?php 
                                            if ($member['insurance_payer'] == 1) {
                                                echo '<span class="badge badge-success">نعم</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">لا</span>';
                                            }
                                            ?>
                                        </td>

                                        <td>

                                            <?php 
                                            if ($member['has_scout_uniform'] == 1) {
                                                echo '<span class="badge badge-success">نعم</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">لا</span>';
                                            }
                                            ?>
                                        </td>

                                        <td>

                                            <?php 
                                            if ($member['scout_uniform_payer'] == 1) {
                                                echo '<span class="badge badge-success">نعم</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">لا</span>';
                                            }
                                            ?>
                                        </td>

                                        <td><?=$member['scout_unit']?></td>
                                        <td class="toggle-text" data-fulltext="<?=$member['joining_date']?>"></td>


                                        <td class="toggle-text" data-fulltext="<?=$member['added_date']?>"></td>
                                        <td class="toggle-text" data-fulltext="<?=$member['last_modified_date']?>"></td>
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