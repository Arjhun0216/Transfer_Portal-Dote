<?php
session_start();


if(!isset($_SESSION['c_code']))
{
   // $_SESSION['redirect']=$_SERVER['REQUEST_URI'];
    header("Location:/user/log_in.php");
}
include '../user/database.php';
$sql="update student_info set save=0 where a_no=? and c_code=? and b_code=?";
if($stmt=$conn->prepare($sql))
{
    $stmt->bind_param("sss",$_POST['a_no'],$_SESSION['c_code'],$_POST['b_code']);
    if($stmt->execute())
    {
        echo "success";
    }
    else
    {
        echo $conn->error;
    }
}
else
{
    echo $conn->error;
}
$conn->close();
?>
