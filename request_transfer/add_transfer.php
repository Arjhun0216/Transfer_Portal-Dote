<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("INVALID REQUEST");
}
include '../user/database.php';
if(!isset($_POST['add_transfer']))
{
    die("Invalid Request");
}
//echo $_POST['b_name'];
$sql="INSERT INTO  transfer_details(reg_no, name_of_student, mobile, dob, admission_type, admission_year, admission_month, request_for, fcollege_c_code, fcollege, fcollege_autonomous, arrears, no_arrears, b_name, sem_from, tcollege_c_code, tcollege, tcollege_autonomous, sem_to, last_appeared_month, last_appeared_year, last_appeared_semester, last_appeared_reg_no, reason, total_periods, attended_periods, attendence_percentage, community, quota, board, mark1, mark2, mark3, cut_off,tcr_last_appeared_semester,freezed) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE reg_no=?, name_of_student=?, mobile=?, dob=?, admission_type=?, admission_year=?, admission_month=?, request_for=?, fcollege_c_code=?, fcollege=?, fcollege_autonomous=?,arrears=?,no_arrears=?, b_name=?, sem_from=?, tcollege_c_code=?, tcollege=?, tcollege_autonomous=?, sem_to=?, last_appeared_month=?, last_appeared_year=?, last_appeared_semester=?, last_appeared_reg_no=?, reason=?, total_periods=?, attended_periods=?, attendence_percentage=?, community=?, quota=?, board=?, mark1=?, mark2=?, mark3=?, cut_off=?,tcr_last_appeared_semester=?,freezed=?";
if($stmt=$conn->prepare($sql))
{
    $stmt->bind_param("ssssssssssiiisissiississiissssiiiiiissssssssssiiisissiississiissssiiiiii",$_POST['reg_no'], $_POST['name_of_student'], $_POST['mobile'], $_POST['dob'], $_POST['admission_type'], $_POST['admission_year'],$_POST['admission_month'], $_POST['request_for'], $_SESSION['c_code'], $_POST['fcollege'], $_POST['fcollege_autonomous'], $_POST['arrears'], $_POST['no_arrears'], $_POST['b_name'], $_POST['sem_from'], $_POST['tcollege_c_code'], $_POST['tcollege'], $_POST['tcollege_autonomous'],$_POST['sem_to'], $_POST['last_appeared_month'], $_POST['last_appeared_year'], $_POST['last_appeared_semester'],$_POST['last_appeared_reg_no'],$_POST['reason'],$_POST['total_periods'], $_POST['attended_periods'], $_POST['attendence_percentage'], $_POST['community'], $_POST['quota'], $_POST['board'], $_POST['mark1'],$_POST['mark2'], $_POST['mark3'], $_POST['cut_off'],$_POST['tcr_last_appeared_semester'],$_POST['freezed'],$_POST['reg_no'],$_POST['name_of_student'], $_POST['mobile'], $_POST['dob'], $_POST['admission_type'], $_POST['admission_year'],$_POST['admission_month'], $_POST['request_for'], $_SESSION['c_code'], $_POST['fcollege'], $_POST['fcollege_autonomous'],$_POST['arrears'],$_POST['no_arrears'],$_POST['b_name'], $_POST['sem_from'], $_POST['tcollege_c_code'], $_POST['tcollege'], $_POST['tcollege_autonomous'],$_POST['sem_to'], $_POST['last_appeared_month'], $_POST['last_appeared_year'], $_POST['last_appeared_semester'],$_POST['last_appeared_reg_no'],$_POST['reason'],$_POST['total_periods'], $_POST['attended_periods'], $_POST['attendence_percentage'], $_POST['community'], $_POST['quota'], $_POST['board'], $_POST['mark1'],$_POST['mark2'], $_POST['mark3'], $_POST['cut_off'],$_POST['tcr_last_appeared_semester'],$_POST['freezed']);
    if($stmt->execute())
    {
        echo "success";
    }
    else
    {
        echo $conn->error;
    }
}
else
{
    echo $conn->error;
}
?>
