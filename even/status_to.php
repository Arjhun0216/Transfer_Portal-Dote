<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("Invalid Request");
}
include 'user/database.php';


$sql="select  reg_no,name_of_student,b_name,fcollege_c_code,status,status_reason from transfer_details where tcollege_c_code=".$_SESSION['c_code'];
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
<title>Branch Details</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Department</title>
    </head>
<body>
          <div >
              <h2 style="text-align: center;">Status</h2>
          </div>
          <div class="container" style="width:95%; height:500px; overflow: auto;">
         
       
          <table class="table table-striped" style="margin-top:10px;">
            <thead class="thead-light" >
              <tr>
                <th scope="col" style="width:5%">S.No</th>
                <th scope="col" style="width:10%">Endorsement No</th>
                <th scope="col" style="width:20%">Name</th>
                <th scope="col" style="width:30%">Dept</th>
                <th scope="col" style="width:5%">From College</th>
                <th scope="col" style="width:10%">Status</th>
                <th scope="col" style="width:30%">Remarks</th>
              </tr>
            </thead>
          <tbody >
            <?php $count=1;?>
            <?php while($result=$stmt->fetch_assoc()): ?>
             <tr scope="row">
               <td width="5%"><?php echo $count++; ?></td>
               <td width="10%"><?php echo $result['reg_no']; ?></td>
               <td width="20%"><?php echo $result['name_of_student']; ?></td>
               <td width="30%"><?php echo $result['b_name']; ?></td>
               <td width="5%"><?php echo $result['fcollege_c_code']; ?></td>
               <td width="10%"><?php if($result['status']=='A') echo "Approved"; else if($result['status']=='R') echo "Not Approved";else if($result['status']=='P') echo "Pending";else echo ""; ?></td>
               <td width="30%"><?php echo $result['status_reason']; ?></td>
               
             </tr>
             <?php endwhile ?>
        </tbody>
          </table>
    </div>
   
    
</body>
</html>