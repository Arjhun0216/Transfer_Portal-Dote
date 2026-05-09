<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("Invalid Request");
}
include 'user/database.php';
$sql="select  reg_no,name_of_student,b_name,tcollege,request_for from transfer_details where fcollege_c_code=".$_SESSION['c_code'];
if($stmt=$conn->query($sql))
{
    //if($stmt->num_rows<=0)
    //die("INVALID");
    //$result=$stmt->fetch_assoc();
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
              <h2 style="text-align: center;">Transfer / Readmission Cum Transfer - 2025-2026</h2>
          </div>
          <div class="container" style="width:95%; height:550px; overflow: auto;" >
            <a  href="../request_transfer/add_new_transfer.php"  ><button class="btn btn-primary " disabled>Add New</button></a>
            <br>
            <table class="table table-striped" style="margin-top:10px;">
              <thead class="thead-light" >
                <tr>
                  <th scope="col" style="width:5%">S.No</th>
                  <th scope="col" style="width:10%">Reg.No</th>
                  <th scope="col" style="width:30%">Name</th>
                  <th scope="col" style="width:5%">Dept</th>
                  <th scope="col" style="width:40%">To College</th>
                  <th scope="col" style="width:10%">Category</th>
                  <th scope="col" style="width:10%">Action</th>
                </tr>
              </thead>
              <tbody >
                <?php $count=1;?>
                <?php while($result=$stmt->fetch_assoc()): ?>
                  <tr>
                    <td width="5%"><?php echo $count++; ?></td>
                    <td width="10%"><?php echo $result['reg_no']; ?></td>
                    <td width="30%"><?php echo $result['name_of_student']; ?></td>
                    <td width="5%"><?php echo $result['b_name']; ?></td>
                    <td width="40%"><?php echo $result['tcollege']; ?></td>
                    <td width="10%"><?php echo $result['request_for']; ?></td>
                    <td width="10%"><a href="../request_transfer/add_new_transfer.php?u_id=<?php echo $result['reg_no']; ?>"class='btn btn-success' style="color:green;">View</a></td>
                  </tr>
                <?php endwhile ?>
              </tbody>
            </table>
          </div>
    </body>
</html>