<?php
session_start();
if(!isset($_POST['u_id']))
{
    die("INVALID REQUEST");
}
include '../user/database.php';
$record=array();
$sql="select * from transfer_details where reg_no=".$_POST['u_id']." and fcollege_c_code=".$_SESSION['c_code'];
if($stmt=$conn->query($sql))
{
    if($stmt->num_rows<=0)
    die("no_record");
    array_push($record,$stmt->fetch_assoc());
    echo json_encode($record);
}
else
echo "SOMETHING WENT WRONG";
?>