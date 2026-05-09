<?php
session_start();

// if(!isset($_SESSION['admin_login']))
// {
//     die("INVALID REQUEST");
// }
include '../../user/database.php';

$date=date("Y-m-d");

if(!isset($_POST['add_transfer']))
{
    die("Invalid Request");
}
$sql="INSERT INTO  transfer_details(reg_no, name_of_student, address, address2, district, pincode, mobile, email, admission_type, admission_year, admission_month, request_for, fcollege_c_code, fcollege, fcollege_autonomous, b_name, sem_from, tcollege_c_code, tcollege, tcollege_autonomous, sem_to, last_appeared_month, last_appeared_year, last_appeared_semester, last_appeared_reg_no, reason, total_periods, attended_periods, attendence_percentage, tnea_reg_no, community, quota, fg, pms, board, mark1, mark2, mark3, cut_off,tcr_last_appeared_semester,freezed,freezed_to,tcollege_sanctioned_intake,tcollege_total_students,	tcollege_total_after) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
if($stmt=$conn->prepare($sql))
{
    $stmt->bind_param("ssssssssssssssisissiississiiisssiisiiiiiiiiii",$_POST['reg_no'], $_POST['name_of_student'], $_POST['address'],$_POST['address2'],$_POST['district'], $_POST['pincode'], $_POST['mobile'], $_POST['email'], $_POST['admission_type'], $_POST['admission_year'],$_POST['admission_month'], $_POST['request_for'], $_POST['fcollege_c_code'], $_POST['fcollege'], $_POST['fcollege_autonomous'],$_POST['b_name'], $_POST['sem_from'], $_POST['tcollege_c_code'], $_POST['tcollege'], $_POST['tcollege_autonomous'],$_POST['sem_to'], $_POST['last_appeared_month'], $_POST['last_appeared_year'], $_POST['last_appeared_semester'],$_POST['last_appeared_reg_no'],$_POST['reason'],$_POST['total_periods'], $_POST['attended_periods'], $_POST['attendence_percentage'],$_POST['tnea_reg_no'], $_POST['community'], $_POST['quota'], $_POST['fg'], $_POST['pms'], $_POST['board'], $_POST['mark1'],$_POST['mark2'], $_POST['mark3'], $_POST['cut_off'],$_POST['tcr_last_appeared_semester'],$_POST['freezed'],$_POST['freezed_to'],$_POST['tcollege_sanctioned_intake'],$_POST['tcollege_total_students'],	$_POST['tcollege_total_after']);
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
