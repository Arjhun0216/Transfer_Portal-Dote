<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("INVALID REQUEST");
}
require('fpdf/fpdf.php');
include '../user/database.php';


class PDF extends FPDF{

    function header(){
        
    }

   

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
$sql="select dated,request_for, reg_no,name_of_student,tcollege,b_name,sem_to,tcollege_sanctioned_intake,tcollege_total_students,tcollege_total_after,freezed_to from transfer_details where reg_no='".$_GET['u_id']."' and tcollege_c_code=".$_SESSION['c_code'];
if($stmt=$conn->query($sql))
{
    if($stmt->num_rows<=0)
    die("INVALID");
    $result=$stmt->fetch_assoc();
}
else
die("INVALID");
if($result['freezed_to']=='0')
die("Freeze to Download Document");
$pdf = new PDF('p','mm','A4');
$pdf->AliasNbPages('{pages}');
$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();
$pdf->SetFont('Times','B',16);
if($result['request_for']=="TRANSFER")
$pdf->Cell(0,8,'TRANSFER OF INSTITUTION',0,1,'C');
else
$pdf->Cell(0,8,'TRANSFER CUM READMISSION OF INSTITUTION',0,1,'C');
$pdf->SetFont('Times','B',14);
$pdf->MultiCell(180,8,'(To be filled by the principal of the Institution, in which the student is at present studying)',0,'C');
$pdf->Cell(190,10,'',0,1);
$pdf->SetFont('Times','B',12);
$pdf->MultiCell(190,8,'(To be filled by the principal of the Institution to which Transfer is requested)',0,'C');

$pdf->SetFont('Times','',12);
#$t='avjsvhjgfhjbsvbgvihvkhbhv hvhkhv hdjkfvhuihfvunv  jdhvuhiuvhu jhvhgiuhijnv hivfvhiuhf bhfdugvi hkfjvj';
#$str=$pdf->GetStringWidth($t);
#if($str>100){
 #   $pdf->set_brk($t);
#}

$pdf->Cell(35,10,'Endorsement No: ',0,0,'R');
$pdf->Cell(40,10,$result['reg_no'],0,0,'L');
$pdf->SetFont('Times','',12);
$pdf->Cell(90,10,'Dated: ',0,0,'R');
$pdf->Cell(25,10,$result['dated'],0,1,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(57,8,'NAME OF THE STUDENT','LTB',0,'L');
$pdf->SetFont('Times','',9);
$pdf->Cell(133,8,$result['name_of_student'],'LRT',1,'L');
$pdf->SetFont("Times",'B',9);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(57,6,"NAME OF THE \nCOLLEGE",1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',9);
if(strlen($result['tcollege'])<=62)
$pdf->MultiCell(0,6,$result['tcollege']."\n ",1,'L');
else
$pdf->MultiCell(0,6,$result['tcollege'],1,'L');


$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,8,"BRANCH OF STUDY",1,0,'L');

$pdf->SetFont("Times",'',10);

$pdf->Cell(133,8,$result['b_name'],1,1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(57,6,"SEMESTER IN WHICH TRANSFER\n IS REQUESTED",1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',11);

$pdf->MultiCell(0,12,getRoman($result['sem_to']),1,'L');

//$pdf->MultiCell(130,6,'Enclose relevent copy of covering letter of DOTE approval as applicable (Details given in next page)',1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(57,6,"SACTIONED INTAKE IN pdf BRANCH IN THE RESPECTIVE ACADEMIC YEAR",1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',11);


$pdf->MultiCell(0,18,$result['tcollege_sanctioned_intake'],1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(57,6,"TOTAL NO. OF STUDENTS ON ROLL IN THIIS BRANCH AND SEMESTER AS ON DATE",1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',11);

$pdf->MultiCell(0,18,$result['tcollege_total_students'],1,'L');

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(57,6,"TOTAL NO. OF STUDENTS IN pdf BRANCH AND SEMESTER INCLUDING THE TRANSFEREE",1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',11);

$pdf->MultiCell(0,18,$result['tcollege_total_after'],1,'L');


$pdf->Cell(10,6,'Note : ','',0,'L');
$pdf->MultiCell(175,6,'The application is not valid. if the above particulars are not filled up properly and submitted without mark sheet or Hall ticket copies and in the absence of the signature of the principals.',0,'L');

$pdf->Cell(185,20,'',0,1);

$pdf->Cell(0,10,'Office Seal:',0,0,'L');
$pdf->Cell(0,10,'Signature of the Principal with Seal',0,0,'R');

$pdf->Output();


?>