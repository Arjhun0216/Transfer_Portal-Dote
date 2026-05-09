<?php
session_start();

if(!isset($_SESSION['c_code']))
{
    //$_SESSION['redirect']=$_SERVER['REQUEST_URI'];
    header("Location:/transfer/admin/log_in.php");
}
$filename = $_POST['c_code']."_".$_POST['reg_no'].".pdf";
  
/* Location */
$location = "../../request_transfer/last_semester_marksheet/".$filename;


$uploadOk = 1;
  
if($uploadOk == 0){
   echo 0;
}else{
   /* Upload file */
   if(move_uploaded_file($_FILES['file']['tmp_name'], $location)){
      echo $_POST['c_code']."_".$_POST['reg_no'];
   }else{
      echo 0;
   }
}

?>
