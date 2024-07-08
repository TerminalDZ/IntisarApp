<div class="container-fluid">
   <div class="page-header">
      <div class="row">
         <div class="col-lg-6 main-header">
            <h2>التأمينات لسنة : <span class="text-primary year"></span></h2>
         </div>
      </div>
   </div>
</div>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card gradient-info o-hidden text-center">
                <div class="b-r-4 card-body">
                    <div class="media static-top-widget">
                        <div class="align-self-center text-center">
                        </div>
                        <div class="media-body text-center">
                            <span class="m-0 text-white">المنخرطين المأمنون</span>
                            <h4 class="mb-0  text-white" id="CountMembersInsuranced"></h4>
                            <span class="m-0 text-white" style="font-size: 12px;" id="PercentMembersInsuranced"></span>
                            <div class="progress mt-3" style="height: 7px;">
                                <div class="progress-bar bg-dark" id="PercentMembersInsurancedBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card gradient-info o-hidden text-center">
                <div class="b-r-4 card-body">
                    <div class="media static-top-widget">
                        <div class="align-self center text-center">
                        </div>
                        <div class="media-body text-center">
                            <span class="m-0 text-white">المنخرطين غير المأمنون</span>
                            <h4 class="mb-0  text-white" id="CountMembersNotInsuranced"></h4>
                            <span class="m-0 text-white" style="font-size: 12px;" id="PercentMembersNotInsuranced"></span>
                            <div class="progress mt-3" style="height: 7px;">
                                <div class="progress-bar bg-dark"  id="PercentMembersNotInsurancedBar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card gradient-info o-hidden text-center">
                <div class="b-r-4 card-body">
                    <div class="media static-top-widget">
                        <div class="align-self center text-center">
                        </div>
                        <div class="media-body text-center">
                            <span class="m-0 text-white">مدفوعات التأمين</span>
                            <h4 class="mb-0  text-white" id="CountMembersSumamountInsuranced"></h4>
                            <span class="mt-1 text-white" style="font-size: 12px;">‎ </span>
                            <div class="mt-3" style="height: 7px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
    </div>
            
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   <h5 class="card-header-text mt-2 mb-2">عرض التأمينات</h5>
                     <div class="form-group">
                        <select class="form-control" name="year" id="yearInput">
                        </select>
                     </div>
                    <div class="card-header-right">
                        <?php if ($add_insurance) { ?>
                        <a href="/?p=addInsurance" class="btn btn-outline-primary " style="margin-top: -20px !important;">اضافة تأمين</a>
                        <button type="button" class="btn btn-primary" id="AddInsuranceFast" style="margin-top: -20px !important;">اضافة تأمين سريع</button>   
                        <?php } ?>              
                    </div>

                </div>
                <div class="card-body table-border-style">
                    <div class="row">
                       
                        <div class="col d-none" id="CloseFilter">
                            <button type="button" class="btn btn-block btn-danger" id="NOFilter"> <span class="fa fa-times"></span> الغاء</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-primary" id="Filtters"> <span class="fa fa-random"></span> الفلتر</button>
                        </div>


                       
                    </div>
                    <div class="table-responsive">
                       <table class="table table-bordered table-striped table-hover" id="TableInsurances">
                          <thead>
                             <tr>
                                <th>الرقم المنخرط</th>
                                <th>الاسم الكامل</th>
                                <th>الرقم التأمين </th>
                                <th>التاريخ</th>
                                <th>المبلغ</th>
                                <th>المدفوع</th>
                                <th> تم الاضافة</th>
                                <th>تم التحديث حالة الدفع</th>
                                <th>العمليات</th>
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