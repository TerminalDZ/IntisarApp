<?php

    if (isset($_GET['token'])) {
        $token = $_GET['token'];
    } else {
        $token = '';
    }

    $current_time = time();
    $where = "access = 1";
    $result = DB::select('users', $where);
    
    $tokens = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_tokens = json_decode($row['tokens'], true);
            if (!empty($user_tokens)) {
                usort($user_tokens, function ($a, $b) {
                    return $b['time'] - $a['time'];
                });
                $last_token = reset($user_tokens);
                if ($last_token) {
                    $tokens[] = $last_token;
                }
            }
        }
    }

    $token_exists = false;
    foreach ($tokens as $t) {
        if ($t['token'] == $token) {
            $token_exists = true;
            break;
        }
    }

    foreach ($tokens as $t) {
        if ($t['token'] == $token && ($current_time - $t['time']) > 300) {
            $token_expired = true;
            break;
        } else {
            $token_expired = false;
        }
    }
        


  




?>


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
                    <h5> اعادة تعيين كلمة المرور</h5>
                </div>
                <div class="card-body">
                    <?php
                    if ($token_exists == true && $token_expired == false && $token != '') {
                    ?>
                    <form>
                        <?=CSRF::create_token();?>
                        <input type="hidden" name="Token" id="TokenReset" value="<?=$token?>">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="Password">كلمة المرور</label>
                                <input class="form-control" id="Password" type="password" name="Password" placeholder="كلمة المرور" required="">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="ConfirmPassword">تأكيد كلمة المرور</label>
                                <input class="form-control" id="ConfirmPassword" type="password" name="ConfirmPassword" placeholder="تأكيد كلمة المرور" required="">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block" type="button" id="BtnReset">إعادة تعيين كلمة المرور</button>
                        
                    </form>
                    <hr>
                    <div class="text-center mt-3">
                        <a href="<?=$base_url?>">تسجيل الدخول</a>
                    </div>
                    <?php
                    } else {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        الرمز غير صالح  أو انتهت صلاحيته
                    </div>
                    <?php
                    }
                    ?>
                     
                </div>
            </div>

        </div>
    </div>
</div>