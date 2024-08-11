<?php
    include '../../init.php';
    if (!isset($_SESSION['username'])) {
        header('Location: ' . BASEURL . 'index.php');
        exit();
    }

    $action = $_GET['action'];

    


    if ($action == 'get_uniforms') {
        $sql = "SELECT * FROM uniforms";
        $result = DB::query($sql);
    
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $member_id = $row['member_id'];
    
            $member_data = DB::select('members', "member_id = '$member_id'", 'first_name, last_name')->fetch_assoc();
    
            $row['member'] = array(
                'first_name' => $member_data['first_name'],
                'last_name' => $member_data['last_name']
            );
    
            $data[] = $row;
        }
    
        if (empty($data)) {
            echo json_encode(array('status' => 'error', 'message' => 'No data found'));
            exit();
        }
    
        echo json_encode(array('status' => 'success', 'message' => 'Data fetched successfully', 'data' => $data));
    }
    

