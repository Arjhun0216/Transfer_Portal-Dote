<?php
include '../user/database.php';
if(!isset($_POST['order_issue_date']))
{
   die("Something went wrong");
}
$sql="UPDATE batch SET order_status=1,order_date='".$_POST['order_issue_date']."' WHERE batch_no='".$_POST['batch_no']."'";
if($conn->query($sql))
{
    $sql1="UPDATE transfer_details set status='O' where batch_no='".$_POST['batch_no']."' and status='A'";
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
