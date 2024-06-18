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
                    <h5>نسيت كلمة المرور</h5>
                </div>
                <div class="card-body">
                    <form>
                        <?=CSRF::create_token();?>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="Email">بريد الالكتروني</label>
                                <input class="form-control" id="Email" type="text" name="Email" placeholder="بريد الالكتروني   " required="">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" type="button" id="BtnForgot">إرسال</button>
                        
                    </form>
                    <hr>
                    <div class="text-center mt-3">
                        <a href="<?=$base_url?>">تسجيل الدخول</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>