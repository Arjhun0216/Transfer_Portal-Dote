<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("INVALID REQUEST");
}
require('fpdf/fpdf.php');
include '../user/database.php';
class PDF extends FPDF{

    }

$sql="select reg_no,name_of_student,b_name,mode_of_admission,discontinued_sem,discontinued_year,readmission_sougth_sem,readmission_sougth_year,approved_date,dated from readmission_details where c_code='".$_SESSION['c_code']."' and reg_no='".$_GET['u_id']."' and approved=4";
if($stmt=$conn->query($sql))
{
    if($stmt->num_rows<=0)
    die("INVALID");
}
function getRoman($num)
{
    switch($num)
    {
        case 2:return "II";
        case 3:return "III";
        case 4:return "IV";
        case 5:return "V";
        case 6:return "VI";
        case 7:return "VII";
        case 8:return "VIII";
        case 9:return "IX";
    }
}
function getCollegeName($valu)
{   global $conn;
    $stmt=$conn->query("select name_of_college_with_address from college_details where c_code=".$valu);
    if(!$stmt || $stmt->num_rows<=0)
    die("INVALID2");
    return $stmt->fetch_assoc()['name_of_college_with_address'];
}
$result=$stmt->fetch_assoc();
$dated=$conn->query("select order_status,order_date from re_batch where batch_no=(select batch_no from readmission_details where reg_no='".$_GET['u_id']."')");
$res=$dated->fetch_assoc();
if($res['order_status']=='0')
die("Waiting");
$dateVal = date("d-m-Y", strtotime($res['order_date']));

$pdf = new PDF('p','mm','A4');
$pdf->AliasNbPages('{pages}');
$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
        $pdf->Cell(0,8,'DEPARTMENT OF TECHNICAL EDUCATION',0,1,'C');
        $pdf->Cell(0,4,'',0,1,'C');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(60,8,'Letter No :',0,0,'R');
        $pdf->Cell(40,8,"000171 / J1 / 2025,",0,0,'L');
        $pdf->Cell(30,8,'Dated :',0,0,'R');
        // $pdf->Cell(30,8,$dateVal,0,1,'L');
        $pdf->Cell(30,8,"18.03.2025",0,1,'L');
        $pdf->Cell(0,4,'',0,1);
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(10,6,'Sub : ',0,0,'L');
        $pdf->MultiCell(175,6,'Technical Education - Engineering Colleges - Readmission - 2024 - 2025 - Even semester (II,IV, VI, VIII, X) - Readmission Orders Issued - reg.',0,'L',FALSE);
        $pdf->Cell(0,4,'',0,1);
        $pdf->Cell(10,6,'Ref : ',0,0,'L');
        $pdf->Cell(40,6,'1)   This Office Letter No :',0,0,'L');
        $pdf->Cell(40,6,"000171/J1/2025,",0,0,'L');
        $pdf->Cell(10,6,'Dated :',0,0,'R');
        $pdf->Cell(30,6,"10.01.2025",0,1,'L');
        $pdf->Cell(0,4,'',0,1);
        $pdf->Cell(10,6,'',0,0,'L');
        $pdf->Cell(43,6,'2)   online application forwarded by Principals concerned.',0,0,'L');
        // $pdf->Cell(30,6,"14566 / ECA1 / 2020,",0,0,'L');
        // $pdf->Cell(20,6,'Dated :',0,0,'R');
       // $pdf->Cell(30,6,$result['dated'],0,1,'L');
        $pdf->Cell(0,6,'',0,1);
        $pdf->Cell(0,8,'--------x-------',0,1,'C');
        $pdf->SetFont('Arial','',12);
        $pdf->MultiCell(180,6,'  With reference to the readmission application forwarded by your letter second cited, readmission is ordered in respect of the following student, the details of which are given below:',0,'L',FALSE);
        $pdf->Cell(0,4,'',0,1,'C');
$pdf->SetFont('Arial','',12);

$pdf->Cell(50,10,'Anna University Reg. No: ',0,0,'R');
$pdf->Cell(40,10,$result['reg_no'],0,1,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(60,8,'Name of the Student','LTB',0,'L');
$pdf->Cell(130,8,$result['name_of_student'],'LRT',1,'L');
$pdf->Cell(60,20,'Name of the Institution','LTB',0,'L');
//$pdf->Cell(15,10,$_SESSION['c_code'],'LTB',0,'C');
$college=explode(",",getCollegeName($_SESSION['c_code']))[0];
if(strlen($_SESSION['c_code']." - ".$college)<=120)
{
    $pdf->Cell(130,20,$_SESSION['c_code']." - ".$college,'LTBR',1,'L');

}
else{
$pdf->MultiCell(130,10,$_SESSION['c_code']." - ".$college,1,'L');
}
$pdf->Cell(60,10,'Branch / Admitted','LTB',0,'L');
$pdf->Cell(90,10,$result['b_name']."  /",'LBT',0,'L');
$pdf->Cell(40,10,$result['mode_of_admission'],'TBR',1,'L');

$pdf->Cell(60,5,'Period of Discontinuance','LT',1,'L');
$pdf->Cell(60,5,'(Sem and Year)','L',1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x+60,$y-10);
$pdf->Cell(15,10,getRoman($result['discontinued_sem']). "   /",'LBT',0,'L');
$pdf->Cell(115,10,$result['discontinued_year'],'TBR',1,'L');
$pdf->Cell(60,5,'Period of continuance','LT',1,'L');
$pdf->Cell(60,5,'(Sem and Year)','LB',1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x+60,$y-10);
$pdf->Cell(15,10,getRoman($result['discontinued_sem']). "   /",'LBT',0,'L');
$pdf->Cell(115,10,$result['readmission_sougth_year'],'TBR',1,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(10,3,'',0,1);
$pdf->MultiCell(190,6,'    The readmission order above is based on details furnished by the principal of the institution like Lack of attendance, Semester and Year of Discontinuance, Semester and Year of continuance sought etc. If any discrepancy is brought to notice later by Anna University Chennai - 25, the Re - admission order above will automatically stand cancelled.',0,'L');

$pdf->Cell(185,10,'',0,1);

$pdf->Cell(0,5,'Sd. /-J. Innocent Divya,',0,1,'R');
$pdf->Cell(0,5,'Commissioner of Technical Education',0,1,'R');
$pdf->Cell(185,3,'',0,1);

$pdf->Cell(0,6,'To ',0,1,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(10,6,'',0,0);
$pdf->Cell(180,6,'The Principal',0,1,'L');
$pdf->Cell(10,6,'',0,0);
$pdf->MultiCell(160,6,getCollegeName($_SESSION['c_code']),0,'L');


$pdf->Output();


?>
