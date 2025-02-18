<?php
//include connection file
include_once("connection.php");
include_once('libs/fpdf.php');
 
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.png',10,-1,70);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(80,10,'Employee List',1,0,'C');
    // Line break
    $this->Ln(20);
}
 
// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
 
$db = new dbObj();
$connString =  $db->getConnstring();
//display_heading = array('id'=>'ID', 'employee_name'=> 'Name', 'employee_age'=> 'Age','employee_salary'=> 'Salary',);
 
$result = mysqli_query($connString, "SELECT DATE_FORMAT(recorded_time, '%b-%Y 5d/%m.%Y') TIME,station_id,parameter_code,recorded_level,min_recorded_level,max_recorded_level,recorded_time FROM db_migrate_pollutant_level_data_2017_9 LIMIT 10 OFFSET 10") or die("database error:". mysqli_error($connString));
$header = mysqli_query($connString, "SHOW columns FROM employee");
 
$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
foreach($header as $heading) {
$pdf->Cell(40,12,$display_heading[$heading['Field']],1);
}
foreach($result as $row) 
{
  $pdf->Ln();
  foreach($row as $column)
     $pdf->Cell(40,12,$column,1);
}

$pdf->Output();
?>
