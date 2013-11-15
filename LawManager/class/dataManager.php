<?php
session_start();
require 'db.inc.php';
require 'PasswordHash.php';

class dataManager {
    
    public $db_conn;
    public $user_id;
    private $host = MYSQL_HOST ;
    private $db_name = MYSQL_DB;
    
    function __construct() {
        try {
        $this->db_conn = new PDO("mysql:host=$this->host;dbname=$this->db_name;",MYSQL_USER,MYSQL_PASSWORD);
        }  catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
    
    function loginUser($username,$password) {
        $pwdHasher = new PasswordHash(8, FALSE);
        
        $query = $this->db_conn->prepare('SELECT * FROM user WHERE username = ?');
        $values = array($username);
        $query->execute($values);
        
        $obj = $query->fetch(PDO::FETCH_OBJ);
        
        if($pwdHasher->CheckPassword($password,$obj->password)) {
        $this->user_id = $obj->user_id;
        setcookie('law_logged',1,time()+360000);									//COOKIE variables initialisation
        setcookie('law_username',$obj->username,time()+360000);
        setcookie('law_name',$obj->name,time()+360000);
        setcookie('law_user_id',$this->user_id,time()+360000);
        setcookie('law_user_role',$obj->role,time()+360000);
       
        if($obj->status == 0) return 2; 
        
        return 1;
        }else return 0;
               
    }
    
    function isLogged() {
        if($_COOKIE['law_logged']==1) return true;
        else return false;
    }
    
    function logoutUSER() {
        setcookie('law_logged',0,time()-3600);									//COOKIE variables initialisation
        setcookie('law_username','',time()-3600);
        setcookie('law_name','',time()-3600);
        setcookie('law_user_id','',time()-3600);
        setcookie('law_user_role','',time()-3600);
        
    }
    
    function registerUser($username,$password,$name,$role) {
        try {
        $pwdHasher = new PasswordHash(8, FALSE);
        $hash = $pwdHasher->HashPassword($password);
        $query = $this->db_conn->prepare('INSERT INTO user (username,password,name,role) VALUES (?,?,?,?);');
        $values = array($username,$hash,$name,$role);
        $query->execute($values);
        return 1;
        }catch(PDOException $e) {
            return 0;
        }
    }
    
    function getUser($user_id) {
        $query = $this->db_conn->prepare('SELECT * FROM user WHERE user_id = ?');
        $values = array($user_id);
        $query->execute($values);
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    function checkDuplicateUser($username) {
        $query = $this->db_conn->prepare('SELECT COUNT(*) AS ct FROM user WHERE username = ?');
        $values = array($username);
        $query->execute($values);
        $obj = $query->fetch(PDO::FETCH_OBJ);
        //echo 'Object->ct :' . $obj->ct;
        if($obj->ct>= 1) return true;
        else false;
        
    }
    
    function addPoliceStation($station_name,$address,$state,$city) {
        try {
        $query = $this->db_conn->prepare('INSERT INTO police_station (station_name,address,state,city) VALUES (?,?,?,?);');
        $values = array($station_name,$address,$state,$city);
        $query->execute($values);
        return 1;
        }catch(PDOException $e) {
            return 0;
        }
    }
    
    function enterUserDetails($table,$user_id,$address,$state,$city,$police_station) {

        try {
        if($table == 'citizen') {    
        $query = $this->db_conn->prepare('INSERT INTO citizen (user_id,address,state,city,police_station) VALUES (?,?,?,?,?);');
        $values = array($user_id,$address,$state,$city,$police_station);
        $query->execute($values);
        
        }
        
        if($table == 'police') {
        $query = $this->db_conn->prepare('INSERT INTO police (user_id,address,state,city,police_station,designation) VALUES (?,?,?,?,?,0);');  
        $values = array($user_id,$address,$state,$city,$police_station);
        $query->execute($values);
        }
        
        if($table == 'magistrate') {    
        $query = $this->db_conn->prepare('INSERT INTO magistrate (user_id,address,state,city,police_station) VALUES (?,?,?,?,?);');
        $values = array($user_id,$address,$state,$city,$police_station);
        $query->execute($values);
        
        }
        
        $query2 = $this->db_conn->prepare('UPDATE user SET status = 1 WHERE user_id = ?');
        $values2 = array($user_id);
        $query2->execute($values2);
        
        return 1;    
       
        }catch(PDOException $e) {
         return 0;
        }    
    }
    
    function addComplaint($type,$description,$user_id) {
        $query = $this->db_conn->prepare('SELECT police_station FROM citizen WHERE user_id = ?');
        $values = array($user_id);
        $query->execute($values);
        
        $dt = date('Y-n-j',  time());
        $temp_status = 'Forwarded to Respective Police Station';
        $obj = $query->fetch(PDO::FETCH_OBJ);
        $query2 = $this->db_conn->prepare('INSERT INTO complaint (complaint_id,complaint_type,complaint_description,police_station,user_id,date,status,flag) VALUES (NULL,?,?,?,?,?,?,0)');
        $values2 = array($type,$description,$obj->police_station,$user_id,$dt,$temp_status);
        $query2->execute($values2);
        
        
        return $this->db_conn->lastInsertId();
    }
    
    function getComplaintStatus($complaint_id,$user_id) {
        $query = $this->db_conn->prepare('SELECT * FROM complaint WHERE complaint_id = ? AND user_id = ?');
        $values = array($complaint_id,$user_id);
        $query->execute($values);
        
        $obj = $query->fetch(PDO::FETCH_OBJ);
        return $obj;
    }
    
    function getComplaint($complaint_id) {
        $query = $this->db_conn->prepare('SELECT * FROM complaint WHERE complaint_id = ?');
        $values = array($complaint_id);
        $query->execute($values);
        
        $obj = $query->fetch(PDO::FETCH_OBJ);
        return $obj;
    }
    
    function getComplaints($flag,$user_id) {
        //echo 'user_id = ' . $user_id;
        $query = $this->db_conn->prepare('SELECT * FROM police WHERE user_id = ?');
        $values = array($user_id);
        $query->execute($values);
        $obj = $query->fetch(PDO::FETCH_OBJ);
        
        $query2 = $this->db_conn->prepare('SELECT * FROM complaint WHERE police_station = ? AND flag = ?'); 
        $values2 = array($obj->police_station,$flag);
        $query2->execute($values2);
        
        //var_dump($values2);
        //var_dump($query2);
        return $query2;
    }
    
    function addFIR($complaint_id,$refer_dept,$notes,$user_id) {
        
        $query2 = $this->db_conn->prepare('SELECT police_station FROM police WHERE user_id = ?');
        $values2 = array($user_id);
        $query2->execute($values2);
        $obj = $query2->fetch(PDO::FETCH_OBJ);
        
        $status = 'FIR Lodged. Forwarded to Concerned Department';
        
        $dt = date('Y-n-j',  time());
        $query = $this->db_conn->prepare('INSERT INTO fir (fir_id,complaint_id,police_station,refer_dept,notes,status,flag,date) VALUES (NULL,?,?,?,?,?,0,?)');
        $values = array($complaint_id,$obj->police_station,$refer_dept,$notes,$status,$dt);
        $query->execute($values);
        $fir_id = $this->db_conn->lastInsertId(); 
        
        $status2 = 'FIR has been lodged. FIR id = <strong>' . $fir_id . '</strong>';
        $query3 = $this->db_conn->prepare('UPDATE complaint SET status = ?,flag = 1 WHERE complaint_id = ?');
        $values3 = array($status2,$complaint_id);
        $query3->execute($values3);
        
        return $fir_id;
        
    }
    
    function getFIRStatus($fir_id) {
        $query = $this->db_conn->prepare('SELECT * FROM fir WHERE fir_id = ?');
        $values = array($fir_id);
        $query->execute($values);
        
        $obj = $query->fetch(PDO::FETCH_OBJ);
        return $obj;
    }
    
    function getPoliceStation($station_id) {
        $query = $this->db_conn->prepare('SELECT * FROM police_station WHERE police_id = ?');
        $values = array($station_id);
        $query->execute($values);
        
        $obj = $query->fetch(PDO::FETCH_OBJ);
        return $obj;
    }
    
    function getCity($city_id) {
        $query = $this->db_conn->prepare('SELECT * FROM city WHERE city_id = ?');
        $values = array($city_id);
        $query->execute($values);
        
        $obj = $query->fetch(PDO::FETCH_OBJ);
        return $obj;
    }
    
    function getState($state_id) {
        $query = $this->db_conn->prepare('SELECT * FROM state WHERE state_id = ?');
        $values = array($state_id);
        $query->execute($values);
        
        $obj = $query->fetch(PDO::FETCH_OBJ);
        return $obj;
    }
    
    function getAllState() {
        $query = $this->db_conn->prepare('SELECT * FROM state');
        
        $query->execute();
        
        return $query;
    }
    function getAllCity($state_id) {
        $query = $this->db_conn->prepare('SELECT * FROM city WHERE state_id = ?');
        $values = array($state_id);
        $query->execute($values);
        
        return $query;
    }
    function getPoliceOfficers($police_station) {
        $query = $this->db_conn->prepare('SELECT * FROM police WHERE police_station = ?');
        $values = array($police_station);
        $query->execute($values);
        
        return $query;
    }
    
    function getPoliceStationsByCity($city_id) {
        $query = $this->db_conn->prepare('SELECT * FROM police_station WHERE city = ?');
        $values = array($city_id);
        $query->execute($values);
        
        return $query;
    }
    function getPoliceOfficer($police_id) {
        $query = $this->db_conn->prepare('SELECT * FROM police WHERE user_id = ?');
        $values = array($police_id);
        $query->execute($values);
        
        $obj = $query->fetch(PDO::FETCH_OBJ);
        return $obj;
    }
    function getDepartment($department) {
        $post = '';
        switch($department) {
            case 0 : $post = 'Operator';
                break;
            case 1 : $post = 'Law and Order';
                break;
            case 2 : $post = 'Women Protection';
                break;
            case 3 : $post = 'Cyber Crime';
                break;
            case 4 : $post = 'Traffic and Control';
                break;
            case 5 : $post = 'CBI';
                break;
        }
        return $post;
    }
    
    function updateDepartment($user_id,$department) {
        $query = $this->db_conn->prepare('UPDATE police SET designation = ? WHERE user_id = ?');
        $values = array($department,$user_id);
        $query->execute($values);
        return 1;
    }
    
    function getFIRs($flag,$user_id) {
        $query = $this->db_conn->prepare('SELECT * FROM police WHERE user_id = ?');
        $values = array($user_id);
        $query->execute($values);
        $obj = $query->fetch(PDO::FETCH_OBJ);
        
        $query2 = $this->db_conn->prepare('SELECT * FROM fir WHERE police_station = ? AND refer_dept = ? AND flag = ?');
        $values2 = array($obj->police_station,$obj->designation,$flag);
        $query2->execute($values2);
        
        
        return $query2;
    }
    
    function getFIRByComplaintID($complaint_id) {
        $query = $this->db_conn->prepare('SELECT * FROM fir WHERE complaint_id = ?');
        $values = array($complaint_id);
        $query->execute($values);
        
        $obj = $query->fetch(PDO::FETCH_OBJ);
        return $obj;
        
    }
    
    function close($type,$id) {
        if($type == 'complaint') {
            $query = $this->db_conn->prepare('UPDATE complaint SET status = ?, flag = 2 WHERE complaint_id = ?');
            $values = array('Complaint has been closed',$id);
            $query->execute($values);
        }
        if($type == 'fir') {
            $query = $this->db_conn->prepare('UPDATE fir SET status = ?, flag = 2 WHERE fir_id = ?');
            $values = array('FIR has been closed',$id);
            $query->execute($values);
        }
    }
    
    function getFIR($fir_id) {
        $query = $this->db_conn->prepare('SELECT * FROM fir WHERE fir_id = ?');
        $values = array($fir_id);
        $query->execute($values);
        
        $obj = $query->fetch(PDO::FETCH_OBJ);
        return $obj;
        
    }
    
    function openCase($fir_id,$notes,$user_id) {
        
        //echo 'fir_id = '. $fir_id . ', notes = '. $notes . ', user_id = ' . $user_id;
        $query2 = $this->db_conn->prepare('SELECT police_station FROM police WHERE user_id = ?');
        $values2 = array($user_id);
        $query2->execute($values2);
        $obj = $query2->fetch(PDO::FETCH_OBJ);
        
        $status = 'Case Opened. Forwarded to Magistrate';
        
        $dt = date('Y-n-j',  time());
        $query = $this->db_conn->prepare('INSERT INTO cases_law (case_id,fir_id,police_station,notes,status,flag,date) VALUES (NULL,?,?,?,?,0,?)');
        $values = array($fir_id,$obj->police_station,$notes,$status,$dt);
        //var_dump($values);
        $query->execute($values);
        $case_id = $this->db_conn->lastInsertId(); 
        
        $status2 = 'Case has been opened. Case id = <strong>' . $case_id . '</strong>';
        $query3 = $this->db_conn->prepare('UPDATE fir SET status = ?,flag = 1 WHERE fir_id = ?');
        $values3 = array($status2,$fir_id);
        $query3->execute($values3);
        
        return $case_id;
        
    }
    
    function getCases($flag,$user_id) {
        $query = $this->db_conn->prepare('SELECT * FROM magistrate WHERE user_id = ?');
        $values = array($user_id);
        $query->execute($values);
        $obj = $query->fetch(PDO::FETCH_OBJ);
        
        $query2 = $this->db_conn->prepare('SELECT * FROM cases_law WHERE police_station = ? AND flag = ?');
        $values2 = array($obj->police_station,$flag);
        $query2->execute($values2);
        
        
        return $query2;
    }
}

?>
