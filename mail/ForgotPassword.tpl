<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور</title>
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
            <h4 class="alert-heading">إعادة تعيين كلمة المرور</h4>
            <div class="mb-0">لتعيين كلمة المرور الجديدة، يرجى الضغط على الرابط التالي:</div>
            <div class="mb-0"><a href="{{ site_url }}?auth=resetP&token={{ token }}">إعادة تعيين كلمة المرور</a></div>
            <hr>
            <p>إذا لم تطلب إعادة تعيين كلمة المرور، يرجى تجاهل هذا البريد الإلكتروني سيتم حذفه بعد 30 دقيقة </p>
        </div>
    </div>
</body>
</html>
