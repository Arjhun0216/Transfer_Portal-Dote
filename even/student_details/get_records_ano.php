<?php
session_start();


if(!isset($_SESSION['c_code']))
{
    //$_SESSION['redirect']=$_SERVER['REQUEST_URI'];
    header("Location:/user/log_in.php");
}
include '../user/database.php';
$record=array();
$sql="SELECT   name,catogory,b_code, dob, gender, mobile,email,nationality, nativity, religion, community, caste_name, parent_occupation, state, district, hsc_tn, qualifying_exam, name_of_board, year_of_passing, hsc_reg_no, hsc_group, eleventh_pass, physics_m, physics_t, chemistry_m, chemistry_t, maths_m, maths_t, optional_m, optional_t, annual_income, aicte_tfw, pms, fg, fg_district,fg_no, Availed_fg FROM student_info WHERE a_no=? and c_code=? and b_code=?";
if($stmt=$conn->prepare($sql))
{
    //echo $_POST['a_no'];
    $stmt->bind_param("sss",$_POST['a_no'],$_SESSION['c_code'],$_POST['b_code']);
    if($stmt->execute())
    {
        $result=$stmt->get_result();
        if($result->num_rows==0)
        die("no_data");

        array_push($record,$result->fetch_assoc());
        //header('Content-type: application/json');
        echo json_encode($record);
    }
    else
    {
        echo $conn->error;
    }
}
else{
    echo $conn->error;
}

?>
<?php $conn->close(); ?>