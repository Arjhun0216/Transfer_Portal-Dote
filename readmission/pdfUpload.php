<?php
session_start();

if(!isset($_SESSION['c_code']))
{
    //$_SESSION['redirect']=$_SERVER['REQUEST_URI'];
    header("Location:/transfer/user/log_in.php");
}
$filename = $_SESSION['c_code']."_".$_POST['reg_no'].".pdf";
  
/* Location */
$location = "all_previous_marksheet/".$filename;


$uploadOk = 1;
  
if($uploadOk == 0){
   echo 0;
}else{
   /* Upload file */
   if(move_uploaded_file($_FILES['file']['tmp_name'], $location)){
      echo $_SESSION['c_code']."_".$_POST['reg_no'];
   }else{
      echo 0;
   }
}

?>
