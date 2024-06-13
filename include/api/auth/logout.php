<?php

    include '../../init.php';

    
    session_destroy();

    echo json_encode(array('status' => 'success', 'message' => 'تم تسجيل الخروج بنجاح'));

    
