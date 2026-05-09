<?php
include '../user/database.php';
if(!isset($_POST['batch_no']))
{
   die("Something went wrong");
}

// $sql="select reg_no from transfer_details where status='A'";
// if($stmt=$conn->query($sql))
// {
//     if($dateap=$conn->query("select batch from date_order"))
//     {
//         if($dateap->fetch_assoc()['order_status']=='0')
//         die("Waiting For Update");
//     }
// }
$date=date("Y-m-d");
$sql="INSERT INTO batch(batch_no,order_status,order_date,from_date,to_date) VALUES ('".$_POST['batch_no']."',0,'".$date."','".$_POST['from_date']."','".$_POST['to_date']."') ON DUPLICATE KEY UPDATE batch_no='".$_POST['batch_no']."',order_status=0,order_date='".$date."',from_date='".$_POST['from_date']."',to_date='".$_POST['to_date']."'";
if($conn->query($sql))
{
      echo "success";
}
else
{
    echo $conn->error;
}

?>