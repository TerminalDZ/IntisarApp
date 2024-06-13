<div class="container-fluid">
   <div class="page-header">
      <div class="row">
         <div class="col-lg-6 main-header">
            <h2> اعدادات التأمين </h2>
          </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                   <h4 class="card-title mb-0">الاعدادات الدفع</h4>
                </div>
                <div class="card-body">
                   <?=CSRF::create_token();?>
                   <form class="theme-form settingsInsurance">
                        <div div class="form-group">
                            <h6 class="form-label d-block"> مبلغ التأمين للأشبال </h6>
                            <input type="number" class="form-control" id="amount_cubs" value="<?=$settings['amount_cubs']?>" min="0">
                        </div>
                        <div class="form-group mb-2">
                            <h6 class="form-label d-block"> مبلغ التأمين للزهرات </h6>
                            <input type="number" class="form-control" id="amount_sprouts" value="<?=$settings['amount_sprouts']?>" min="0">
                        </div>
                        <div class="form-group mb-2">
                            <h6 class="form-label d-block"> مبلغ التأمين للكشاف </h6>
                            <input type="number" class="form-control" id="amount_scouts" value="<?=$settings['amount_scouts']?>" min="0">
                        </div>
                        <div class="form-group mb-2">
                            <h6 class="form-label d-block"> مبلغ التأمين للدليلات </h6>
                            <input type="number" class="form-control" id="amount_dalilat" value="<?=$settings['amount_dalilat']?>" min="0">
                        </div>
                          
                        <div class="form-group mb-2">
                            <h6 class="form-label d-block"> مبلغ التأمين للجوالة </h6>
                            <input type="number" class="form-control" id="amount_rangers" value="<?=$settings['amount_rangers']?>" min="0">
                        </div>
                        <div class="form-group mb-2">
                            <h6 class="form-label d-block"> مبلغ التأمين للمرشدات </h6>
                            <input type="number" class="form-control" id="amount_guides" value="<?=$settings['amount_guides']?>" min="0">
                        </div>
                        <div class="form-group mb-2">
                            <h6 class="form-label d-block"> مبلغ التأمين للقادة </h6>
                            <input type="number" class="form-control" id="amount_leaders" value="<?=$settings['amount_leaders']?>" min="0">
                        </div>
                        <div class="form-group mb-2">
                            <h6 class="form-label d-block"> مبلغ التأمين للعمداء </h6>
                            <input type="number" class="form-control" id="amount_masters" value="<?=$settings['amount_masters']?>" min="0">
                        </div>
                        <button type="button" class="btn btn-primary" id="saveSettingsInsurance">حفظ</button>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
                
