<?php
           
    if(isset($_GET['p'])){
        $page = $_GET['p'];

       $file = './pages/app/'.$page.'.php';
        
        if(file_exists($file)){
            if(
                //Members
                $page == 'members' && !$show_scout ||
                $page == 'addMember' && !$add_scout ||
                $page == 'MemberArchive' && (!$show_scout || !$delete_scout) ||
                $page == 'editMember' && (!$show_scout || !$edit_scout) ||

                //Insurances
                $page == 'insurances' && !$show_insurance || 
                $page == 'addInsurance' && !$add_insurance ||


                //Users
                $page == 'users' && !$show_users ||
                $page == 'addUser' && !$add_user ||
                $page == 'editUser' && (!$show_users || !$edit_user) ||


                //Settings
                $page == 'settingsSystem' && !$edit_website_settings ||
                $page == 'settingsInsurance' && !$edit_insurance_settings ||

                //Role and Permission
                $page == 'permissionsRoles' && !$show_role_permission
            ){
                include('./pages/error/403.php');
            }else {
                include($file);
            }

        }else{
            include('./pages/error/404.php');
        }
    }else{
        include('./pages/app/home.php');
    }
