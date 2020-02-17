<?php
session_start();
$name = $_SESSION['name'];
$i = 10;
echo "username: ".$_SESSION['name']; 
// if($name){
//     while($i){
//         echo $i.$name."\n";
//         $i--;
//     }
// }
$num = rand(0,100);
$rid = $nam+$num;
echo $rid;
    
?>