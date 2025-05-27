
<?php
session_start();
class connection{
    ///connect to database
    public function connection(){
        $connection=new mysqli("localhost","root","","user-register");
        $connection->query("set names UTF8");

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        return $connection;
    }
}