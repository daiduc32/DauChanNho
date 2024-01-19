<?php 
session_start();
require_once('DBConnection.php');

Class Actions extends DBConnection{
    function __construct(){
        parent::__construct();
    }
    function __destruct(){
        parent::__destruct();
    }
    function login(){
        extract($_POST);
        $sql = "SELECT * FROM clients where email = '{$email}' and `password` = '".md5($password)."' ";
        @$qry = $this->conn->query($sql)->fetch_array();
        if(!$qry){
            $resp['status'] = "failed";
            $resp['msg'] = "Invalid email or password.";
        }else{
            $resp['status'] = "success";
            $resp['msg'] = "Login successfully.";
            foreach($qry as $k => $v){
                if(!is_numeric($k))
                $_SESSION[$k] = $v;
            }
        }
        return json_encode($resp);
    }
    function logout(){
        session_destroy();
        header("location: index.php");
    }
    function find_user(){
        extract($_POST);
        $sql = "SELECT *,CONCAT(firstname,' ',middlename,' ',lastname) as `name` FROM `clients` where (CONCAT(firstname,' ',middlename,' ',lastname) LIKE '%{$keyword}%' OR CONCAT(lastname,' ',firstname,' ',middlename) LIKE '%{$keyword}%' OR email LIKE '%{$keyword}%') and id != '{$_SESSION['id']}'";
        $search = $this->conn->query($sql);
        $data = array();
        while($row = $search->fetch_assoc()){
            $row['id'] = md5($row['id']);
            $data[] = $row;
        }
        return json_encode($data);
    }
    function send_message(){
        extract($_POST);
        $from_user = $_SESSION['id'];
        $to_user = $user_to;
        $type = 1;
        $message = $this->conn->real_escape_string(($message));
        $message = str_replace('/r','<br>',$message);
        $ins_message = $this->conn->query("INSERT INTO `messages` set from_user='{$from_user}', to_user='{$to_user}', `type` = '{$type}',`message` ='{$message}' ");
        if($ins_message){
            $resp['status'] = "success";
        }else{
            $resp['status'] = "failed";
            $resp['error'] = $this->conn->error;
        }
        return json_encode($resp);
    }
    function get_messages(){
        extract($_POST);
        $awhere = "";
        $last_id = empty($last_id) ? 0 :$last_id;
        $messages = $this->conn->query("SELECT * FROM `messages` where ((from_user = '{$_SESSION['id']}' and to_user = '{$convo_with}') OR (to_user = '{$_SESSION['id']}' and from_user = '{$convo_with}')) and id > {$last_id} order by unix_timestamp(date_created) asc ");
        $data = array();
        $ids = array();
        while($row = $messages->fetch_assoc()){
            $row['message'] = str_replace('\r','<br>',$row['message']);
            $data[] = $row;
            if($row['from_user'] != $_SESSION['id'])
            $ids[] = $row['id'];
        }
        if(count($ids) > 0)
        $this->conn->query("UPDATE `messages` set status = 1 where id in (".implode(',',$ids).") ");

        return json_encode($data);
    }
    function get_prev_messages(){
        extract($_POST);
        $messages = $this->conn->query("SELECT * FROM `messages` where (from_user = '{$_SESSION['id']}' and to_user = '{$convo_with}') OR (to_user = '{$_SESSION['id']}' and from_user = '{$convo_with}') order by unix_timestamp(date_created) desc limit {$message_limit} offset {$message_offset}");
        $data = array();
        while($row = $messages->fetch_assoc()){
            $data[] = $row;
        }
        return json_encode($data);

    }
    function get_unread(){
        $qry = $this->conn->query("SELECT distinct(m.from_user),m.*,concat(u.firstname,' ',u.lastname) as name FROM `messages` m inner join `clients` u on m.from_user = u.id where m.to_user = '{$_SESSION['id']}' and m.popped = '0' and m.status =0 order by unix_timestamp(m.date_created) desc ");
        $data = array();
        while($row = $qry->fetch_assoc()){
            $row['convo_with'] = $row['from_user'];
            $row['eid'] = md5($row['from_user']);
            $this->conn->query("UPDATE messages set popped = 1 where id <= '{$row['id']}' and from_user = '{$row['from_user']}' and to_user = '{$_SESSION['id']}' ");
            $un_read = $this->conn->query("SELECT * FROM messages where to_user = '{$_SESSION['id']}' and from_user = '{$row['from_user']}' and status = '0' ")->num_rows;
                             $row['un_read'] = $un_read > 0 ? $un_read : '';
            $data[] = $row;
        }
        return json_encode($data);
    }
    function delete_message(){
        extract($_POST);
        $delete = $this->conn->query("UPDATE messages set delete_flag = 1 where id ='{$id}'");
        if($delete){
            $resp['status'] ='success';
        }else{
            $resp['status'] ='failed';
            $resp['err'] =$this->conn->error;
        }
        return json_encode($resp);
    }
    function check_deleted(){
        extract($_POST);
        $data = array();
        if(!empty($ids)){
            $qry = $this->conn->query("SELECT * FROM messages where id in ({$ids}) and delete_flag=1");
            while($row = $qry->fetch_assoc()){
                $data[] = $row['id'];
            }
        }
        return json_encode($data);
    }
}
$a = isset($_GET['a']) ?$_GET['a'] : '';
$action = new Actions();
switch($a){
    case 'login':
        echo $action->login();
    break;
    case 'logout':
        echo $action->logout();
    break;
    case 'find_user':
        echo $action->find_user();
    break;
    case 'send_message':
        echo $action->send_message();
    break;
    case 'get_messages':
        echo $action->get_messages();
    break;
    case 'get_prev_messages':
        echo $action->get_prev_messages();
    break;
    case 'get_unread':
        echo $action->get_unread();
    break;
    case 'delete_message':
        echo $action->delete_message();
    break;
    case 'check_deleted':
        echo $action->check_deleted();
    break;
    default:
    // default action here
    break;
}