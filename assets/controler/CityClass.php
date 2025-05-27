<?php
require_once("DBConnection.php");

class City extends connection{
    public $con;
    public $Citylist;
    public function __construct(){
      
        $this->con =$this->connection();

    }
//show information States
    public function Show_City($id){
        $sql ="select * from cities where province_id ='$id'";
        $result=$this->con->query($sql);
        $this->Citylist=[];
        $i=0;
        while($row= $result->fetch_assoc()){
            $this->Citylist[$i]=$row;
            $i++;
        }
    }

//show name eprovince in city
    public function Nameprovince($id){
        $sql="SELECT provinces.ProvinceName from provinces where provinces.IDProvince ='$id'";
        $result=$this->con->query($sql);
        return $result->fetch_assoc();  
    }


    public function EditCity($id){
        $sql="SELECT * from cities where cities.IDCity  ='$id'";
        $result=$this->con->query($sql);
        return $result->fetch_assoc();  

    }


    public function UpdateCity($provinces,$id){

        $sql="UPDATE cities set CityName='$provinces' where IDCity ='$id' ";
        $result=$this->con->query($sql);
        $message = "نام شهرستان تغییر کرد";
            header("Location: state.php?message=" . urlencode($message) . "&type=success");
            exit();
    }

    //delete
    public function Delete($id){
        $sql="DELETE from cities where IDCity=$id";
        $this->con->query($sql);
        $message = " شهرستان مورد نظر حذف شد";
        header("Location: state.php?message=" . urlencode($message) . "&type=error");
        exit();
    }

    //create
    public function Create($id,$CityName){

        $sql = "INSERT INTO cities (province_id , CityName)
            VALUES ('$id', '$CityName')";

        $this->con->query($sql);
        $message = " شهرستان مورد نظر اضافه شد";
        header("Location: state.php?message=" . urlencode($message) . "&type=success");
        exit();
    }
       
}
