<?php
require_once('tcpdf_include.php');
session_start();
require_once 'connection.php';
require_once 'filter.php';
require_once 'site_root_config.php';
$root = my_site_root();
$user_name = $profile_Pics =$total_score=$user_full_name=$total_percent=$date_of_exam =$dateprint = "";


if (!isset($_SESSION['cmbexamschedule']))
{
	header("location: ".$root."exam_logout.php");
}
$user_full_name = "Exam_Result_For_".$_SESSION['cmbexamschedule']."_Class_".$_SESSION['cmbyear'];
		$date500 = new DateTime("Now");
		$J = date_format($date500,"D");
		$Q = date_format($date500,"d-F-Y, h:i:s A");
		$dateprint = "Printed On: ".$J.", ".$Q;	

		
// create new PDF document

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF 
{
	// Page footer
		public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('dejavusans', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Pesoka Computers Nigeria Limited - CBT Exam Result Slip - 2015', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
		//getAliasNumPage() from the immediate line mean the current page
		//getAliasNbPages() from the immediate line mean the total number of pages
		//remember you can remove them and put a common string there
	}
}



$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Abdulraheem Sherif A');
$pdf->SetTitle('Pesoka Computers Nig Ltd');
$pdf->SetSubject('Exam Result Slip');

$pdf->SetKeywords('Pesoka, Computers, Nigeia, Limited, Ajaokuta');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// to remove default header use this
$pdf->setPrintHeader(false);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();
// set alpha to semi-transparency


$html = '<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr >
        <td rowspan="4" width="90"><img src="images/image_demo.jpg" width="200" height="200"/></td>
        <td width="460"></td>
        <td rowspan="4" width="90"></td>
    </tr>
    <tr >
        <td  align="center" style="font-size:15;font-weight:bold;color:blue" >PESOKA COMPUTERS NIGERIA LIMITED</td>
    </tr>
    <tr >
    	 <td align="center" style="font-size:11;font-weight:bold">P.M.B	1037 KADUNA ESTATE AJAOKUTA KOGI STATE NIGERIA</td>
    </tr>
    <tr>
       <td align="center"  style="font-size:10;font-weight:bold;color:black">C B T Exam Result Slip</td>
    </tr>

</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// -----------------------PERSONALINFORMATION HEADER TABLE----------------------------------

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:10;font-weight:bold;color:brown">'.$user_full_name.'</td>
        <td  align="Right" style="font-size:9;">'.$dateprint.'</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');

// -----------PERSONALINFORMATION DETAILS TABLE----------------------------------------------
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'image_demo.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);

$html1 ="";
$stmt = $conn->prepare("SELECT id, Full_Name, Reg_No, Score,Percentage,Date_Of_Exam,Year_Reg,Class_Schedule,Exam_Status FROM online_cbt_user where Exam_Status=? AND Year_Reg=? AND Class_Schedule=? ");
$stmt->execute(array('1',$_SESSION['cmbyear'],$_SESSION['cmbexamschedule']));
if ($stmt->rowCount () >= 1)
{
	 $html1 .= '<tr width="400">
			<td width="30">N<u>o</u></td>
			<td width="200">Student Name </td>
			<td width="150">Regestration N<u>o</u></td>
			<td width="50">Score</td>
			<td >Percent (%)</td>
			<td >Date Of Exam</td>
		</tr>';
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
		{
			$id = $row['id'];
			$Full_Name = $row['Full_Name'];
			$Reg_No = $row['Reg_No'];
			$Score = $row['Score'];
			$Percentage = $row['Percentage'];
			$Date_Of_Exam = $row['Date_Of_Exam'];
			
			$html1 .= '<tr width="400" >
							<td>'.$id.'</td>
							<td>'.$Full_Name.'</td>
							<td>'.$Reg_No.'</td>
							<td>'.$Score.'</td>
							<td>'.$Percentage.'</td>
							<td>'.$Date_Of_Exam.'</td>
						</tr>
						<tr width="400">
							<td align="Center" colspan ="6" style="font-size:8;"><hr></td>
						</tr>';
		}
		$html  = '<table border="1" cellpadding="1">'.$html1.'</table>';
		// output the HTML content
		$pdf->writeHTML($html, true, false, false, false, '');
}

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;"><td></td>
    </tr>
</table>
<hr>
<p style="text-align:center">Copyright &copy; 2015 - All Rights Reserved - Software Development Unit, P C N L.</p>
<hr>';

$pdf->writeHTML($html, true, false, false, false, '');


$pdf->Output($user_full_name.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

