<?php
require_once ("DBConnection.php");


class Log extends connection{
    public $con;
    public $listlog;
    public function __construct(){
      
        $this->con =$this->connection();
    }

    public function show_Log(){
        $sql ="SELECT admin.Iduser as idadmin, admin.Username as nameadmin ,users.id as iduser ,users.username ,log.Action ,log.CreatedAt
            FROM users INNER JOIN  log on users.id=log.IDUser
            INNER JOIN admin on admin.Iduser=log.IDAdmin";
        $result=$this->con->query($sql);
        $this->listlog=[];
        $i=0;
        while($row= $result->fetch_assoc()){
            $this->listlog[$i]=$row;
            $i++;
            
        }

    }

    public function logChange($iduser,$idadmin,$action){
        $sql = "INSERT INTO log (IDUser, IDAdmin, Action)
        VALUES ('$iduser', '$idadmin', '$action')";
         $result=$this->con->query($sql);
   
    }

}


