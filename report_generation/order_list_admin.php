<?php
session_start();

require('fpdf/fpdf.php');
include '../user/database.php';
class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

function Header()
{
    // Logo
    //$this->Image('logo.png',10,6,30);
   
    $this->SetFont('Times','',15);
    // Title
    $this->Cell(40,10,date("d-m-Y"),1,0,'C');
    $this->SetFont('Times','B',15);
    $this->Cell(0,10,'DEPARTMENT OF TECHNICAL EDUCATION :: CHENNAI 600025',0,0,'C');
    $this->Ln();
    $this->Cell(40,10,$_GET['batch_number'],1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(0,5,'    TRANSFER/READMISSION CUM TRANSFER ODD SEMESTER 2025-2026',0,0,'C');
    $this->Ln();
    $this->SetFont('Times','',10);
    $this->Cell(0,5,'           LETTER NO :16233/J1/2025',0,0,'C');
    // Line break
   $this->Ln(10);
   $this->SetFont('Times','B',10);

   $this->Cell(11,12,"S.no",1,0,'C');
   $x = $this->GetX();
   $y = $this->GetY();
   $this->MultiCell(4,3.0,"CAT",1,'C');
   $this->SetXY($x + 4, $y);
   $this->Cell(35,12,"Roll No",1,0,'C');
   $this->Cell(40,12,"Name",1,0,'C');
   $this->Cell(9,12,"Sem",1,0,'C');
   $this->Cell(37,12,"Branch",1,0,'C');
   $this->Cell(50,12,"From College",1,0,'C');
   $this->Cell(50,12,"To College",1,0,'C');
   $x = $this->GetX();
   $y = $this->GetY();
   $this->MultiCell(10,4,"\nSanc\nInt",1,'C');
   
   $this->SetXY($x + 10, $y);
   $x = $this->GetX();
   $y = $this->GetY();
   $this->MultiCell(10,4,"\nAdm\nitted",1,'C');
   $this->SetXY($x + 10, $y);
   $x = $this->GetX();
   $y = $this->GetY();
   $this->MultiCell(10,4,"\nVaca\nncy",1,'C');
   $this->SetXY($x + 10, $y);
   $x = $this->GetX();
   $y = $this->GetY();
   $this->MultiCell(12,3,"\n%\nAtt\n ",'TLRB','C');
   $this->Ln();
}
function Footer()
{
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().' of {nb}',0,0,'C');
}
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
?>

<?php


function GenerateWord()
{
    //Get a random word
    $nb=rand(3,10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'),ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb=rand(1,10);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=GenerateWord().' ';
    return substr($s,0,-1);
}

$pdf=new PDF_MC_Table();
$pdf->AddPage('L');
$pdf->SetFont('Times','',8);
$pdf->AliasNbPages();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(11,4,35,40,9,37,50,50,10,10,10,12));
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
$sql1="UPDATE transfer_details set batch_no='".$_GET['batch_number']."' where reg_no in (select reg_no from transfer_details where approved_date between '".$_GET['from_date']."' and '".$_GET['to_date']."' and status='A' order by reg_no)";
if($stmt1=$conn->query($sql1))
{
    $date=date("Y-m-d");
        $sql="select * from transfer_details where batch_no='".$_GET['batch_number']."' and status='A' order by tcollege_c_code,sem_to,b_name";
        if($stmt=$conn->query($sql))
        {
            // $result=$stmt->fetch_assoc();
            if($stmt->num_rows<=0)
            die("No record Exists");
            $count=1;
            while($result=$stmt->fetch_assoc()){
            $cat=$result['request_for']=="TRANSFER"?"T":"TR";
            $result['fcollege']=explode(",",$result['fcollege'])[0];
            $result['tcollege']=explode(",",$result['tcollege'])[0];
            $pdf->Row(array($count++,$cat,$result['reg_no'],$result['name_of_student'],getRoman($result['sem_to']),$result['b_name'],$result['fcollege'],$result['tcollege'],$result['sanctioned_intake'],$result['admitted'],$result['vacancy'],$result['attendence_percentage']));
            }
        }
        else
        {
        echo $conn->error;
        }    
}
else{
    echo $conn->error;
    die("not updated");
}


$pdf->Output("I","Approved.pdf");
?>