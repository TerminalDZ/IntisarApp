<style>
    .login-card {
        margin-top: 50px;
        display: flex;
        justify-content: center;
    }
    .card {
        width: 100%;
        max-width: 400px;
    }
    .logo {
        display: block;
        margin: 0 auto 20px;
    }
</style>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 login-card">
            <div class="card">
                <div class="card-header text-center">
                    <img src="<?=$urlUploads?><?=$settings['logo']?>" alt="Logo" class="logo" width="60px" >
                    <h5>تسجيل دخول الى منصة <?=$settings['site_name']?></h5>
                </div>
                <div class="card-body">
                    <form>
                        <?=CSRF::create_token();?>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="EmailOrUsername">بريد الالكتروني أو اسم المستخدم</label>
                                <input class="form-control" id="EmailOrUsername" type="text" name="EmailOrUsername" placeholder="بريد الالكتروني أو اسم المستخدم" required="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="password">كلمة المرور</label>
                                <input class="form-control" id="password" type="password" name="password" placeholder="كلمة المرور" required="">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" type="button" id="BtnLogin" name="login">تسجيل الدخول</button>
                        <div class="custom-control custom-checkbox text-center mt-3">
                            <input type="checkbox" class="custom-control-input" id="RememberMe">
                            <label class="custom-control-label" for="RememberMe">تذكرني</label>
                        </div>
                    </form>
                    <hr>
                    <div class="text-center mt-3">
                        <a href="<?=$base_url?>?auth=forgotP">نسيت كلمة المرور؟</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>