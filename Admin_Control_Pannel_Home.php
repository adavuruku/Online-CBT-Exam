
<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';

if(!isset($_SESSION['Admin_user_name']) AND !isset($_SESSION['Admin_user_full_name']))
{
	header("location: exam_logout.php");
}

if(isset($_SESSION['u_name']) AND isset($_SESSION['outcome']))
{
	unset($_SESSION['u_name']);
	unset($_SESSION['outcome']);
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
<script type="text/javascript" src="Question_Ajax.js"></script>
<script type="text/javascript">



</script>
</head>
<body style="padding-top:2%;font-family:Tahoma, Times, serif;font-weight:bold;">


<div class="container" style="padding-top:5px;">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		
			<div  class="col-sm-2 col-md-2 col-lg-2"  >
				<!-- display user details like passport ..name.. ID ..Class type -->
			</div>
				<div  class="col-sm-8 col-md-8 col-lg-8">
					<div  class="col-lg-12" style="width:100%; padding-top:5px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<h3 style="text-align:center;color:white">Pesoka Computer Nigeria Limited CBT Exam Home Platform</h3>
						<h5 style="text-align:center;color:yellow">Welcome	-	Administrator <?php echo $_SESSION['Admin_user_full_name'];?> - <a style="color:white" href="exam_logout.php">Log Out</a></h5>
					</div>
					<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:0px; padding-bottom:5px; background-color:CadetBlue;margin-bottom:1%">
						<div  class="col-sm-6 col-md-6 col-lg-6">
						<div class="nav-head"><h4>PCNL CBT Admin Control Pannel</h4></div>
							<div class="list-group show" style="margin-bottom:80px">
								<a href="#" class="list-group-item"> </a>
								<a href="Admin_Register_New_User.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Register Student </a>
								<a href="#" class="list-group-item"> </a>
								<a href="Upload_Question.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Add New Question </a>
								<a href="#" class="list-group-item"> </a>
								<a href="Admin_Set_Exam_Properties.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Choose Exam Type And Set Exam Duration</a>
								<a href="#" class="list-group-item"> </a>
							</div>
						</div>
						<div  class="col-sm-6 col-md-6 col-lg-6">
							<div class="nav-head"><h4>PCNL CBT Admin Manage Database</h4></div>
							<div class="list-group show" style="margin-bottom:80px">
								<a href="#" class="list-group-item"> </a>
								<a href="Admin_Print_Exam_Result_PDF.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Print Exam Result Report(PDF)</a>
								<a href="#" class="list-group-item"> </a>
								<a href="Admin_Print_Exam_Result_Excel.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Download Exam Result Report(Excel)</a>
								<a href="#" class="list-group-item"> </a>								
								<a href="Admin_Authorize_user.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Help User To Log Out </a>
								<a href="#" class="list-group-item"> </a>
								<a href="Admin_Authorize_user.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Authorize User To Re-Write Exam</a>
								<a href="#" class="list-group-item"> </a>
								<a href="Admin_Authorize_Group_user.php" class="list-group-item"><span class="glyphicon glyphicon-plus glysize"></span> Authorize (Group) To Re-Write Exam / Log Out</a>
								<a href="#" class="list-group-item"> </a>								
							</div>
						</div>
						
					</div>
					
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						
					</div>
				</div>		
				
				<div  class="col-sm-2 col-md-2 col-lg-2"></div>
				
				<div class="clearfix visible-sm-block"></div>
				<div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>
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
