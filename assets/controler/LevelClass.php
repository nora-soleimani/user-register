<?php
require_once ("DBConnection.php");
require_once ("assets/controler/LoginClass.php");
require_once ("assets/controler/LogClass.php");

class Level extends connection{
    public $con;
    public $listlevel;
    public function __construct(){
      
        $this->con =$this->connection();
    }

    //show information Level
    public function showlevel(){
        $sql="SELECT * FROM level";
        $result=$this->con->query($sql);
        $this->listlevel=[];
        $i=0;
        while($row= $result->fetch_assoc()){
            $this->listlevel[$i]=$row;
            $i++;
            
        }
    }

    public function EditLevelAdmin($id){
        $sql="SELECT users.IDLevel ,level.NameLevel from users
         INNER JOIN level on level.IdLevel=users.IDLevel where users.id='$id'";
        $result=$this->con->query($sql);
        return $result->fetch_assoc();  

    }


    public function UpdateLevelAdmin($idlevel,$id){
        $log=new Log();
        $sql="UPDATE users set IDLevel='$idlevel' where id  ='$id' ";
        $result=$this->con->query($sql);
        $log->logChange($id,$_SESSION["ID_User"],"ویرایش سطح دسترسی ادمین");
        $message = "سطح دسترسی تغییر کرد";
            header("Location: maneger.php?message=" . urlencode($message) . "&type=success");
            exit();
        
    }
}
