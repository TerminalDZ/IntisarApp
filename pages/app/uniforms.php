<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-lg-6 main-header">
        <h2>مستلمي الزي</h2>
      </div>
    </div>
  </div>
</div>
<?=CSRF::create_token();?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <div class="card-header-right">
                    <?php if ($add_uniform) { ?>
                      <a class="btn btn-sm btn-outline-primary" href="/?p=addUniform"> اضافة مستلم زي</a>
                    <?php } ?>
                  </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="UniformsTable" class="display table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>الرقم المنخرط</th>
                              <th>الاسم الكامل
                              <th>الزي</th>
                              <th>الحجم</th>
                              <th>السعر</th>
                              <th>مدفوع</th>
                              <th>المستلم</th>
                              <th>الملاحظات</th>
                            </tr>
                          </thead>


                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    