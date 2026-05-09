<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("INVALID REQUEST");
}
// select  reg_no,name_of_student,b_name,tcollege,request_for from transfer_details where batch_no in (select batch_no from batch where order_status=1) and fcollege_c_code="2603"
include 'user/database.php';
$sql="select  reg_no,name_of_student,b_name,tcollege,request_for from transfer_details where fcollege_c_code=".$_SESSION['c_code']." and status='O'";
if($stmt=$conn->query($sql))
{
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Department</title>
    </head>
<body>
          <div >
              <h2 style="text-align: center;">Approved Order</h2>
          </div>
          <div class="container" style="width:95%; height:500px; overflow: auto;" >

        <br>
          <table class="table table-striped" style="margin-top:10px;">
            <thead class="thead-light" >
              <tr>
                <th scope="col" style="width:5%">S.No</th>
                <th scope="col" style="width:10%">Reg.No</th>
                <th scope="col" style="width:30%">Name</th>
                <th scope="col" style="width:5%">Dept</th>
                <th scope="col" style="width:35%">To College</th>
                <th scope="col" style="width:10%">Category</th>
                <th scope="col" style="width:15%">Action</th>
              </tr>
            </thead>
          <tbody >
            <?php $count=1;?>
            <?php while($result=$stmt->fetch_assoc()): ?>
             <tr scope="row">
               <td  width="5%"><?php echo $count++; ?></td>
               <td width="10%"><?php echo $result['reg_no']; ?></td>
               <td width="30%"><?php echo $result['name_of_student']; ?></td>
               <td width="5%"><?php echo $result['b_name']; ?></td>
               <td width="35%"><?php echo $result['tcollege']; ?></td>
               <td width="10%"><?php echo $result['request_for']; ?></td>
               <td width="15%"><a href="../report_generation/order.php?u_id=<?php echo $result['reg_no']; ?>"class='btn btn-success' style="color:white;">Transfer Order</a></td>
               
             </tr>
             <?php endwhile ?>
        </tbody>
          </table>
    </div>
   
    
</body>
</html>