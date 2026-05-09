<?php
session_start();
if(!isset($_SESSION['c_code']))
{
    die("INVALID REQUEST");
}
include '../user/database.php';
require('fpdf/fpdf.php');

class PDF extends FPDF{
  
    function header(){
        $this->SetFont("Times",'B',12);
        $this->Cell(0,6,'DEPARTMENT OF TECHNICAL EDUCATION : CHENNAI 600 025',0,1,'C');
        $this->SetFont("Times",'B',12);
        $this->Cell(0,6,'TRANSFER APPLICATION FORM FOR UG/PG',0,1,'C');
        $this->Cell(0,6,'DEGREE COURSES (EVEN SEMESTER) - 2024 - 2024',0,1,'C');
    }
    function setcol_name($w,$h,$t,$x,$y){
        $this->Cell($w,$h,$t,$x,$y,'C');

    }
    

}
function getRoman($num)
{
    switch($num)
    {
        case 1:return "I";
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
$sql="select * from transfer_details where fcollege_c_code='".$_SESSION['c_code']."' and reg_no='".$_GET['u_id']."'";

if($stmt=$conn->query($sql))
{
    if($stmt->num_rows<=0)
    die("INVALID");
    $result=$stmt->fetch_assoc();
}
else
die("INVALID");

if($result['freezed']=='0')
die("Freeze to download document");
$result['fcollege']=explode(",",$result['fcollege'])[0];
$result['tcollege']=explode(",",$result['tcollege'])[0];
$pdf = new PDF('p','mm','A4');
$pdf->AliasNbPages('{pages}');
$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();
//$pdf->SetMargins(2,2);
$pdf->SetFont('Times','B',9);
$pdf->Cell(57,20,'NAME OF THE STUDENT','LTB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,10,$result['reg_no'],'LRT',1,'L');
$pdf->Cell(57,10,'','',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,10,$result['name_of_student'],'LR',1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,40,'ADDRESS FOR COMMUNICATION','LB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->MultiCell(133,8,$result['address']."\n".$result['address2']."\n".$result['district']." - ".$result['pincode']."\n".$result['mobile']."\n".$result['email'],1);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(57,8,"MONTH AND YEAR OF ADMISSION IN THE FIRST YEAR/DIRECT SECOND YEAR/PG(MBA/MCA/ME)",1,'R');
$pdf->SetFont("Times",'',9);
$pdf->SetXY($x + 57, $y);
$pdf->MultiCell(0,8,$result['admission_type']."\n".$result['admission_month']."\n".$result['admission_year'],1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,8,'TRANSFER REQUEST FOR','LB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,8,$result['request_for'],'LRB',1,'L');
$pdf->SetFont("Times",'BU',12);
$pdf->MultiCell(190,8,'NAME OF THE INSTITUTION, BRANCH AND SEMESTER IN WHICH HE / SHE HAS STUDIED EVEN SEMESTER (II,IV,VI,VIII)',1,'C');

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(57,6,"NAME OF THE \nCOLLEGE",1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',9);
if(strlen($result['fcollege'])<=67)
{
    $pdf->MultiCell(0,6,$result['fcollege']."\n ",1,'L');
}
else
$pdf->MultiCell(0,12,$result['fcollege'],1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(57,5,'WHETHER COLLEGE IS AUTONOMUS (Yes/No)',1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',9);
$pdf->MultiCell(0,10,$result['fcollege_autonomous']=='1'?"YES":"NO",1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(57,8,'NAME OF BRANCH',1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',9);
$pdf->MultiCell(133,8,$result['b_name'],1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,8,'SEMESTER (II/IV/VI/VIII)','LRB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,8,getRoman($result['sem_from']),'RB',1,'L');
$pdf->SetFont("Times",'BU',12);
$pdf->MultiCell(190,8,'NAME OF THE COLLEGE, BRANCH AND SEMESTER TO WHICH THE TRANSFER IS REQUESTED IN III,V,VII,IX SEMESTERS',1,'C');
$pdf->SetFont("Times",'B',9);
$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->MultiCell(57,6,"NAME OF THE \nCOLLEGE",1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',9);
if(strlen($result['tcollege'])<=66)
{
    $pdf->MultiCell(0,6,$result['tcollege']."\n ",1,'L');
}
else
$pdf->MultiCell(0,12,$result['tcollege'],1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(57,5,'WHETHER COLLEGE IS AUTONOMUS (Yes/No)',1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',9);
$pdf->MultiCell(0,10,$result['tcollege_autonomous']=='1'?"YES":"NO",1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(57,8,'NAME OF BRANCH',1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',9);
$pdf->MultiCell(133,8,$result['b_name'],1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,8,'SEMESTER (II/IV/VI/VIII)','LRB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,8,getRoman($result['sem_to']),'RB',1,'L');
$pdf->SetFont("Times",'BU',12);
$pdf->MultiCell(190,8,'MONTH AND YEAR OF EVEN SEMESTER EXAMINATIONS(II,IV,VI,VIII) LAST APPERRED',1,'C');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,8,'MONTH',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(40,8,$result['last_appeared_month'],1,0,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(93,8,'REASON FOR REQUESTION TRANSFER',1,1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,8,'YEAR',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(40,8,$result['last_appeared_year'],1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(20,8,$result['reason'],0,0,'L');
$pdf->Cell(73,8,'','R',1);
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,8,'SEMESTER',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(40,8,getRoman($result['last_appeared_semester']),1,0,'L');
$pdf->Cell(20,8,'',0,0,'L');
$pdf->Cell(73,8,'','R',1);
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,8,'UNIVERSITY REG NUMBER',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(40,8,$result['reg_no'],1,0,'L');
$pdf->Cell(20,8,'',"B",0,'L');
$pdf->Cell(73,8,'','RB',1);

$pdf->Cell(78,20,'',0,1);

$pdf->SetFont("Times",'BU',15);
$pdf->Cell(0,20,'UNDERTAKING',0,1,'C');
$pdf->SetFont("Times",'',12);
$pdf->MultiCell(190,8,'I hear agree for the Transfer / Re-admission cum Transfer , accepting the condition that the university may prescribe in this regard. ',0);

$pdf->Cell(185,8,'',0,1);
$pdf->SetFont("Times",'B',15);
$pdf->Cell(78,20,'I further agree and state that,',0,1,'L');
$pdf->SetFont("Times",'',12);
$pdf->Cell(5,8,'1.',0,0,'R');
$pdf->MultiCell(187,8,'I shall appear for the equivalent or additional papers, if any, that may be prescribed by the university. ',0,'L');
$pdf->Cell(5,8,'2.',0,0,'R');
$pdf->MultiCell(187,8,'I shall diligent and faithfully follow the instructions and curriculumof the college to which i am transferred, that are in force time to time. ',0,'L');
$pdf->Cell(5,8,'3.',0,0,'R');
$pdf->MultiCell(187,8,'I agree to pay whatever fees that are prescribed by the concerned university for such Transfer. ',0,'L');
$pdf->Cell(5,8,'4.',0,0,'R');
$pdf->MultiCell(187,8,'I shall not prefer any claim or right for exemption for any any papers what so ever. ',0,'L');
$pdf->Cell(5,8,'5.',0,0,'R');
$pdf->MultiCell(187,8,'I shall not prefer any representation seeking stay of or exempting from the operation of any part or in full of the conditions to be prescribed by the University/College. ',0,'L');

$pdf->Cell(5,8,'6.',0,0,'R');
$pdf->MultiCell(187,8,'I am aware that the transfer /Re-admission cum transfer ordered by DOTE is subject to confirmation by Anna University , Chennai. ',0,'L');

$pdf->Cell(185,20,'',0,1);

$pdf->Cell(0,10,'Signature of the parent',0,0,'L');
$pdf->Cell(0,10,'Signature of the Student',0,0,'R');


$pdf->Cell(185,70,'',0,1);

$pdf->Cell(35,10,'Endorsement No: ',0,0,'R');
$pdf->Cell(40,10,$result['reg_no'],0,0,'L');
$pdf->SetFont("Times",'',12);
$pdf->Cell(95,10,'Dated: ',0,0,'R');
$pdf->Cell(25,10,$result['dated'],0,1,'L');
$pdf->SetFont("Times",'',12);
$pdf->Cell(50,8,'Forward to the principal ',0,0,'L');
$pdf->SetFont("Times",'U',8);
$pdf->Cell(150,8,$result['tcollege'],0,1,'L');

$pdf->SetFont("Times",'',12);
$pdf->Cell(5,8,'1.',0,0,'R');
$pdf->MultiCell(187,8,'The particulars furnished by the applicant are correct. ',0,'L');
$pdf->Cell(5,8,'2.',0,0,'R');
$pdf->MultiCell(187,8,'He / She has not taken part in any anti-social activities.',0,'L');
$pdf->Cell(5,8,'3.',0,0,'R');
$pdf->MultiCell(187,8,'His/Her character and conduct are good / not commendable.',0,'L');
$pdf->Cell(5,8,'4.',0,0,'R');
$pdf->MultiCell(187,8,'I have no objection to transfer the student to your Institution.',0,'L');
$pdf->Cell(5,8,'5.',0,0,'R');
$pdf->MultiCell(187,8,'He / She has not been removed from Roll of the institution for any of his/her act when he/ she was a student of this college.',0,'L');

//$pdf->Cell(195,4,'',0,1);
$pdf->Cell(5,8,'',0,0,'R');
$pdf->SetFont("Times",'B',12);
$pdf->MultiCell(187,8,"(If the particulars below are not furnished the application will not be considered)\nParticulars of lack of attendence in even semester(III,V,VII,IX)",0,'C');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(60,8,'NAME OF THE STUDENT','LTB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(130,8,$result['name_of_student'],'LRT',1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(60,10,"NAME OF THE COLLEGE\n" ,1,'L');
$pdf->SetXY($x+60,$y);
$pdf->SetFont("Times",'',9);
if(strlen($result['fcollege'])<=67)
$pdf->MultiCell(0,5,$result['fcollege']."\n ",1,'L');
else
$pdf->MultiCell(0,5,$result['fcollege'],1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(60,10,'BRANCH OF STUDY',1,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(130,10,$result['b_name'],'LRT',1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(60,8,'REG.NO OF THE STUDENT','LTB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(130,8,$result['last_appeared_reg_no'],'LRT',1,'L');
if($result['request_for']=="TRANSFER CUM READMISSION"){
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(60,5,'EVEN SEMESTER IN WHICH STUDENT WAS PUT INTO LACK OF ATTENDENCE(III,V,VII,IX)',1,'L');
$pdf->SetXY($x+60,$y);
$pdf->SetFont("Times",'',9);
$pdf->MultiCell(0,15,getRoman($result['tcr_last_appeared_semester']),1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(60,5,'TOTAL NO. OF PERIODS IN SEM MENTIONED ABOVE',1,'L');
$pdf->SetXY($x+60,$y);
$pdf->SetFont("Times",'',9);
$pdf->MultiCell(0,10,$result['total_periods'],1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(60,5,'NO. OF PERIODS ATTENDED BY THE STUDENT',1,'L');
$pdf->SetXY($x+60,$y);
$pdf->SetFont("Times",'',9);
$pdf->MultiCell(0,10,$result['attended_periods'],1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(60,8,'PERCENTAGE OF ATTENDENCE','LTB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(130,8,$result['attendence_percentage'],'LRTB',1,'L');
}
else
{
$pdf->SetFont("Times",'B',9);
$pdf->MultiCell(190,8,'ATTENDANCE DETAILS IN EVEN SEMESTER OF STUDY(II / IV / VI / VIII) - (JAN / FEB / 2020 to MAY / JUNE 2020)',1,'C');
$pdf->SetFont("Times",'B',8);
$pdf->Cell(80,10,'TOTAL NO. OF PERIODS IN SEM MENTIONED ABOVE','LTRB',0,'C');
$pdf->Cell(50,10,'NO. OF PERIODS ATTENDED','LTRB',0,'C');
$pdf->Cell(60,10,'PERCENTAGE OF ATTENDENCE','LTRB',1,'C');
$pdf->SetFont("Times",'',9);
$pdf->Cell(80,8,$result['total_periods'],'LRB',0,'C');
$pdf->Cell(50,8,$result['attended_periods'],'LRB',0,'C');
$pdf->Cell(60,8,$result['attendence_percentage']." %",'LRTB',1,'C');
}
$pdf->SetFont("Times",'',9);
$pdf->MultiCell(190,6,'Note: The attendence particulars communicated to the controller of examination anna university, chennai 600025 should be furnished above, with the proof of copy sent to the controller of examination.',0,'L');
$pdf->SetFont("Times",'B',9);


$pdf->Cell(55,8,'TNEA REG.NO',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(32,8,$result['tnea_reg_no'],'LRTB',0,'L');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(49,8,'BOARD IN WHICH +2 STUDIED',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(54,8,$result['board'],'LTBR',1,'L');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(55,8,'COMMUNITY OF STUDENT',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(32,8,$result['community'],'LRTB',0,'L');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(49,8,'MATHS MARK',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(54,8,$result['mark1'],'LTBR',1,'L');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(55,8,'QUOTA',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(32,8,$result['quota'],'LRTB',0,'L');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(49,8,'PHYSICS MARK',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(54,8,$result['mark2'],'LTBR',1,'L');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(55,8,'FG20-2024)',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(32,8,$result['fg']=='1'?"YES":"NO",'LRTB',0,'L');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(49,8,'CHEMISTRY MARK',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(54,8,$result['mark3'],'LTBR',1,'L');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(55,8,'POSTMATRIC SCHOLARSHIP(Y/N)',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(32,8,$result['pms']=='1'?"YES":"NO",'LRTB',0,'L');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(49,8,'CUT-OFF MARK',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(54,8,$result['cut_off'],'LTBR',1,'L');


$pdf->Cell(180,27,'',0,1);
$pdf->SetFont("Times",'B',9);
$pdf->Cell(0,10,'OFFICE SEAL',0,0,'L');
$pdf->Cell(0,10,'SIGNATURE OF THE PRINCIPAL WITH SEAL',0,0,'R');



$pdf->Output();


?>