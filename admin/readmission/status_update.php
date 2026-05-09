<?php
session_start();
if(!isset($_SESSION['admin_login']))
{
    die("INVALID REQUEST");
}
include '../../user/database.php';

$sql1="select name_of_college_with_address from college_details where c_code='".$_POST['college_name']."'";
if($stmt1=$conn->query($sql1))
{
    $row=$stmt1->fetch_assoc();
}
else
{
  die("Something went wrong");
}
$sql = "SELECT *  from readmission_details where reg_no='".$_POST['reg_no']."'limit 1";
$prev = mysqli_fetch_assoc(mysqli_query($conn, $sql));

$x=2;
$date=date("Y-m-d");
$sql="INSERT INTO readmission_details (reg_no, c_code, name_of_college, name_of_student, dob, mobile, college_autonomous, autonomous_year, community, quota, year_of_admission, mode_of_admission, b_name, discontinued_sem, discontinued_year, readmission_sougth_sem, readmission_sougth_year, reason, lack_attendence_sem, total_periods, total_attended, percentage,freezed,approved,admin_reason) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE reg_no=?, c_code=?, name_of_college=?, name_of_student=?, dob=?, mobile=?, college_autonomous=?, autonomous_year=?, community=?, quota=?, year_of_admission=?, mode_of_admission=?, b_name=?, discontinued_sem=?, discontinued_year=?, readmission_sougth_sem=?, readmission_sougth_year=?, reason=?, lack_attendence_sem=?, total_periods=?, total_attended=?, percentage=?,freezed=?,approved=?,admin_reason=?";
if($stmt=$conn->prepare($sql))
{
    $stmt->bind_param("ssssssiisssssiiiisiiiiiisssssssiisssssiiiisiiiiiis",$_POST['reg_no'],$_POST['college_name'],$row['name_of_college_with_address'],$_POST['name_of_student'],$_POST['dob'],$_POST['mobile'],$_POST['college_autonomous'],$_POST['autonomous_year'],$_POST['community'],$_POST['quota'],$_POST['year_of_admission'],$_POST['mode_of_admission'],$_POST['b_name'],$_POST['discontinued_sem'],$_POST['discontinued_year'],$_POST['readmission_sougth_sem'],$_POST['readmission_sougth_year'],$_POST['reason'],$_POST['lack_attendence_sem'],$_POST['total_periods'],$_POST['total_attended'],$_POST['percentage'],$x,$_POST['approved'],$_POST['admin_reason'],$_POST['reg_no'],$_POST['college_name'],$row['name_of_college_with_address'],$_POST['name_of_student'],$_POST['dob'],$_POST['mobile'],$_POST['college_autonomous'],$_POST['autonomous_year'],$_POST['community'],$_POST['quota'],$_POST['year_of_admission'],$_POST['mode_of_admission'],$_POST['b_name'],$_POST['discontinued_sem'],$_POST['discontinued_year'],$_POST['readmission_sougth_sem'],$_POST['readmission_sougth_year'],$_POST['reason'],$_POST['lack_attendence_sem'],$_POST['total_periods'],$_POST['total_attended'],$_POST['percentage'],$x,$_POST['approved'],$_POST['admin_reason']);
    if($stmt->execute())
    {
        //echo "success";
        $sql = "SELECT *  from readmission_details where reg_no='".$_POST['reg_no']."'limit 1";
        $updated = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $UpdatedColumns=array_diff_assoc($updated,$prev);
        if (array_key_exists('approved', $UpdatedColumns)) 
        {
            $sql="update readmission_details set approved_date='".$date."' where reg_no='".$_POST['reg_no']."'";
            if($stmt=$conn->query($sql))
            {
            echo "success";
            }
        }
        else{
        echo "Successfully updated";
        }
    }
    else
    {
        $conn->error;
    }
}
else
$conn->error;
?>