<?php
  header("Content-Type:text/html;charset=utf-8");
  require_once 'model.php';
  $sql = "select FID,FName,FSex,FAge,FComeTime,FPrison,FKind from prisoner";
  $res = mysqli_query($conn,$sql);  
  $arr = array();
    
  while($row = mysqli_fetch_assoc($res)){
      
      array_push($arr,$row);
  }
//   echo $row;
 echo json_encode($arr);

?>