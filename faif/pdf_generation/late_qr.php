<?php

include('../qrcode/qrlib.php');
require('../fpdf/fpdf.php');
require "../config/database.php";
$db = new Database();
$con = $db->connect();

class PDF extends FPDF
{
// Page header
function Header()
{
	// Logo
	$this->Image('mic.png',10,5,15,20);
	$this->Image('emblem.png',188,5,15,20);
	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Move to the right
	$this->Cell(80);
	// Title
	$this->Cell(30,10,"MHRD's Innovation Cell" ,0,0,'C');
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

$mysql_qry = "SELECT * FROM registrations WHERE contact = ".$_GET['contact'];
$row = mysqli_fetch_array(mysqli_query($con ,$mysql_qry));

$mysql_qry1 = "SELECT * FROM events WHERE event_id = ".$row['event_id'];
$row1 = mysqli_fetch_array(mysqli_query($con ,$mysql_qry1));


////Generation of QR
$name = $row['name'];
$email = $row['email'];
$date_from = $row1['date_from'];
$date_to = $row1['date_to'];
$time_from = $row1['time_from'];
$time_to = $row1['time_to'];
$venue = $row1['venue'];
$event_title = $row1['title'];
$contact = $row['contact'];
$organisation = $row['organisation'];
$designation = $row['designation'];
//$st = $event_id.$user_id;

$event_id_img = '../event_img/'.$row['event_id'].'.png';
$file_name = '../codes/'.$contact.'.png';
$code_text = '{"num":"'.$contact.'"}';
QRcode::png($code_text,$file_name);
$file_data = file_get_contents($file_name);

$mysql_qry = "UPDATE registrations SET qr_name='$contact', qr_data='$file_data' WHERE contact = '$contact'";
$con->query($mysql_qry);
$con->close();


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
if(!is_file($file_name))
{
    $result = file_put_contents($file_name, $file_data);

    if($result === FALSE)
    {
        die(__FILE__.'<br>Error - Line #'.__LINE__.': Could not create '.$file_name);
    }
}
$pdf->Image($file_name,55,175,100,100);
$pdf->Image($event_id_img,10,30,190,54);
$pdf->ln(55);
$pdf->SetFont('Arial','',15);
$pdf->Cell(0,10,'EVENT : '.$event_title,1,1,'C');
$pdf->Cell(0,10,'Venue : '.$venue,1,1,'C');
$pdf->Cell(0,10,'Date : '.$date_from.' - '.$date_to,1,1,'C');
$pdf->Cell(0,10,'Time : '.$time_from.' - '.$time_to,1,1,'C');
$pdf->ln(5);
$pdf->Cell(0,10,'Name : '.$name,0,1,'L');
$pdf->Cell(0,10,'Email : '.$email,0,1,'L');
$pdf->Cell(0,10,'Contact : '.$contact,0,1,'L');
$pdf->Cell(0,10,'Organisation : '.$organisation,0,1,'L');
$pdf->Cell(0,10,'Designation : '.$designation,0,2,'L');


$pdf->Output();

?>


