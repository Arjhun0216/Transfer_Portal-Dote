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
    $this->Cell(40,10,date("d-m-yy"),1,0,'C');
    $this->SetFont('Times','B',15);
    $this->Cell(0,10,'DEPARTMENT OF TECHNICAL EDUCATION :: CHENNAI 600025',0,0,'C');
    $this->Ln();
    $this->Cell(40,10,$_GET['re_batch_number'],1,0,'C');
    $this->SetFont('Times','',10);
    $this->Cell(0,5,'   READMISSION (EVEN SEMESTER) STUDENTS DURING THE YEAR OF 2023-2024',0,0,'C');
    $this->Ln();
    $this->SetFont('Times','',10);
    $this->Cell(0,5,'           LETTER NO :929/J1/2024',0,0,'C');
    // Line break
   $this->Ln(10);
   $this->SetFont('Times','B',10);

   $this->Cell(10,12,"S.no",1,0,'C');
   $x = $this->GetX();
   $y = $this->GetY();
  // $this->MultiCell(4,3.0,"CAT",1,'C');
  // $this->SetXY($x + 4, $y);
   $this->Cell(25,12,"Roll No",1,0,'C');
   $this->Cell(40,12,"Name",1,0,'C');
   $this->Cell(50,12,"Branch",1,0,'C');
   $x = $this->GetX();
   $y = $this->GetY();
   $this->Cell(40,6,"Discontinuance",1,0,'C');
   $this->SetXY($x, $y+6);
   $this->Cell(20,6,"Sem",1,0,'C');
   $this->Cell(20,6,"Year",1,0,'C');
   $this->SetXY($x+40, $y);
   $this->Cell(60,12,"Name of the College",1,0,'C');
//    $this->Cell(50,12,"From College",1,0,'C');
//    $this->Cell(50,12,"To College",1,0,'C');
        $x = $this->GetX();
        $y = $this->GetY();
   //$this->MultiCell(10,4,"\nSanc\nInt",1,'C');
   $this->Cell(40,6,"Continuance",1,0,'C');
   $this->SetXY($x, $y+6);
   $this->Cell(20,6,"Sem",1,0,'C');
   $this->Cell(20,6,"Year",1,0,'C');
   $this->SetXY($x+40, $y);
   
//    $this->SetXY($x + 10, $y);
//    $x = $this->GetX();
//    $y = $this->GetY();
//    //$this->MultiCell(10,4,"\nAdm\nitted",1,'C');
//    $this->SetXY($x + 10, $y);
//    $x = $this->GetX();
//    $y = $this->GetY();
//    //$this->MultiCell(10,4,"\nVaca\nncy",1,'C');
//    $this->SetXY($x + 10, $y);
//    $x = $this->GetX();
//    $y = $this->GetY();
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
$pdf->SetWidths(array(10,25,40,50,20,20,60,20,20,12));
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
$sql1="UPDATE readmission_details set batch_no='".$_GET['re_batch_number']."' where reg_no in (select reg_no from readmission_details where approved_date between '".$_GET['re_from_date']."' and '".$_GET['re_to_date']."' and approved=1 order by reg_no)";
if($stmt1=$conn->query($sql1))
{
    $date=date("Y-m-d");
        $sql="select * from readmission_details where batch_no='".$_GET['re_batch_number']."' and approved=1 order by c_code,discontinued_sem,b_name";
        if($stmt=$conn->query($sql))
        {
            //$result=$stmt->fetch_assoc();
            if($stmt->num_rows<=0)
            die("No record Exists");
            $count=1;
            while($result=$stmt->fetch_assoc()){
            $result['name_of_college']=explode(",",$result['name_of_college'])[0];
            // if($result['readmission_sougth_sem'] == 0)
            // {
            //     $result['readmission_sougth_sem']=$result['discontinued_sem'];
            // }
            $pdf->Row(array($count++,$result['reg_no'],$result['name_of_student'],$result['b_name'],getRoman($result['discontinued_sem']),$result['discontinued_year'],$result['c_code']."-".$result['name_of_college'],getRoman($result['readmission_sougth_sem']),$result['readmission_sougth_year'],$result['percentage']));
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