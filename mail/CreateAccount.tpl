<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تم انشاء حساب جديد بنجاح</title>
     <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            margin-top: 50px;
        }

        .alert {
            padding: 20px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert h4 {
            margin-top: 0;
        }

        .alert hr {
            margin-top: 10px;
            margin-bottom: 10px;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .alert p {
            margin-bottom: 0;
        }

        .alert-heading {
            color: #155724;
        }


        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-success hr {
            border-top-color: #a9dfbf;
        }

        .alert-success p {
            color: #155724;
        }

        .alert-success h4 {
            color: #155724;
        }

        .alert-success .alert-heading {
            color: #155724;
        }

        
        .mb-0 {
            margin-bottom: 0 !important;
        }

        
     </style>
</head>
<body>
    
    
    <div class="container">
        <div class="alert alert-success">
            <h4 class="alert-heading">تم انشاء حساب جديد بنجاح</h4>
            <div class="mb-0">اسم المستخدم: <strong> {{ username }} </strong></div>
            <div class="mb-0">كلمة المرور: <strong> {{ password }} </strong></div>
            <hr>
            <p>تم انشاء حساب جديد بنجاح</p>
        </div>

    </div>


        


</body>
</html>