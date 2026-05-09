<?php
session_start();

include 'user/database.php';

$sql="update college_details set pass=? where c_code=?";
if($stmt=$conn->prepare($sql))
{
    $stmt->bind_param("ss",$_POST['pass'],$_SESSION['c_code']);
    if($stmt->execute())
    {
        if($stmt->affected_rows==0)
        {
            echo "You have already changed password";
        }
        else
        echo "Success";
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