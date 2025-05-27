<?php
require_once("DBConnection.php");

class Provinces extends connection{
    public $con;
    public $provinceslist;
    public function __construct(){
      
        $this->con =$this->connection();

    }
//show information States
    public function Show_Provinces(){
        $sql ="select * from provinces";
        $result=$this->con->query($sql);
        $this->provinceslist=[];
        $i=0;
        while($row= $result->fetch_assoc()){
            $this->provinceslist[$i]=$row;
            $i++;
        }
    }

    public function Editprovinces($id){
        $sql="SELECT * from provinces where provinces.IDProvince ='$id'";
        $result=$this->con->query($sql);
        return $result->fetch_assoc();  

    }


    public function Updateprovinces($provinces,$id){

        $sql="UPDATE provinces set ProvinceName='$provinces' where IDProvince   ='$id' ";
        $result=$this->con->query($sql);
        $message = "نام استان تغییر کرد";
            header("Location: maneger.php?message=" . urlencode($message) . "&type=success");
            exit();
    }
       
}
