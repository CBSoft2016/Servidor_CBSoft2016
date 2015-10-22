<?php
require_once 'config.php'; // Database setting constants [DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD]
class dbHelper {
    private $db;
    private $err;
    function __construct() {
        $dsn = 'mysql:host=localhost;dbname=taqui;charset=utf8';
        
        try {
            $this->db = new PDO($dsn, "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $e) {
            $response["status"] = "error";
            $response["message"] = 'Connection failed: ' . $e->getMessage();
            $response["data"] = null;
            //echoResponse(200, $response);
            exit;
        }
        
    }
//      function __construct() {
//        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8';
//        
//        try {
//            $this->db = new PDO($dsn, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//        } catch (PDOException $e) {
//            $response["status"] = "error";
//            $response["message"] = 'Connection failed: ' . $e->getMessage();
//            $response["data"] = null;
//            //echoResponse(200, $response);
//            exit;
//        }
//        
//    }
    function select($table, $columns, $where=null,$anuncio=null){
        try{
            $a = array();
            $w = "";
            if($where){
              $stmt = $this->db->prepare("select ".$columns." from ".$table." where 1=1 and ".$where);

            }
            if($anuncio){
                $stmt = $this->db->prepare("select ".$columns." from ".$table);
            }
           
            else{
                 $stmt = $this->db->prepare("select ".$columns." from ".$table." ORDER BY posicao ");
                 
           }
            $stmt->execute($a);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows)<=0){
                $response["status"] = "warning";
                $response["message"] = "No data found.";
            }else{
                $response["status"] = "success";
                $response["message"] = "Data selected from database";
            }
                $response["data"] = $rows;
        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = 'Select Failed: ' .$e->getMessage();
            $response["data"] = null;
        }
        return $response;
    }
    function selectFarmacia(){
        $a = array();
        try{
            $sql="select f.id,f.nome,f.endereco,f.telefone1,f.telefone2,f.status,f.palavrasChave,f.posicao,f.foto,f.aviso,f.textoplantao,f.latitude,f.longitude
                   FROM farmacia f";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($a);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($rows)<=0){
                $response["status"] = "warning";
                $response["message"] = "No data found.";
            }else{
                $response["status"] = "success";
                $response["message"] = "Data selected from database";
            }
                $response["data"] = $rows;
        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = 'Select Failed: ' .$e->getMessage();
            $response["data"] = null;
        }
        return $response;
    }
     function selectFarmaciaWEBservice(){
         $a = array();
        try{
            $sql="select f.id,f.nome,f.endereco,f.telefone1,f.telefone2,f.status,f.palavrasChave,f.posicao,f.foto,f.aviso,f.textoplantao
                   FROM farmacia f  ORDER BY posicao";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($a);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($rows)<=0){
                $response["status"] = "warning";
                $response["message"] = "No data found.";
            }else{
                $response["status"] = "success";
                $response["message"] = "Data selected from database";
            }
                $response["data"] = $rows;
        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = 'Select Failed: ' .$e->getMessage();
            $response["data"] = null;
        }
        return $response;
    }
    
    
    function insert($table, $array) {
        try{
            $a = array();
            $c = "";
            $v = "";
            
            foreach ($array as $key => $value) {
                $c .= $key. ", ";
                $v .= ":".$key. ", ";
                $a[":".$key] = $value;
               
                
            }
            
            $c = rtrim($c,', ');
            $v = rtrim($v,', ');
            $stmt =  $this->db->prepare("INSERT INTO $table($c) VALUES($v)");  $c = rtrim($c,', ');
            $v = rtrim($v,', ');
            $stmt->execute($a);
            $affected_rows = $stmt->rowCount();
            $lastInsertId = $this->db->lastInsertId();
            $response["status"] = "success";
            $response["message"] = $affected_rows." row inserted into database";
            $response["data"] = $lastInsertId;
        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = 'Insert Failed: ' .$e->getMessage();
            $response["data"] = 0;
        }
        return $response;
    }
    
    function update($table, $columnsArray, $where){ 
        try{
            $a = array();
            $w = "";
            $c = "";
            foreach ($where as $key => $value) {
                $w .= " and " .$key. " = :".$key;
                $a[":".$key] = $value;
            }
            foreach ($columnsArray as $key => $value) {
                $c .= $key. " = :".$key.", ";
                $a[":".$key] = $value;
            }
                $c = rtrim($c,", ");

            $stmt =  $this->db->prepare("UPDATE $table SET $c WHERE 1=1 ".$w);
            $stmt->execute($a);
            $affected_rows = $stmt->rowCount();
            if($affected_rows<=0){
                
                $response["status"] = "warning";
                $response["message"] = "No row updated";
            }else{
                $response["status"] = "success";
                $response["message"] = $affected_rows." row(s) updated in database";
            }
        }catch(PDOException $e){
            $response["status"] = "error";
            $response["message"] = "Update Failed: " .$e->getMessage();
        }
        return $response;
    }
    function delete($table, $where){
        if(count($where)<=0){
            $response["status"] = "warning";
            $response["message"] = "Delete Failed: At least one condition is required";
        }else{
            try{
                $a = array();
                $w = "";
                foreach ($where as $key => $value) {
                    $w .= " and " .$key. " = :".$key;
                    $a[":".$key] = $value;
                }
                $stmt =  $this->db->prepare("DELETE FROM $table WHERE 1=1 ".$w);
                $stmt->execute($a);
                $affected_rows = $stmt->rowCount();
                if($affected_rows<=0){
                    $response["status"] = "warning";
                    $response["message"] = "No row deleted";
                }else{
                    $response["status"] = "success";
                    $response["message"] = $affected_rows." row(s) deleted from database";
                }
            }catch(PDOException $e){
                $response["status"] = "error";
                $response["message"] = 'Delete Failed: ' .$e->getMessage();
            }
        }
        return $response;
    }
    /*function selectP($name){
        // Select statement
        try{
            // $a = array();
            // $w = "";
            // // $where = array('name' => 'Ipsita Sahoo', 'uid'=>'170' );
            // foreach ($where as $key => $value) {
            //     $w .= " and " .$key. " like :".$key;
            //     $a[":".$key] = $value;
            // }
            // $stmt = $this->db->prepare("CALL `simpleproc`(@a);SELECT @a AS `param1`;");
            // $stmt->execute($a);
            // return $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = $this->db->prepare("CALL $name(@resultId)"); 
            $stmt->execute(); 
            $stmt = $this->db->prepare("select @resultId as Id"); 
            $stmt->execute(); 
            $myResultId = $stmt->fetchColumn();

            print "procedure returned \n".$myResultId;
            
        }catch(PDOException $e){
            print_r('Query Failed: ' .$e->getMessage());
            return $rows=null;
            exit;
        }
    }*/
    function verifyRequiredParams($inArray, $requiredColumns) {
        $error = false;
        $errorColumns = "";
        foreach ($requiredColumns as $field) {
        // strlen($inArray->$field);
            if (!isset($inArray->$field) || strlen(trim($inArray->$field)) <= 0) {
                $error = true;
                $errorColumns .= $field . ', ';
            }
        }

        if ($error) {
            $response = array();
            $response["status"] = "error";
            $response["message"] = 'Required field(s) ' . rtrim($errorColumns, ', ') . ' is missing or empty';
            echoResponse(200, $response);
            exit;
        }
    }
  function getSession(){
    if (!isset($_SESSION)) {
        session_start();
    }
    $sess = array();
    if(isset($_SESSION['logado'])){
        $sess["logado"] = "success";
 
    }
    else
    {
         $sess["logado"] = "false";
    }
    return $sess;
}
public function destroySession(){
    if (!isset($_SESSION)) {
    session_start();
    }
    if(isSet($_SESSION['uid']))
    {
        unset($_SESSION['uid']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        $info='info';
        if(isSet($_COOKIE[$info]))
        {
            setcookie ($info, '', time() - $cookie_time);
        }
        $msg="Logged Out Successfully...";
    }
    else
    {
        $msg = "Not logged in...";
    }
    return $msg;
}
}

?>
