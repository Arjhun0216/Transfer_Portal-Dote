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
        $this->SetFont("Times",'B',16);
        $this->Cell(0,8,'DEPARTMENT OF TECHNICAL EDUCATION : CHENNAI 600 025',0,1,'C');
        $this->SetFont("Times",'B',12);
        $this->Cell(0,4,'',0,1,'C');
        $this->Cell(0,6,'APPLICATION FORM FOR READMISSION TO',0,1,'C');
        $this->Cell(0,6,'UG / PG DEGREE COURSES ODD SEMESTER 2025 -2026',0,1,'C');
        $this->Cell(0,4,'',0,1,'C');
    }
    
    function set_adname(){
        //$this->SetFont("Times",'B',9);
        $str="HFBVOFAU\n UFVOIVX\n UYYVCIUXYNYUS UCVUIYSUD\n XUUC IYGY\n UUXYC GUNYCUVF UY GUYXCVGUYV YUC GI YU";
        return $str;

    }
    
    
    function get_colname(){
        ###
        $this->SetFont("Times",'',9);
        $str="abcdjbfvjfj \n hbsdfikjdvb \n jvsbjhbjv \n bhfvbjf \n gsdhbhvbhdsbvhsdbhk";
        return $str;

    }
    


    function get_reason(){
        ###
        $this->SetFont("Times",'',9);
        $str='Travelling distance for my hgome to college so thats all';
        return $str;

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
//$result=array();
#if($stmt=$conn->query($sql))
#{
 #   //global $result;
  #  if($stmt->num_rows<=0)
   # die("Invalid Request");
    #$result=$stmt->fetch_assoc();
  
#}
$sql="select * from readmission_details where c_code='".$_SESSION['c_code']."' and reg_no='".$_GET['u_id']."'";
if($stmt=$conn->query($sql))
{
    if($stmt->num_rows<=0)
    die("INVALID");
    $result=$stmt->fetch_assoc();
}
else
die("INVALID REGNO");

// if($result['freezed']=='0')
// die("Freeze to Download the document");
$pdf = new PDF('p','mm','A4');
$pdf->AliasNbPages('{pages}');
$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();
//$pdf->SetMargins(2,2);
$pdf->Cell(0,4,'',0,1,'C');
$pdf->SetFont('Times','B',9);
$pdf->Cell(57,10,'Anna University Reg no','LTB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,10,$result['reg_no'],'LRTB',1,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(57,10,'Name of the Student','LTRB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,10,$result['name_of_student'],'LR',1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,8,'DATE OF BIRTH','LTB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,8,$result['dob'],'LRTB',1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,8,'MOBILE NUMBER','LTB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,8,$result['mobile'],'LRTB',1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,16,'College name with full Address','LR',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->MultiCell(133,8, $result['c_code'] . " - " . $result['name_of_college'],'LRTB');
$pdf->SetFont('Times','B',9);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(57,8,'Through which mode the student was originally admitted',1,'L');
$pdf->SetFont("Times",'',9);
$pdf->SetXY($x + 57, $y);
$pdf->Cell(133,16,$result['mode_of_admission'],'LR',1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,10,"YEAR OF ADMISSION",1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->SetXY($x + 57, $y);
// $pdf->MultiCell(0,8,"\$result['month_of_admission'].\n".$result['year_of_admission'],1,'L');
$pdf->Cell(133,10,$result['year_of_admission'],'LRTB',1,'L');

$pdf->Cell(57,10,'Branch of Study','LTB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,10,$result['b_name'],'LRTB',1,'L');
$pdf->SetFont("Times",'B',9);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(57,6,'Semester / Year during which course was Discontinued',1,'L');
$pdf->SetXY($x + 57, $y);
$x = $pdf->GetX();
$y = $pdf->GetY();
// $pdf->Cell(66,6,'SEMESTER','LRB',0,'C');
// $pdf->Cell(67,6,'YEAR','LRB',1,'C');
$pdf->SetFont("Times",'',9);
// $pdf->Cell(57,6,'',0,0,'C');
$pdf->Cell(66,12,getRoman($result['discontinued_sem']),'LRB',0,'C');
$pdf->Cell(67,12,$result['discontinued_year'],'LRB',1,'C');
$pdf->SetFont("Times",'B',9);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(57,6,"Semester / Year during which Readmission is sought",1,'L');
$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',9);
$pdf->Cell(66,12,getRoman($result['readmission_sougth_sem']),'LRB',0,'C');
$pdf->Cell(67,12,$result['readmission_sougth_year'],'LRB',1,'C');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont("Times",'B',9);
$pdf->Cell(57,12,'Reason for Discontinuance of study',1,0,'L');
#$pdf->SetXY($x + 57, $y);
$pdf->SetFont("Times",'',9);
$pdf->Cell(133,12,$result['reason'],1,1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();

// $pdf->SetFont("Times",'B',9);
// $pdf->Cell(57,40,'Address for Communication','LB',0,'L');
// $pdf->SetFont("Times",'',9);
// $pdf->MultiCell(133,8,$result['address1']."\n".$result['address2']."\n".$result['district']." - ".$result['pincode']."\n".$result['mobile']."\n".$result['email'],1);
// $pdf->MultiCell(133,8,"address.district.pincode\n".$result['mobile']."\nemail",1);

#$pdf->Cell(189,45,'',0,1);
$pdf->AddPage();
$pdf->SetFont("Times",'BU',15);
$pdf->Cell(0,20,'UNDERTAKING',0,1,'C');
$pdf->SetFont("Times",'',12);
$pdf->MultiCell(190,8,'I hearby agree for the Re-admission, accepting the condition that the university may prescribe in this regard. ',0);

$pdf->Cell(185,4,'',0,1);
$pdf->SetFont("Times",'B',15);
$pdf->Cell(78,10,'I further agree and state that,',0,1,'L');
$pdf->SetFont("Times",'',12);
$pdf->Cell(5,8,'1.',0,0,'R');
$pdf->MultiCell(187,8,'I shall appear for the equivalent or additional papers, if any, that may be prescribed by the university. ',0,'L');
$pdf->Cell(5,8,'2.',0,0,'R');
$pdf->MultiCell(187,8,'I shall not prefer any claim or right for exemption for any papers whatsoever.',0,'L');
$pdf->Cell(5,8,'3.',0,0,'R');
$pdf->MultiCell(187,8,'I shall not prefer any representation seeking stay of or exempting from the operation of any part or in full of the condition to be prescribed by the University / college. ',0,'L');
$pdf->Cell(5,8,'4.',0,0,'R');
$pdf->MultiCell(187,8,'I shall diligent and faithfully follow the instructions and curriculumof the University. ',0,'L');
$pdf->Cell(5,8,'5.',0,0,'R');
$pdf->MultiCell(187,8,'I agree to pay whatever fees that are prescribed by the concerned university for such Readmission. ',0,'L');
$pdf->Cell(5,8,'6.',0,0,'R');
$pdf->MultiCell(187,8,'I am aware that the Readmission ordered by the DTE is subjected to confirmation by anna University. ',0,'L');
$pdf->Cell(5,8,'7.',0,0,'R');
$pdf->MultiCell(187,8,'In the event of my readmission rejected by DOTE based on University records, I will abide by the deision taken by Anna University / DOTE irrespective of the fact that I have been permitted to attend classes by the istitution. ',0,'L');



$pdf->Cell(185,10,'',0,1);
$pdf->SetFont("Times",'U',12);

$pdf->Cell(0,10,'The following documents are enclosed,',0,1,'L');

$pdf->SetFont("Times",'B',12);
$pdf->Cell(8,12,'1)',1,0,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(82,6,'Mark Sheet pertaining to the previous Even Semester studied (II,IV,VI,VIII)',1,'L');
$pdf->SetXY($x + 82, $y);
$pdf->Cell(20,12,'YES','TB',0,'R');
$pdf->Cell(25,12,'(     )','TB',0,'L');
$pdf->Cell(30,12,'NO','TB',0,'R');
$pdf->Cell(25,12,'(     )','TBR',1,'L');
$pdf->Cell(8,18,'2)',1,0,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(82,6,'Copy of details of lack of attendance send to Controller of Examination during Nov. / Dec. (proforma copy) Examinations',1,'L');
$pdf->SetXY($x + 82, $y);
$pdf->Cell(20,18,'YES','TB',0,'R');
$pdf->Cell(25,18,'(     )','TB',0,'L');
$pdf->Cell(30,18,'NO','TB',0,'R');
$pdf->Cell(25,18,'(     )','TBR',1,'L');
$pdf->Cell(8,12,'3)',1,0,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(82,6,'Copy of Readmission already ordered by this office in respect of this student',1,'L');
$pdf->SetXY($x + 82, $y);
$pdf->Cell(20,12,'YES','TB',0,'R');
$pdf->Cell(25,12,'(     )','TB',0,'L');
$pdf->Cell(30,12,'NO','TB',0,'R');
$pdf->Cell(25,12,'(     )','TBR',1,'L');
$pdf->SetFont("Times",'',12);
$pdf->Cell(190,10,'',0,1);
$pdf->Cell(15,6,'Note : ',0,0);
$pdf->MultiCell(170,6,'If the above documents are not enclosed, the application will not be considered for Readmission',0,'L');

$pdf->Cell(190,20,'',0,1);
$pdf->Cell(0,10,'Station : ',0,0,'L');
$pdf->Cell(0,10,'Signature of the Student',0,1,'R');
$pdf->Cell(15,10,'Date  :',0,0,'L');
$pdf->Cell(25,10,$result['dated'],0,1,'L');



$pdf->SetFont("Times",'B',11);
$pdf->Cell(10,6,'',0,0);
$pdf->MultiCell(160,6,'TO BE FILLED BY THE PRINCIPAL OF THE INSTITUTION IN WHICH READMISSION IS SOUGHT',0,'C');
$pdf->SetFont("Times",'',11);
$pdf->MultiCell(190,6,'(If the particulars below are not furnished the application will not be considered)',0,'C');
$pdf->Cell(20,6,'',0,0);
$pdf->MultiCell(160,6,'Particulars of lack of attendance is odd Semester (III, V, VII, IX) during the period July - December',0,'L');
$pdf->SetFont("Times",'B',12);
$pdf->Cell(0,10,'FORMAT - I (Lack of attendance particulars)',0,1,'C');


$pdf->SetFont("Times",'B',9);
$pdf->Cell(110,8,'Name of the Student','LTB',0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(80,8,$result['name_of_student'],'LRT',1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(110,10,"Reg. NO of the Student" ,1,0,'L');
#$pdf->SetXY($x+60,$y);
$pdf->SetFont("Times",'',9);
$pdf->Cell(80,10,$result['reg_no'],1,1,'L');
$pdf->SetFont("Times",'B',9);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(110,6,"Mention the odd Semester in which the student was put into lack of \n attendance (III, V, VII, IX)",1,'L');
$pdf->SetXY($x+110,$y);
$pdf->SetFont("Times",'',9);
$pdf->Cell(80,12,getRoman($result['lack_attendence_sem']),1,1,'L');
$pdf->SetFont("Times",'B',9);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(110,6,"Total No. of Periods taken into account for calculation of attendance \n for the above Semester",1,'L');
$pdf->SetXY($x+110,$y);
$pdf->SetFont("Times",'',9);
$pdf->Cell(80,12,$result['total_periods'],1,1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(110,10,'No. of Periods attend by the Student',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(80,10,$result['total_attended'],1,1,'L');
$pdf->SetFont("Times",'B',9);
$pdf->Cell(110,10,'PERCENTAGE OF ATTENDANCE',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(80,10,$result['percentage'],1,1,'L');
$pdf->SetFont("Times",'B',9.5);
$pdf->MultiCell(190,6,'Note: The attendance particulars communicated to the controller of examination anna university, should be furnished above, with the proof of copy sent to the controller of examination.',0,'L');
$pdf->SetFont("Times",'BU',11);

$pdf->MultiCell(170,6,"Details  of  Write  petition  filed  in  respect  of  student  for  whom  readmission  is  sought.",0,'L');

$pdf->SetFont("Times",'B',9);

$pdf->Cell(40,10,'1 Not Applicable',0,0,'L');
$pdf->Cell(130,10,'',0,0);
$pdf->Cell(20,10,'    ',1,1,'R');

$pdf->Cell(0,4,'',0,1);

$pdf->Cell(170,10,'2)   Write Petition No._________________________  __of________________(Year) filed',0,0,'L');
$pdf->Cell(20,10,'    ',1,1,'R');

$pdf->Cell(0,4,'',0,1);

$pdf->Cell(40,10,'3)   Status of Write petition',0,0,'L');
$pdf->Cell(130,10,'',0,0);
$pdf->Cell(20,10,'Pensing/Closed',0,1,'R');

$pdf->Cell(0,4,'',0,1);

$pdf->SetFont("Times",'B',9.5);
$pdf->MultiCell(190,6,'Note: The Principal is requested to enclose all necessary documents relating to the write petition (Affidavit, Interim directions, Final orders of the Court etc.).',0,'L');

$pdf->Cell(0,4,'',0,1);
// $pdf->SetFont("Times",'B',9);
// $pdf->Cell(100,8,'1.     TNEA Reg.NO',1,0,'L');
// $pdf->SetFont("Times",'',9);
// $pdf->Cell(90,8,$result['tnea_reg_no'],1,1,'C');

$pdf->SetFont("Times",'B',9);
$pdf->Cell(100,8,'1.     Community of student',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(90,8,$result['community'],1,1,'C');


$pdf->SetFont("Times",'B',9);
$pdf->Cell(100,8,'2.     Quota under which admitted',1,0,'L');
$pdf->SetFont("Times",'',9);
$pdf->Cell(90,8,$result['quota'],1,1,'C');


// $pdf->SetFont("Times",'B',9);
// $pdf->Cell(100,8,'4.     Whether FG(2019-2020) is Claimed',1,0,'L');
// $pdf->SetFont("Times",'',9);
// $pdf->Cell(90,8,$result['fg']=='1'?"YES":"NO",1,1,'C');

// $pdf->SetFont("Times",'B',9);
// $pdf->Cell(100,8,'5.     Whether Postmatric schlorship is climed(2019-20)',1,0,'L');
// $pdf->SetFont("Times",'',9);
// $pdf->Cell(90,8,$result['pms']=='1'?"YES":"NO",1,1,'C');


$pdf->Cell(78,15,'',0,1);
$pdf->Cell(78,15,'',0,1);
$pdf->SetFont("Times",'B',9);
$pdf->Cell(0,10,'OFFICE SEAL',0,0,'L');
$pdf->Cell(0,10,'SIGNATURE OF THE PRINCIPAL WITH SEAL',0,0,'R');


$pdf->Output();


?>