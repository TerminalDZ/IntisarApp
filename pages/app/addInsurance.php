<div class="container-fluid">
   <div class="page-header">
      <div class="row">
         <div class="col-lg-6 main-header">
            <h2> اضافة تأمين جديد</h2>
          </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>اضافة تأمين جديد</h5>
                    <div class="card-header-right">
                       <button type="button" class="btn btn-primary" id="scanQR">ماسح QR</button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="addInsuranceForm">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState"> أدخل رقم المنخرط</label>
                                <input type="text" class="form-control" id="member_idInput">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="inputState">المنخرط</label>
                                <select id="member_idSelect" class="form-control">
                                    <option value="" selected>اختر...</option>
                                    <?php
                                    $members = Members::get_all();
                                    foreach ($members as $member) {
                                        echo '<option value="'.$member['member_id'].'">'.$member['first_name'].' '.$member['last_name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputState">السنة</label>
                                <span class="text-primary" id="CerrryYear"><?=date('Y');?> / <?=date('Y')+1;?></span>
                                <span id="changeYear" style="cursor: pointer; color: blue;">تغير السنة</span>
                                <div class="row" id="changeYearDiv" style="display: none;">
                                    <div class="col-md-12" id="yearDiv">
                                        <label for="inputState">السنة</label>
                                        <select name="InputYear" id="InputYear" class="form-control">
                                            
                                        </select>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">المبلغ</label>
                                <input type="text" class="form-control" id="amount">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputState">المدفوع</label>
                                <select id="paid" class="form-control">
                                    <option value="" selected>اختر...</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="Selectgeneral_command">هل مؤمن لدى القيادة العامة</label>
                                <select id="general_command" class="form-control">
                                    <option value="" selected>اختر...</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>
                            </div>
                            
                        </div>

                        <button type="button" class="btn btn-primary" id="addInsurance">اضافة وبقاء في الصفحة</button>
                        <button type="button" class="btn btn-primary" id="addInsuranceAndReturn">اضافة و عودة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

