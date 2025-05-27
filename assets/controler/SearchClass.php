<?php
require_once("DBConnection.php");

class Search extends connection{
    public $con;
    public $listsearch;
    public function __construct(){
      
        $this->con =$this->connection();

    }
     
    public function search($data){
        foreach($data as $key=>$value){
            ${$key}=$value;
        }
        $sql ="SELECT users.id , users.gender ,users.national_code,users.first_name ,users.last_name ,users.phone_number,users.birth_date,users.email,provinces.ProvinceName,cities.CityName ,users.province_id,users.city_id
        FROM `users` INNER JOIN provinces ON users.province_id=provinces.IDProvince 
        INNER JOIN cities on users.city_id=cities.IDCity
        WHERE ";
        if ($firstName=="" && $lastName=="" && $province=="" && $city==""  ){
            
            $message = " لطفا مقداری را در فرم وارد کنید  ";
            header("Location: search.php?message=" . urlencode($message) . "&type=error");
            exit();
        }
        else
        {
            $coundition="";
            if($firstName!=""){
                $coundition=" users.first_name LIKE '%$firstName%'";
              
            }
            if($lastName!=""){

                if($coundition!=""){
                    $coundition.=" or ";
                }
                $coundition.=" users.last_name = '%$lastName%'";

            }
            if($province!=""){
                if($coundition!=""){
                    $coundition.=" or ";
                }
                $coundition.=" users.province_id = '$province'";
            }

            if($city!=""){
                if($coundition!=""){
                    $coundition.=" or ";
                }
                $coundition.=" users.city_id = '$city'";
            }
            
        }
        $sql.=$coundition;
       
        $result=$this->con->query($sql);
        $this->listsearch=[];
        $i=0;
        while($row= $result->fetch_assoc()){
            $this->listsearch[$i]=$row;
            $i++;
        
        }
    }
}
    ?>