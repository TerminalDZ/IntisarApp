<?php
    include '../../init.php';
    if (!isset($_SESSION['username'])) {
        header('Location: ' . BASEURL . 'index.php');
        exit();
    }

    $action = $_GET['action'];


    if ($action == 'AddRole'){
        if (!$add_role_permission) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }

        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $role_name = $_POST['roleName'];

        if ($role_name == '') {
            echo json_encode(array('status' => 'error', 'message' => 'الاسم مطلوب'));
            die();
        }

        $data = [
            'role_name' => $role_name
        ];

        $role = DB::query("SELECT * FROM roles WHERE role_name = '$role_name'" );
        if ($role->num_rows > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'الدور موجود بالفعل'));
            die();
        }

        $result = DB::insert('roles', $data);

        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'تمت إضافة الدور بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء إضافة الدور'));
        }
    }elseif ($action == 'DeleteRole'){
        if (!$delet_role_permission) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }
        $role_id = $_POST['roleId'];
        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
            echo json_encode(array('status' => 'error', 'message' => 'لا يمكن حذف هذا الدور'));
            die();
        }

        $users = DB::query("SELECT * FROM user_roles WHERE role_id = $role_id");
        
        if ($users->num_rows > 0) {
            echo json_encode(array('status' => 'error', 'message' => 'لا يمكن حذف الدور لوجود مستخدمين مرتبطين به'));
            die();
        }

        $RolePermission = DB::query("SELECT * FROM role_permissions WHERE role_id = $role_id");
        
        if ($RolePermission->num_rows > 0) {
            $role_permissions = DB::delete('role_permissions', "role_id = $role_id");
        }



        $result = DB::delete('roles', "id = $role_id");

        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'تم حذف الدور بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء حذف الدور'));
        }
    }elseif($action == 'GetPermissions'){



        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $role_id = $_POST['roleId'];


        $permissions = DB::select('permissions');
        $allpermissions = []; 
        while ($permission = $permissions->fetch_assoc()) {
            $allpermissions[] = $permission;
        }


        $role_permissions = DB::query("SELECT * FROM role_permissions WHERE role_id = $role_id");
        $role_permissions_array = [];
        while ($role_permission = $role_permissions->fetch_assoc()) {
            $role_permissions_array[] = $role_permission['permission_id'];
        }

        foreach ($allpermissions as $key => $permission) {
            if (in_array($permission['id'], $role_permissions_array)) {
                $allpermissions[$key]['checked'] = true;
            } else {
                $allpermissions[$key]['checked'] = false;
            }
        }



        


       

        echo json_encode(array('status' => 'success', 'permissions' => $allpermissions));


    }elseif ($action == 'EditRoleAndPermissions'){

        if (!$edit_role_permission) {
            echo json_encode(array('status' => 'error', 'message' => 'ليس لديك الصلاحية للقيام بهذه العملية'));
            return;
        }

        $token = $_POST['token'];

        if (!CSRF::validate($token)) {
            echo json_encode(array('status' => 'error', 'message' => 'CSRF Token is not valid'));
            die();
        }

        $role_id = $_POST['roleId'];
        $permissions = $_POST['permissions'];

        //if ($role_id == 1 || $role_id == 2 || $role_id == 3) {
        //    echo json_encode(array('status' => 'error', 'message' => 'لا يمكن تعديل هذا الدور'));
        //    die();
        //}

       
        $assigned_permissions =  Permission::assignPermissionsToRole($role_id, $permissions);

        if ($assigned_permissions) {
            echo json_encode(array('status' => 'success', 'message' => 'تم تعديل الصلاحيات بنجاح'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'حدث خطأ أثناء تعديل الصلاحيات'));
        }


        



    }

