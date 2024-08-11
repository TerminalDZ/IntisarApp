<div class="container-fluid">
   <div class="page-header">
      <div class="row">
         <div class="col-lg-6 main-header">
            <h2> اضافة زي جديد</h2>
          </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>اضافة زي جديد</h5>
                </div>
                <div class="card-body">
                    <form id="addUniformForm">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState"> أدخل رقم المنخرط</label>
                                <input type="text" class="form-control" id="member_idInput"> 
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputState">المنخرط</label>
                                <select id="member_idSelect" class="form-control">
                                   
                                </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputState">الزي</label>
                                <select id="uniform_select" class="form-control">
                                    <option value="قميص">قميص</option>
                                    <option value="شارة">شارة</option>
                                    <option value="منديل">منديل</option>
                                    <option value="قبعة">قبعة</option>
                                    <option value="سترة">سترة</option>
                                    <option value="سروال">سروال</option>
                                </select>
                            </div>
                        
                            <div class="form-group col-md-6">
                                <label for="inputState">الحجم</label>
                                <select id="size" class="form-control">
                                    <option value="" selected>اختر...</option>
                                    <option value="XS">XS</option>
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                    <option value="XXXL">XXXL</option>
                                    <option value="2">2</option>
                                    <option value="4">4</option>
                                    <option value="6">6</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                    <option value="12">12</option>
                                    <option value="14">14</option>
                                    <option value="16">16</option>
                                    <option value="18">18</option>
                                    <option value="20">20</option>
                                    <option value="22">22</option>
                                    <option value="24">24</option>
                                    <option value="26">26</option>
                                    <option value="28">28</option>
                                    <option value="30">30</option>
                                    <option value="32">32</option>
                                    <option value="34">34</option>
                                    <option value="36">36</option>
                                    <option value="38">38</option>
                                    <option value="40">40</option>
                                    <option value="42">42</option>
                                    <option value="44">44</option>
                                    <option value="46">46</option>
                                    <option value="48">48</option>
                                    <option value="50">50</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputState">السعر</label>
                                <input type="text" class="form-control" id="price">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputState">مدفوع</label>
                                <select id="paid" class="form-control">
                                    <option value="" selected>اختر...</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputState">المستلم</label>
                                <select id="received" class="form-control">
                                    <option value="" selected>اختر...</option>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label for="inputState">الملاحظات</label>
                                <textarea class="form-control" id="notes" rows="3"></textarea>
                            </div>

                        </div>

                        <button type="button" class="btn btn-primary" id="addUniform">اضافة وبقاء في الصفحة</button>

                        <button type="button" class="btn btn-primary" id="addUniformAndReturn">اضافة و عودة</button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>
