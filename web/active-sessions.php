<?php 
session_start(); 

$count = count(scandir(ini_get("session.save_path")));
echo $count;


?>