<?php 
include("conn/connection.php");

if(isset($_POST['added'])){
    $z_name = $_POST['title'];
    $z_bn_name = $_POST['description'];
    $query = "INSERT INTO zone1(z_name,z_bn_name) VALUES ('$z_name','$z_bn_name')";
    if (mysql_query($query)){
        echo json_encode(array("status" => 1));
    }
    else{
        echo json_encode(array("status"=>2));
    }
}
?>
