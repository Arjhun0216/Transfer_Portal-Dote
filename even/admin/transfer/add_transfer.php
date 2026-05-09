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
$sql = "SELECT *  from transfer_details where reg_no='".$_POST['old_reg_no']."'limit 1";
$prev = mysqli_fetch_assoc(mysqli_query($conn, $sql));


$sql="UPDATE transfer_details set reg_no=?, name_of_student=?, address=?, address2=?, district=?, pincode=?, mobile=?, email=?, admission_type=?, admission_year=?, admission_month=?, request_for=?, fcollege_c_code=?, fcollege=?, fcollege_autonomous=?, b_name=?, sem_from=?, tcollege_c_code=?, tcollege=?, tcollege_autonomous=?, sem_to=?, last_appeared_month=?, last_appeared_year=?, last_appeared_semester=?, last_appeared_reg_no=?, reason=?, total_periods=?, attended_periods=?, attendence_percentage=?, tnea_reg_no=?, community=?, quota=?, fg=?, pms=?, board=?, mark1=?, mark2=?, mark3=?, cut_off=?,tcr_last_appeared_semester=?,freezed=?,tcollege_sanctioned_intake=?,tcollege_total_students=?,tcollege_total_after=?,status=?,status_reason=?,sanctioned_intake=?,admitted=?,vacancy=? where reg_no=?";
if($stmt=$conn->prepare($sql))
{
    $stmt->bind_param("ssssssssssssssisissiississiiisssiisiiiiiiiiissiiis",$_POST['reg_no'],$_POST['name_of_student'], $_POST['address'],$_POST['address2'],$_POST['district'], $_POST['pincode'], $_POST['mobile'], $_POST['email'], $_POST['admission_type'], $_POST['admission_year'],$_POST['admission_month'], $_POST['request_for'], $_POST['fcollege_c_code'], $_POST['fcollege'], $_POST['fcollege_autonomous'],$_POST['b_name'], $_POST['sem_from'], $_POST['tcollege_c_code'], $_POST['tcollege'], $_POST['tcollege_autonomous'],$_POST['sem_to'], $_POST['last_appeared_month'], $_POST['last_appeared_year'], $_POST['last_appeared_semester'],$_POST['last_appeared_reg_no'],$_POST['reason'],$_POST['total_periods'], $_POST['attended_periods'], $_POST['attendence_percentage'],$_POST['tnea_reg_no'], $_POST['community'], $_POST['quota'], $_POST['fg'], $_POST['pms'], $_POST['board'], $_POST['mark1'],$_POST['mark2'], $_POST['mark3'], $_POST['cut_off'],$_POST['tcr_last_appeared_semester'],$_POST['freezed'],$_POST['tcollege_sanctioned_intake'],$_POST['tcollege_total_students'],	$_POST['tcollege_total_after'],$_POST['status'],$_POST['status_reason'],$_POST['sanctioned_intake'],$_POST['admitted'],$_POST['vacancy'],$_POST['old_reg_no']);
    if($stmt->execute())
    {
        $sql = "SELECT *  from transfer_details where reg_no='".$_POST['reg_no']."'limit 1";
        $updated = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        $UpdatedColumns=array_diff_assoc($updated,$prev);
        if (array_key_exists('status', $UpdatedColumns)) 
        {
            $sql="update transfer_details set approved_date='".$date."' where reg_no='".$_POST['reg_no']."'";
            if($stmt=$conn->query($sql))
            {
            echo "success";
            }
        }
        else{
        echo "success2";
        }
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
