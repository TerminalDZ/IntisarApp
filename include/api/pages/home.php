<?php
    include '../../init.php';
    if (!isset($_SESSION['username'])) {
        header('Location: ' . BASEURL . 'index.php');
        exit();
    }

    $action = $_GET['action'];



  
    
    if ($action == 'getGenderData') {

        $token = $_GET['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $male = DB::Count('members', 'gender = "ذكر" AND archiv = 0');
        $female = DB::Count('members', 'gender = "أنثى" AND archiv = 0');
    
        $data = array(
            'labels' => ['ذكر', 'أنثى'],
            'datasets' => [
                [
                    'data' => [$male, $female],
                    'backgroundColor' => ['#ff9f40', '#ff5252']
                ]
            ]
        );
    
        echo json_encode($data);
    }elseif ($action == 'getUnitScoutData') {

        $token = $_GET['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }


        $Achbal = DB::Count('members', 'scout_unit = "أشبال" AND archiv = 0');
        $Kashaf = DB::Count('members', 'scout_unit = "كشاف" AND archiv = 0');
        $Jawal = DB::Count('members', 'scout_unit = "جوال" AND archiv = 0');
        $Zaharat = DB::Count('members', 'scout_unit = "زهرات" AND archiv = 0');
        $Dalilat = DB::Count('members', 'scout_unit = "دليلات" AND archiv = 0');
        $Mourchidat = DB::Count('members', 'scout_unit = "مرشدات" AND archiv = 0');
        $Qayed = DB::Count('members', 'scout_unit = "قائد" AND archiv = 0');
        $Amid = DB::Count('members', 'scout_unit = "عميد" AND archiv = 0');

        $data = array(
            'labels' => ['أشبال', 'كشاف', 'جوال', 'زهرات', 'دليلات', 'مرشدات', 'قائد', 'عميد'],
            'datasets' => [
                [
                    'label' => 'وحدة',

                    'data' => [$Achbal, $Kashaf, $Jawal, $Zaharat, $Dalilat, $Mourchidat, $Qayed, $Amid],
                    'backgroundColor' => ['#ffed00', '#448900', '#ff5252', '#ff00cd', '#8d9300', '#5b0000', '#070277', '#1e88e5']
                ]
            ]
        );

        echo json_encode($data);

    }
    

      