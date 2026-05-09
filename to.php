<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("Invalid Request");
}
include 'user/database.php';
$sql="select  reg_no,name_of_student,b_name,sem_to,request_for from transfer_details where tcollege_c_code=".$_SESSION['c_code'];
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
              <h2 style="text-align: center;">Transfer TO College</h2>
          </div>
          <div class="container" style="width:95%; height:500px; overflow: auto;">
         
        <br>
          <table class="table table-striped" style="margin-top:10px;">
            <thead class="thead-light">
              <tr>
                <th scope="col" style="width:5%">S.No</th>
                <th scope="col" style="width:10%">Endorsement No</th>
                <th scope="col" style="width:30%">Name</th>
                <th scope="col" style="width:40%">Dept</th>
                <th scope="col" style="width:5%">Requested Sem</th>
                <th scope="col" style="width:10%">Category</th>
                <th scope="col" style="width:10%">Action</th>
              </tr>
            </thead>
            <?php $count=1;?>
            <?php while($result=$stmt->fetch_assoc()): ?>
             <tr>
               <td><?php echo $count++; ?></td>
               <td><?php echo $result['reg_no']; ?></td>
               <td><?php echo $result['name_of_student']; ?></td>
               <td><?php echo $result['b_name']; ?></td>
               <td><?php echo $result['sem_to']; ?></td>
               <td><?php echo $result['request_for']; ?></td>
               <td><a href="/transfer/request_transfer/vacancy_update.php?u_id=<?php echo $result['reg_no']; ?>"class='btn btn-success' style="color:green;">View</a></td>
               
             </tr>
             <?php endwhile ?>
        </tbody>
          </table>
    </div>
   
    
</body>
</html>