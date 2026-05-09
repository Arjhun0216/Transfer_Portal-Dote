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

    function get_no(){
        $pdf->SetFont('Times','',12);
        $str='1234567890';
        return $str;

    }
    function get_name(){
        $pdf->SetFont('Times','',9);
        $str='Dharaniraj';
        return $str;

    }
    function get_addln1(){
        $pdf->SetFont('Times','',9);
        $str='no 68 MGR nagar';
        return $str;
    }
    function get_addln2(){
        $pdf->SetFont('Times','',9);
        $str='Bargur';
        return $str;
    }
    function get_addln3(){
        $pdf->SetFont('Times','',9);
        $str='Krishnagiri (dt)';
        return $str;
    }
    function get_addln4(){
        $pdf->SetFont('Times','',9);
        $str='635104';
        return $str;
    }
    function get_memo(){
        $this->SetFont('Times','',11);
        $str='16233/J1/2025';
        return $str;

    }
    function get_date(){
        $pdf->SetFont('Times','',12);
        $str='12-mar-2020';
        return $str;

    }
    function get_stname(){
        $pdf->SetFont('Times','B',9);
        $str=' dharaniraj';
        return $str;

    }
    function get_colname(){
        $pdf->SetFont('Times','B',9);
        $str=' III';
        return $str;

    }
    function get_brname(){
        $pdf->SetFont('Times','B',9);
        $str=' csc';
        return $str;

    }
    function get_sem(){
        $pdf->SetFont('Times','B',9);
        $str=' TRANSFER';
        return $str;

    }
    function get_intake(){
        $pdf->SetFont('Times','B',9);
        $str='54321';
        return $str;

    }
    function get_intake2(){
        $pdf->SetFont('Times','B',9);
        $str='12345';
        return $str;

    }
    function get_totstd(){
        $pdf->SetFont('Times','B',9);
        $str=' Govertnment college of engineering bargur krishnagiri(dt)';
        return $str;

    }
    function get_totstd2(){
        $pdf->SetFont('Times','B',9);
        $str='Thanadhai periyar institute of engineering and technology vellor';
        return $str;

    }
    function get_att(){
        $pdf->SetFont('Arial','B',9);
        $str='250';
        return $str;

    }


    function set_brk($t){
        $pdf->SetFont('Arial','',22);
        $pdf->MultiCell(190,8,$t,0,'L');

    }

}

$sql="select reg_no,name_of_student,sem_to,b_name,request_for,fcollege_c_code,tcollege_c_code,attendence_percentage from transfer_details where fcollege_c_code='".$_SESSION['c_code']."' and reg_no='".$_GET['u_id']."' and status='O'";
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
$dated=$conn->query("select order_status,order_date from batch where batch_no=(select batch_no from transfer_details where reg_no='".$_GET['u_id']."')");
$res=$dated->fetch_assoc();
if($res['order_status']=='0')
die("Waiting");
$dateVal = date("d-m-Y", strtotime($res['order_date']));
// $dateVal ="21-05-2024";
$pdf = new PDF('p','mm','A4');
$pdf->AliasNbPages('{pages}');
$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,8,'DEPARTMENT OF TECHNICAL EDUCATION',0,1,'C');
        $pdf->Cell(0,4,'',0,1,'C');
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(60,8,'Proceedings No:',0,0,'R');
        $pdf->Cell(40,8,$pdf->get_memo(),0,0,'L');
        $pdf->Cell(30,8,'DATED :',0,0,'R');
        $pdf->Cell(30,8,$dateVal,0,1,'L');
        // $pdf->Cell(30,8,date('d-m-Y'),0,1,'L');
        $pdf->Cell(0,4,'',0,1);
        $pdf->SetFont('Arial','',11);
        $pdf->Cell(10,6,'Sub : ',0,0,'L');
        $pdf->MultiCell(175,6,'Technical Education - Engineering Colleges - Transfer of students between Institution B.E / B.Tech / B.Arch Part time (B.E / B.Tech / PG / MBA / MCA / M.E / M.Tech / M.Sc and B.Sc) Degree Courses - 2025 - 2026- Odd semester (III, V, VII, IX) - Orders Issued - reg.',0,'L',FALSE);
        $pdf->Cell(0,4,'',0,1);
        $pdf->Cell(10,6,'Ref : ',0,0,'L');
        $pdf->Cell(45,6,'1)   This Office Letter No. :',0,0,'L');
        $pdf->Cell(40,6,"16233 / J1 / 2025,",0,0,'L');
        $pdf->Cell(10,6,'Dated :',0,0,'R');
        $pdf->Cell(30,6,'2025-05-21',0,1,'L');
        $pdf->MultiCell(175,6,'         2)   Transfer Applications forwarded by the Principals of Engineering Colleges seeking Transfer of students In odd semester',0,'L',FALSE);
        $pdf->Cell(0,8,'****************',0,1,'C');
        
        $pdf->SetFont('Arial','',11);
        $pdf->MultiCell(180,6,'  With reference to the above, transfer is ordered during the odd semester of the year 2025-2026, the details of which are given below.',0,'L',FALSE);
        $pdf->Cell(0,4,'',0,1,'C');
$pdf->SetFont('Arial','',12);

$pdf->Cell(30,10,'Register No. : ',0,0,'R');
$pdf->Cell(40,10,$result['reg_no'],0,0,'L');
$pdf->SetFont('Arial','',12);

$pdf->Cell(90,10,'',0,0,'R');
$pdf->Cell(25,10,'',0,1,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(60,8,'NAME OF THE STUDENT','LTB',0,'L');
$pdf->Cell(130,8,$result['name_of_student'],'LRT',1,'L');
$pdf->Cell(60,10,'SEMESTER / BRANCH NAME','LTB',0,'L');
$pdf->Cell(130,10,getRoman($result['sem_to'])." / ".$result['b_name'],'LRT',1,'L');
$pdf->Cell(60,8,'CATEGORY','LTB',0,'L');
$pdf->Cell(130,8,$result['request_for'],'LRT',1,'L');
$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->Cell(60,12,'TRANSFER FROM','LTRB',0,'L');
$pdf->SetXY($x + 60, $y);
$pdf->SetFont("Times",'',9);
$college=explode(",",getCollegeName($result['fcollege_c_code']))[0];
if(strlen($result['fcollege_c_code']." - ".$college)<=70)
{
    $pdf->Cell(130,12,$result['fcollege_c_code']." - ".$college,1,'L');
}
else{
    $pdf->MultiCell(130,6,$result['fcollege_c_code']." - ".$college,1,'L');
}
$pdf->SetXY($x , $y+12);
//$pdf->MultiCell(0,6,$result['fcollege_c_code']."  ".getCollegeName($result['fcollege_c_code']),1,'L');
$pdf->SetFont('Times','B',9);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Cell(60,12,'TRANSFER TO','LRT',0,'L');
$pdf->SetXY($x + 60, $y);
$pdf->SetFont("Times",'B',9);
$pdf->SetXY($x + 60, $y);
$pdf->SetFont("Times",'',9);
$college1=explode(",",getCollegeName($result['tcollege_c_code']))[0];
//echo strlen($result['tcollege_c_code']." - ".$college1);
if(strlen($result['tcollege_c_code']." - ".$college1)<=70)
{
    $pdf->Cell(130,12,$result['tcollege_c_code']." - ".$college1,1,'L');
}
else{

    $pdf->MultiCell(130,6,$result['tcollege_c_code']." - ".$college1,1,'L');
}
$pdf->SetXY($x , $y+12);
$pdf->SetFont("Times",'B',9);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(60,6,'% OF ATTENDANCE IN LAST ATTENDED SEM',1,'L');
$pdf->SetXY($x + 60, $y);
$pdf->SetFont("Times",'',9);
$pdf->Cell(130,12,$result['attendence_percentage'],1,1,'L');
$pdf->SetFont('Times','B',9);
$pdf->Cell(10,3,'',0,1);
$pdf->MultiCell(190,6,'    The above transfer is accorded based on the details furnished by the respective Principal like vacancy position, attendance details, lack of attendance particulars and documents submitted (Hall Ticket, Mark Sheets). Any discrepancy if brought to notice later by Anna University or authorities will lead to Cancellation of the transfer order.',0,'L');

$pdf->Cell(185,10,'',0,1);
$pdf->Cell(0,5,'Sd. /J.Innocent Divya,',0,1,'R');
$pdf->Cell(0,5,'Commissioner of Technical Education',0,1,'R');
$pdf->Cell(185,3,'',0,1);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Cell(30,6,'1)   The Principal, ',0,0,'L');
$pdf->SetXY($x+30,$y);
$pdf->MultiCell(160,6,$result['fcollege_c_code']."-".getCollegeName($result['fcollege_c_code']),0,'L');
$pdf->Cell(185,4,'',0,1);
$pdf->Cell(30,6,'2)   The Principal, ',0,0,'L');
$pdf->MultiCell(160,6,$result['tcollege_c_code']."-".getCollegeName($result['tcollege_c_code']),0,'L');
$pdf->Cell(0,4,'',0,1);
$pdf->SetFont('Times','',9);
$pdf->Cell(10,6,'',0,0);
$pdf->MultiCell(180,6,'With a request to admit the student after confirming the eligibility of the student to continue the semester in which transfer is ordered. Transfer in even semester is not permissible as per norms.',0,'L');
$pdf->Cell(0,3,'',0,1);
// $pdf->Cell(0,6,'Copy to,',0,1,'L');
// $pdf->SetFont('Times','',9);
// $pdf->Cell(10,6,'',0,0);
// $pdf->Cell(180,6,$result['name_of_student'],0,1,'L');
// $pdf->Cell(10,6,'',0,0);
// $pdf->Cell(180,6,$result['address'],0,1,'L');
// $pdf->Cell(10,6,'',0,0);
// $pdf->Cell(180,6,$result['address2'],0,1,'L');
// $pdf->Cell(10,6,'',0,0);
// $pdf->Cell(180,6,$result['district']."  ".$result['pincode'],0,1,'L');
// $pdf->Cell(10,6,'',0,0);




$pdf->Output();


?>