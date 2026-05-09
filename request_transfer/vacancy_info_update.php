<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("INVALID REQUEST");
}
include '../user/database.php';
$sql="update transfer_details set tcollege_sanctioned_intake=?,tcollege_total_students=?,tcollege_total_after=?,freezed_to=? where reg_no=? and tcollege_c_code=?";
if($stmt=$conn->prepare($sql))
{
    $stmt->bind_param('iiiiss',$_POST['tcollege_sanctioned_intake'],$_POST['tcollege_total_students'],$_POST['tcollege_total_after'],$_POST['freezed_to'],$_POST['reg_no'],$_SESSION['c_code']);
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
echo $conn->error;
?>