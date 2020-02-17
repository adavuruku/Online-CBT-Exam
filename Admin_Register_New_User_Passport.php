
<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$_SESSION['passport']=$passport_part = $profile_Pics='<img src="Server_Pictures_Print/Server_Pics/defaultpasport.jpg"  style="height:200px;width:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
$_SESSION['passport_ext'] =$_SESSION['temp_passport_name']=$_SESSION['imgData']=$id_reg_no="";

if(!isset($_SESSION['user_chaange_passport'])){
	if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
	{
		header("location: exam_logout.php");
	}
}

//header("location: Admin_Control_Pannel_Home.php");
if(isset($_SESSION['u_name']) AND isset($_SESSION['outcome']))
{
	unset($_SESSION['u_name']);
	unset($_SESSION['outcome']);
}

//retrieve the user passport if it has before
	$stmt = $conn->prepare("SELECT Pic_Ext, Reg_No FROM online_cbt_user where Reg_No=?");
	$stmt->execute(array($_SESSION['Reg_No_Print']));
	if ($stmt->rowCount () == 1)
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		//mkdir('PRINT/UPLOADS/'.$userfolder,0777);
		
		if ($row['Pic_Ext'] <> "")
		{
			$user_name =str_replace("/","",$_SESSION['Reg_No_Print']);
			$user_name = $user_name.$row['Pic_Ext'];
			$passport_part = $profile_Pics='<img src="Server_Pictures_Print/Server_Pics/'.$user_name.'" style="height:200px;width:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
		}
	}

	//process form submition
	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Submit_odas']))
	{
		
					header("location: Server_Pictures_Print/User_Registration_Print_Slip.php");		
			
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta content="noindex, nofollow" name="robots">
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

<!-- make sure the jquery.min.js comes before jquery.form.js else it wont work-->
<script type="text/javascript" src="INDEX_FILES/js/jquery.min.js"></script>
<script type="text/javascript" src="INDEX_FILES/js/jquery.form.js"></script>
<script type="text/javascript" >
$(document).ready(function()
	{ 
		$('#photoimg').live('change', function()
		{ 
			$("#preview").html('');
			$("#preview").html('<img src="Server_Pictures_Print/images/loader.gif" alt="Uploading...."/>');
			$("#imageform").ajaxForm({target: '#preview'}).submit();
		});
    });	
</script>
</head>
<body style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;" onload="load_year();" >

<div class="navbar navbar-inverse navbar-fixed-top" style="background-color:green" role="navigation" >
            <div class="navbar-header" style="background-color:grey">
                <div class="container-fluid">
					<a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="#">Pesoka Computers Nigeria Limited Ajaokuta - CBT Exam</a>
					
                </div>
			</div>
			<ul class="nav navbar-nav navbar-right" style="background-color:green">
					<li><a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="Admin_Control_Pannel_Home.php">Go to Home Page</a></li>
			</ul>
    </div>

 <div class="nav-overflow"></div>

<div class="container" style="padding-top:20px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			<div  class="col-sm-2 col-md-2 col-lg-2" style="padding-left:20px;" >
				<!-- display user details like passport ..name.. ID ..Class type -->
			</div>
				<div  class="col-sm-8 col-md-8 col-lg-8">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:5px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">	CBT - User Upload Passport</h3>
					</div>
					<form role="form"  name="Login_form"  id="imageform" class="form-horizontal"  action="upload_passport.php" enctype="multipart/form-data" method="POST">
					<div   class="col-sm-12 col-md-12 col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:CadetBlue;color:yellow;margin-bottom:1%">
						

						<form role="form"  name="Login_form"  id="imageform" class="form-horizontal"  action="upload_passport.php" enctype="multipart/form-data" method="POST">
					
							<!-- Progress Bar -->
							<!-- Fieldsets -->
							<fieldset class="second">
								<h2  style="text-align:center;font-family: 'Droid Serif', serif;" class="title">Upload Passport</h3>
								
								<p class="subtitle" style="color:black;text-align:center;font-family: 'Droid Serif', serif;" >Height and Width not more than 350 and 450, size 200Kb</p>
								<div  class="col-lg-4" >
								</div>
								<div  class="col-lg-6">
									<div  class="col-lg-12" id="preview">
									<!-- image here -->
										<?php echo $passport_part; ?>
									</div>	
									<div  class="col-lg-12">
									<br>
											<input  type="file" style="width:30%;"  id="photoimg" value="browse" name="uploaded"  ></input>
									
										
									</div>	
											
								</div>
								<div  class="col-lg-2" style="align:right;">
								</div>								
							</fieldset>
							</form>
							
							
				</div>		
				<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:5px; background-color:grey;margin-bottom:1%">
						<!-- for passport-->
							<form role="form"  name="reg_form"  id="form" class="form-horizontal"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
								<div  class="col-lg-5" style="align:left;">
								</div>
								<div  class="col-lg-6" style="align:right;">
											
											<input  type="Submit" style="width:30%;" class="submit_btn btn btn-success"  value="Proceed >>" name="Submit_odas"  ></input>
								</div>
								<div  class="col-lg-1" style="align:left;">
								</div>
								</form>
					</div>
				<div  class="col-sm-1 col-md-1 col-lg-1"></div>
				
				<div class="clearfix visible-sm-block"></div>
				<div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>
		</div>
		</div>
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
	
		<div class="row">
			<div class="col-xs-2 col-sm-2"></div>	
				<div class="col-xs-8 col-sm-8" >
					<footer>
						<p style="text-align:center">Copyright &copy; 2015 - All Rights Reserved - Software Development Unit, P C N L.</p>
					</footer>
				</div>
			<div class="col-xs-2 col-sm-2"></div>	
		</div>	
</div>	
</body>
</html>  
