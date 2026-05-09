<?php
session_start();

if(!isset($_SESSION['c_code']))
{
    //$_SESSION['redirect']=$_SERVER['REQUEST_URI'];
    header("Location:/user/log_in.php");
}

include '../user/database.php';
if($stmt=$conn->prepare("select  a_no,name,save from student_info where c_code=? and b_code=?  order by name"))
{
    $stmt->bind_param("ss",$_SESSION['c_code'],$_POST['b_code']);
    if($stmt->execute())
    {
        $result=$stmt->get_result();
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
<?php 
if($result->num_rows==0)
{
    echo "No record";
}
 ?>
<?php $count=1;?>
<?php while($row=$result->fetch_assoc()):?> 
<?php if($row['save']==1):?>
<div  class="tabulator-table" style="min-width: 480px; min-height: 1px; ">
<div id="<?php echo $row['a_no'] ;?>" class="tabulator-row tabulator-selectable tabular-row-odd" role="row" style="padding-left:0px;">
<div class="tabulator-cell" role="gridcell" tabulator-field="SNO" title style="width:70px;text-align:center;height:32px;"><?php echo $count;$count=$count+1; ?></div>
<div class="tabulator-cell" role="gridcell" tabulator-field="APP_NO" title style="width:80px;text-align:center;height:32px;"><?php echo $row['a_no'] ;?></div>
<div class="tabulator-cell" role="gridcell" tabulator-field="NAME" title style="width:170px;text-align:center;height:32px;"><?php echo $row['name']; ?></div>
<div class="tabulator-cell" role="gridcell" tabulator-field="Status" title style="width:90px;text-align:center;height:32px;">
<button class="btn btn-success" value="<?php echo $row['a_no']; ?>" style="font-size:12px;padding:0px;height:24px;width:70px">View/Edit</button>
</div>       
</div>
</div>
<br>
<?php endif?>
<?php endwhile ?>
<?php $conn->close(); ?>