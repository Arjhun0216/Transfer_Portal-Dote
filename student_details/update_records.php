<?php
session_start();

include '../user/database.php';
if(!isset($_SESSION['c_code']))
{
    //$_SESSION['redirect']=$_SERVER['REQUEST_URI'];
    header("Location:/user/log_in.php");
}

//echo $_POST['name'];
//echo $_POST['category'];
$sql="UPDATE student_info SET catogory=?,name=?,dob=?,gender=?,mobile=?,email=?,nationality=?,nativity=?,religion=?,community=?,caste_name=?,parent_occupation=?,state=?,district=?,hsc_tn=?,qualifying_exam=?,name_of_board=?,year_of_passing=?,hsc_reg_no=?,hsc_group=?,eleventh_pass=?,physics_m=?,physics_t=?,chemistry_m=?,chemistry_t=?,maths_m=?,maths_t=?,optional_m=?,optional_t=?,annual_income=?,aicte_tfw=?,pms=?,fg=?,fg_district=?,fg_no=?,Availed_fg=?,save=1 WHERE c_code=? and a_no=? and b_code=?";
if($stmt=$conn->prepare($sql))
{
    $stmt->bind_param("ssssssssssssssississiiiiiiiiiiiiississs",$_POST['category'],$_POST['name'],$_POST['dob'],$_POST['gender'],$_POST['mobile'],$_POST['email'],$_POST['nationality'],$_POST['nativity'],$_POST['religion'],$_POST['community'],$_POST['caste_name'],$_POST['parent_occupation'],$_POST['state'],$_POST['district'],$_POST['hsc_tn'],$_POST['qualifying_exam'],$_POST['name_of_board'],$_POST['year_of_passing'],$_POST['hsc_reg_no'],$_POST['hsc_group'],$_POST['eleventh_pass'],$_POST['physics_m'],$_POST['physics_t'],$_POST['chemistry_m'],$_POST['chemistry_t'],$_POST['maths_m'],$_POST['maths_t'],$_POST['optional_m'],$_POST['optional_t'],$_POST['annual_income'],$_POST['aicte_tfw'],$_POST['pms'],$_POST['fg'],$_POST['fg_district'],$_POST['fg_no'],$_POST['availed_fg'],$_SESSION['c_code'],$_POST['a_no'],$_POST['b_code']);
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
<?php $conn->close(); ?>