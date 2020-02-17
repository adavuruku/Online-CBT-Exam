<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$Answer_score=$P=$R =0;
$user_full_name =$dateprint=$total_score=$total_percent= "";
$profile_Pics='<img src="Server_Pictures_Print/Server_Pics/defaultpasport.jpg"  style="height:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';

if(!isset($_SESSION['movin_nxtpagee']) AND !isset($_SESSION['movin_result_nxtpagee']))
{
	header("location: exam_logout.php");
}

//if one change the reg number in d browser address.. looool funny
//when some bush elements wants to trick the code to c oda users result
if(!isset($_GET['id']))
{
	header("location: exam_logout.php");
}else{
	if($_GET['id'] <> $_SESSION['movin_nxtpagee']){
		
		header("location: exam_logout.php");
	}
}

	$user_name = $_SESSION['movin_nxtpagee'];
	
	
	//date exam is done
	$date500 = new DateTime("Now");
	$J = date_format($date500,"D");
	$Q = date_format($date500,"d-F-Y, h:i:s A");
	$dateprint = $J.", ".$Q;
	
	//make sure is not reprintintin this session is from reprinting page not question page
	//only enter here if one is not coming through the re print page
	if(!isset($_SESSION['reprint']))
	{
		$date500 = new DateTime("Now");
		//update user has log out and finish exam with his new scores nd percentage
		//so he can login in other computers again but cant rewrite exam 
		$stmt = $conn->prepare("UPDATE online_cbt_user SET Login_Status=?,Exam_Status=?,Score=?,Percentage=?,Date_Of_Exam=now() Where Reg_No=? Limit 1");
		$stmt->execute(array('0','1',$_SESSION['score_result_no'],$_SESSION['percent_result_score'],$user_name));
		$affected_rows = $stmt->rowCount();
	}

	
	//retrieve the users details 
	$stmt = $conn->prepare("SELECT Pic_Ext, Full_Name, Reg_No, Score, Percentage FROM online_cbt_user where Reg_No=?");
	$stmt->execute(array($user_name));
	if ($stmt->rowCount () == 1)
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		//mkdir('PRINT/UPLOADS/'.$userfolder,0777);
		$user_full_name = $row['Full_Name'];
		$total_score=$row['Score'];
		$total_percent = $row['Percentage'];
		if ($row['Pic_Ext'] <> "")
		{
			$user_name =str_replace("/","",$_SESSION['movin_nxtpagee']);
			$user_name = $user_name.$row['Pic_Ext'];
			$profile_Pics='<img src="Server_Pictures_Print/Server_Pics/'.$user_name.'" style="height:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
		}
	}
	
	
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit']))
{
	header("location: Server_Pictures_Print/Exam_Resul_Slip_In_PDF.php");
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Pesoka Computers Nigeria Limited - Ajaokuta Nigeria</title>
<link rel="shortcut icon" href="Server_Pictures_Print/images/image_demo.jpg">
<link rel="stylesheet" type="text/css" href="INDEX_FILES/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="INDEX_FILES/css/bootstrap-theme.min.css">
<link rel="stylesheet" type="text/css" href="INDEX_FILES/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="INDEX_FILES/css/bootstrap-theme.css" >
<script type="text/javascript" src="INDEX_FILES/js/bootstrap.js"></script>
<script type="text/javascript" src="INDEX_FILES/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="INDEX_FILES/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="INDEX_FILES/js/bootstrap.min.js"></script>
<script type="text/javascript" src="INDEX_FILES/js/bootstrap.min.js"></script>
<script type="text/javascript">
function validate()
{
	var r=confirm("Are You sure You want to Submit the Exam ..you stil have some time left");
	if (r==true)
	  {
		return true;
        exit;
	  }
	  else
	  {
		return false;
        exit;
	  }
}


	var max_time = 5;
    var cinterval;
     
    function countdown_timer()
	{
    		// decrease timer
    		max_time --;
    		document.getElementById('countdown').innerHTML = max_time;
    	if(max_time == 0)
		{
    		clearInterval(cinterval);
			//document.getElementById("frm1").submit();
    	}
    }
    // 1,000 means 1 second.
    cinterval = setInterval('countdown_timer()', 1000);


</script>
</head>
<body style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;">

<div class="navbar navbar-inverse navbar-fixed-top" style="background-color:green" role="navigation" >
            <div class="navbar-header" style="background-color:grey">
                <div class="container-fluid">
					<a class="navbar-brand" style="font-size:20px;font-weight:bold;color:yellow"  href="exam_logout.php">Sign Out</a>
					
                </div>
			</div>
			<ul class="nav navbar-nav navbar-right" style="background-color:grey">
					<li><a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="#">Pesoka Computers Nigeria Limited Ajaokuta - CBT Exam</a></li>
			</ul>
    </div>

 <div class="nav-overflow"></div>



<div class="container">
	
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
				<form role="form" name="quizform"  id="frm1" class="form-horizontal"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
			
			<div  class="col-sm-3 col-md-3 col-lg-3" style="padding-left:20px;background-color:CadetBlue;padding-top:20px;" >
				<!-- display user details like passport ..name.. ID ..Class type -->
				<div  class="col-sm-12 col-md-12 col-lg-12">
					<!-- Passport -->
					<?php echo $profile_Pics;?>
				</div>
				<div  class="col-sm-12 col-md-12 col-lg-12">
					<p></P>
					<p></P>
					<p><?php echo $user_full_name;?></P>
					<p></P>
					<p><?php echo $_SESSION['movin_nxtpagee'];?></P>
					<p></P>
				</div>
			</div>
					
			<div  class="col-sm-8 col-md-8 col-lg-8">
				<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								<div  class="col-lg-11">
											<h4 style="color:white; text-align:center;">Pesoka Computers Training Institute Ajaokuta - CBT Exam Result Slip </h4>
								</div>
								<div  class="col-lg-1"></div>
				</div>
				
				
				<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:10px; padding-bottom:10px; background-color:CadetBlue;margin-bottom:1%">
										
						<table>
							<tr>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td align="right">Student Name : </td>
								<td width="10%"> </td>
								<td><?php echo $user_full_name;?></td>
							</tr>
							<tr>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td align="right">Registration N<u>o</u> : </td>
								<td> </td>
								<td><?php echo $_SESSION['movin_nxtpagee'];?></td>
							</tr>
							<tr>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td align="right">Total Score : </td>
								<td width="10%"> </td>
								<td><?php echo $total_score;?></td>
							</tr>
							<tr>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td align="right">Percentage Score : </td>
								<td> </td>
								<td><?php echo $total_percent;?></td>
							</tr>
							<tr>
								<td colspan="3"></td>
							</tr>
							<tr>
								<td align="right" >Date & Time : </td>
								<td> </td>
								<td><?php echo $dateprint; ?></td>
							</tr>
						</table>
				</div>	
							
				<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								<div  class="col-lg-10">
											<button  type="submit"  name="submit"  class="btn btn-success">Download in (PDF) And Print</button>
								</div>
								<div  class="col-lg-2"></div>
							</form>
				</div>
					
			</div>			
			<div  class="col-sm-1 col-md-1 col-lg-1"></div>
						
						<div class="clearfix visible-sm-block"></div>
						<div class="clearfix visible-md-block"></div>
						<div class="clearfix visible-lg-block"></div>
					
		
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
		
		<div class="row">
			<div class="col-xs-3 col-sm-3"></div>	
				<div class="col-xs-7 col-sm-7" >
					<footer>
						<p style="text-align:center">Copyright &copy; 2015 - All Rights Reserved - Software Development Unit, P C N L.</p>
					</footer>
				</div>
			<div class="col-xs-2 col-sm-2"></div>	
		</div>	
</div>	
</body>
</html>  
