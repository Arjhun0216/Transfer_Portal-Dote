<?php
include '../user/database.php';
if(!isset($_POST['re_order_issue_date']))
{
   die("Something went wrong");
}
$sql="UPDATE re_batch SET order_status=1,order_date='".$_POST['re_order_issue_date']."' WHERE batch_no='".$_POST['re_batch_no']."'";
if($conn->query($sql))
{
    $sql1="UPDATE readmission_details set approved=4 where batch_no='".$_POST['re_batch_no']."' and approved=1";
    if($conn->query($sql1))
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
