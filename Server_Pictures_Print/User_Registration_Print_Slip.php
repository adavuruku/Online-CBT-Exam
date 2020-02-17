<?php
require_once('tcpdf_include.php');
session_start();
require_once 'connection.php';
require_once 'filter.php';
require_once 'site_root_config.php';
$root = my_site_root();
$profile_Pics = "Server_Pics/defaultpasport.jpg";

$profile_Pics=$user_full_name =$Gender = $P_Phone =$G_Name=$G_Phone = $G_Addres=$Duration_Training =$P_Addres = $Class_Schedule=$U_Date_Of_Reg=$check_2="";


if (!isset($_SESSION['Reg_No_Print']))
{
	header("location: ".$root."exam_logout.php");
}


	$user_name_display = $user_name =$_SESSION['Reg_No_Print'];
	
	$stmt = $conn->prepare("SELECT Full_Name,Gender, P_Phone, P_Addres,G_Name,G_Phone, G_Addres, Reg_No,Duration_Training,Class_Schedule,U_Date_Of_Reg,Pic_Ext,Course_Register FROM online_cbt_user where Reg_No=?");
	$stmt->execute(array($user_name));
	if ($stmt->rowCount () == 1)
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		//mkdir('PRINT/UPLOADS/'.$userfolder,0777);
		$user_full_name = $row['Full_Name'];
		$Gender = $row['Gender'];
		$P_Phone = $row['P_Phone'];
		$P_Addres = $row['P_Addres'];
		
		$G_Name = $row['G_Name'];
		$G_Phone = $row['G_Phone'];
		$G_Addres = $row['G_Addres'];
		
		$Duration_Training = $row['Duration_Training'];
		$Class_Schedule = $row['Class_Schedule'];
		$U_Date_Of_Reg = $row['U_Date_Of_Reg'];
		$Course_Register = explode("," ,$row['Course_Register']);
		$p = 1;
		foreach ($Course_Register as $check){
			$check_2 = $check_2.'<p>'.$p.'.  '.$check.'</p>';
			$p = $p + 1;
		}

		if ($row['Pic_Ext'] <> "")
		{
			$user_name =str_replace("/","",$_SESSION['Reg_No_Print']);
			$user_name = $user_name.$row['Pic_Ext'];
			$profile_Pics = "Server_Pics/".$user_name;
		}
	}
					
		
		
		$date500 = new DateTime("Now");
		$J = date_format($date500,"D");
		$Q = date_format($date500,"d-F-Y, h:i:s A");
		$dateprint = "Printed On: ".$J.", ".$Q;	
					
//unset($_SESSION['Reg_No_Print']);
// create new PDF document

// Extend the TCPDF class to create custom Header and Footer
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
		$this->Cell(0, 10, 'Pesoka Computers Nigeria Limited - CBT Exam Registration Slip - 2015', 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
        <td rowspan="5" width="90"><img src="images/image_demo.jpg" width="200" height="200"/></td>
        <td width="460"></td>
        <td rowspan="5" width="90"><img width="100" height="100" border="0" src="'.$profile_Pics.'"/></td>
    </tr>
    <tr >
        <td  align="center" style="font-size:15;font-weight:bold;color:blue" >PESOKA COMPUTERS NIGERIA LIMITED</td>
    </tr>
    <tr >
    	 <td align="center" style="font-size:11;font-weight:bold">P.M.B	1037 KADUNA ESTATE AJAOKUTA KOGI STATE NIGERIA</td>
    </tr>
    <tr>
       <td align="center"  style="font-size:10;font-weight:bold;color:black">C B T Registration Slip</td>
    </tr>

</table>';
$pdf->writeHTML($html, true, false, true, false, '');


// -----------------------PERSONALINFORMATION HEADER TABLE----------------------------------

$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:10;font-weight:bold;color:brown">PERSONAL INFORMATION</td>
        <td  align="Right" style="font-size:9;">'.$dateprint.'</td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');

// -----------PERSONALINFORMATION DETAILS TABLE----------------------------------------------
$pdf->SetAlpha(0.3);
$img_file = K_PATH_IMAGES.'image_demo.jpg';
$pdf->Image($img_file, 55, 85, 100, 100, '', '', '', false, 300, '', false, false, 0);
$pdf->SetAlpha(1);

$html = '<table cellspacing="0" cellpadding="1" border="0" style="font-size:8;color:black" align="center" >
	<tr width="400">
        <td align="Center" colspan ="4" style="font-size:8;"></td>
    </tr>
	<tr width="400"> 
        <td align="Right"  style="font-size:8;">Applicant Name :</td>
		
		<td align="Left"  style="font-size:8;">'.$user_full_name.'</td>
		<td align="Right"  style="font-size:8;">Phone Number :</td>
			<td align="Left"  style="font-size:8;">'.$P_Phone.'</td>
    </tr>
	<tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400"> 
        <td align="Right"  style="font-size:8;">Gender :</td>
		
		<td align="Left"  style="font-size:8;">'.$Gender.'</td>
		<td align="Right"  style="font-size:8;">Home Address :</td>
		<td align="Left"  style="font-size:8;">'.$P_Addres.'</td>
    </tr>
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
  </table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



//NOTICE
// -----------Guardian details TABLE----------------------------------------------
$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:10;font-weight:bold;color:brown">GUARDIAN INFORMATION</td>
        <td  align="Right" style="font-size:9;"></td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');

$html = '<table cellspacing="0" cellpadding="1" border="0" style="font-size:8;color:black" align="center" >
	<tr width="400">
        <td align="Center" colspan ="4" style="font-size:8;"></td>
    </tr>
	<tr width="400"> 
        <td align="Right"  style="font-size:8;">Guardian Name :</td>
		
		<td align="Left"  style="font-size:8;">'.$G_Name.'</td>
		<td align="Right"  style="font-size:8;">Phone Number :</td>
			<td align="Left"  style="font-size:8;">'.$G_Phone.'</td>
    </tr>
	<tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400"> 
        <td align="Right"  style="font-size:8;">Home Address :</td>
		
		<td align="Left"  style="font-size:8;">'.$G_Addres.'</td>
		<td align="Right"  style="font-size:8;"></td>
		<td align="Left"  style="font-size:8;"></td>
    </tr>
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
  </table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


//NOTICE
// -----------Education details TABLE----------------------------------------------
$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:10;font-weight:bold;color:brown">REGISTRATION INFORMATION</td>
        <td  align="Right" style="font-size:9;"></td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');
$html = '<table cellspacing="0" cellpadding="1" border="0" style="font-size:8;color:black" align="center" >
	<tr width="400">
        <td align="Center" colspan ="4" style="font-size:8;"></td>
    </tr>
	<tr width="400"> 
        <td align="Right"   style="font-size:8;">Registration N<u>o</u> :</td>
		<td align="Left"   style="font-size:8;">'.$user_name_display.'</td>
		<td align="Right"  style="font-size:8;">Class_Schedule :</td>
		<td align="Left"  style="font-size:8;">'.$Class_Schedule.'</td>
    </tr>
	<tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
	<tr width="400"> 
        <td align="Right"  style="font-size:8;">Duration Of Training :</td>
		<td align="Left"  style="font-size:8;">'.$Duration_Training.'</td>
		<td align="Right"  style="font-size:8;">Registration_Date :</td>
		<td align="Left"  style="font-size:8;">'.$U_Date_Of_Reg.'</td>
    </tr>
	
    <tr width="400">
        <td align="Center" colspan ="3" style="font-size:8;"></td>
    </tr>
  </table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// -----------Education details TABLE----------------------------------------------
$html ='<table cellspacing="0" cellpadding="1" border="0" align="center">
    <tr style="bottom-border:1 solid;">
        <td align="Left" style="font-size:10;font-weight:bold;color:brown">LIST OF COURSES REGISTERED</td>
        <td  align="Right" style="font-size:9;"></td> 
    </tr>
</table><hr>';

$pdf->writeHTML($html, true, false, false, false, '');
$html = '<table cellspacing="0" cellpadding="1" border="0" style="font-size:8;color:black" align="center" >
	<tr width="400">
        <td align="Center" colspan ="4" style="font-size:8;"></td>
    </tr>
	<tr width="400">
        <td align="left" colspan ="4" style="font-size:8;">'.$check_2.'</td>
    </tr>
  </table>';
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



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

