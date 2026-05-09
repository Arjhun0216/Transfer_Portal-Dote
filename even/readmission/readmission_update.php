<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("INVALID REQUEST");
}
include '../user/database.php';

$sql="INSERT INTO readmission_details (reg_no, c_code, name_of_college, name_of_student, dob, mobile, college_autonomous, autonomous_year, community, quota, year_of_admission, mode_of_admission, b_name, discontinued_sem, discontinued_year, readmission_sougth_sem, readmission_sougth_year, reason, lack_attendence_sem, total_periods, total_attended, percentage,freezed) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE reg_no=?, c_code=?, name_of_college=?, name_of_student=?, dob=?, mobile=?, college_autonomous=?, autonomous_year=?, community=?, quota=?, year_of_admission=?, mode_of_admission=?, b_name=?, discontinued_sem=?, discontinued_year=?, readmission_sougth_sem=?, readmission_sougth_year=?, reason=?, lack_attendence_sem=?, total_periods=?, total_attended=?, percentage=?,freezed=?";
if($stmt=$conn->prepare($sql))
{
    $stmt->bind_param("ssssssiisssssiiiisiiiiissssssiisssssiiiisiiiii",$_POST['reg_no'],$_SESSION['c_code'],$_SESSION['college_name'],$_POST['name_of_student'],$_POST['dob'],$_POST['mobile'],$_POST['college_autonomous'],$_POST['autonomous_year'],$_POST['community'],$_POST['quota'],$_POST['year_of_admission'],$_POST['mode_of_admission'],$_POST['b_name'],$_POST['discontinued_sem'],$_POST['discontinued_year'],$_POST['readmission_sougth_sem'],$_POST['readmission_sougth_year'],$_POST['reason'],$_POST['lack_attendence_sem'],$_POST['total_periods'],$_POST['total_attended'],$_POST['percentage'],$_POST['freezed'],$_POST['reg_no'],$_SESSION['c_code'],$_SESSION['college_name'],$_POST['name_of_student'],$_POST['dob'],$_POST['mobile'],$_POST['college_autonomous'],$_POST['autonomous_year'],$_POST['community'],$_POST['quota'],$_POST['year_of_admission'],$_POST['mode_of_admission'],$_POST['b_name'],$_POST['discontinued_sem'],$_POST['discontinued_year'],$_POST['readmission_sougth_sem'],$_POST['readmission_sougth_year'],$_POST['reason'],$_POST['lack_attendence_sem'],$_POST['total_periods'],$_POST['total_attended'],$_POST['percentage'],$_POST['freezed']);
    if($stmt->execute())
    {
        echo "success";
    }
    else
    {
        $conn->error;
    }
}
else
$conn->error;
?>