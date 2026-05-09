<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("Invalid Request");
}
include 'user/database.php';
$sql="select  reg_no,name_of_student,b_name,readmission_sougth_sem from readmission_details where c_code='".$_SESSION['c_code']."'";
if($stmt=$conn->query($sql))
{
    
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
              <h2 style="text-align: center;">Readmission - 2025-2026</h2>
          </div>
          
       
          <div class="container" style="width:95%; height:500px; overflow: auto;">
          <a href="/transfer/readmission/readmission_request.php"><button class="btn btn-primary" disabled>Add New</button></a>

        
          <table class="table table-striped" style="margin-top:10px;">
            <thead class="thead-light">
              <tr>
                <th scope="col" style="width:5%">S.No</th>
                <th scope="col" style="width:10%">Endorsement No</th>
                <th scope="col" style="width:30%">Name</th>
                <th scope="col" style="width:40%">Dept</th>
                <th scope="col" style="width:5%">Requested Sem</th>
                
                <th scope="col" style="width:10%">Action</th>
              </tr>
            </thead>
          <tbody >
            <?php $count=1;?>
            <?php while($result=$stmt->fetch_assoc()): ?>
             <tr>
               <td><?php echo $count++; ?></td>
               <td><?php echo $result['reg_no']; ?></td>
               <td><?php echo $result['name_of_student']; ?></td>
               <td><?php echo $result['b_name']; ?></td>
               <td><?php echo $result['readmission_sougth_sem']; ?></td>
               <td><a href="/transfer/readmission/readmission_request.php?u_id=<?php echo $result['reg_no']; ?>"class='btn btn-success' style="color:green;">View</a></td>
             </tr>
             <?php endwhile ?>
        </tbody>
          </table>
    </div>
   
    
</body>
</html>