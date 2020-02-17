<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$mail_error=$question =$option1 = $option2 = $option3 = $option4 = $Answer ="";
if($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['save'])))
{
	$mail_error="";

	
	$question = checkempty($_POST['body']);
	$option1 = checkempty($_POST['option4']);
	$option2 = checkempty($_POST['option4']);
	$option3 = checkempty($_POST['option4']);
	$option4 = checkempty($_POST['option4']);
	$Answer = checkempty($_POST['Answer']);

	if(($question != FALSE) && ($option1 != FALSE)&& ($option2 != FALSE)&& ($option3 != FALSE) && ($option4 != FALSE)&& ($Answer != FALSE))
	{
		
		
		$question = htmlentities(trim($_POST['body']));
		$option1 = htmlentities(trim($_POST['option1']));
		$option2 = htmlentities(trim($_POST['option2']));
		$option3 = htmlentities(trim($_POST['option3']));
		$option4 = htmlentities(trim($_POST['option4']));
		$Answer = htmlentities(trim($_POST['Answer']));
		
		global $conn;
			$sth = $conn->prepare ("INSERT INTO online_cbt_question (Cbt_Question,Option_1,Option_2,Option_3,
					Option_4,Cbt_Answer)
																	VALUES (?,?,?,?,?,?)");															
					$sth->bindValue (1, $question); 
					$sth->bindValue (2, $option1);  
					$sth->bindValue (3, $option2); 
					$sth->bindValue (4, $option3); 
					$sth->bindValue (5, $option4); 
					$sth->bindValue (6, $Answer); 
					$sth->execute();
					$affected_rows = $sth->rowCount();
					$mail_error='<p style="color:red">Success :New Question Saved Successfully ...</p>';
		
	}
	else
	{
		$mail_error='<p style="color:red">Error :Unable to Save ...Some field Are Left Empty ..Verify</p>';
		//$mail_error="i entered here".$countval.$mail_subject.$mail_body;
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Ahmadu Bello University - Zaria Nigeria</title>
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
 <script type="text/javascript" src="CK EDITOR/ckeditor.js"></script>

	
</head>
<body style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;">

<div class="navbar navbar-inverse navbar-fixed-top" style="background-color:green" role="navigation" >
            <div class="navbar-header" style="background-color:grey">
                <div class="container-fluid">
					<a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="#">Pesoka Computers Nigeria Limited Ajaokuta - CBT Exam</a>
					
                </div>
			</div>
			<ul class="nav navbar-nav navbar-right" style="background-color:green">
					<li><a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="Admin_Control_Pannel_Home.php">Go to Admin Home Page</a></li>
			</ul>
    </div>

 <div class="nav-overflow"></div>
 
 <div class="container">
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
	<div class="row">
		<form role="form" name="mailform"   class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" method="POST">
		
		<div  class="col-sm-3 col-md-3 col-lg-3" style="padding-left:20px;" >
			</div>
					
			<div  class="col-sm-7 col-md-7 col-lg-7">
			
			<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
													<h3 style="text-align:center;padding-top:5px; padding-bottom:5px;color:yellow" >Admin Add More - Exam Question</h3>
						</div>	
						
			<div  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:10px; padding-bottom:5px; background-color:CadetBlue;margin-bottom:1%">
								
								
								<div class="form-group" >
									<div class="col-xs-12">
									<label>Enter The Question :<span style="color:red" class"require">*</span></label>
									</div>
									<div class="col-xs-12">
										
											<textarea  rows="5" class="form-control"  id="body" name="body" value="sherif">
													
													<?php echo $question;?>
											</textarea>
											
											 
										</div>
									</div>
									
										<div class="form-group">
														<label for="option1" class="control-label col-xs-4">Enter The First Option :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-8">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
																<input type="text" name="option1" class="form-control" id="option1" placeholder="Enter the Option 1" value="<?php echo $option1;?>"></input>
															</div>
														</div>
										</div>
										<br>
										<div class="form-group">
														<label for="option2" class="control-label col-xs-4">Enter The Second Option :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-8">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
																<input type="text" name="option2" class="form-control" id="option2" placeholder="Enter the Option 2" value="<?php echo $option2;?>"></input>
															</div>
														</div>
										</div>
										<br>
										
										<div class="form-group">
														<label for="option3" class="control-label col-xs-4">Enter The Third Option :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-8">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
																<input type="text" name="option3" class="form-control" id="option3" placeholder="Enter the Option 3" value="<?php echo $option3;?>"></input>
															</div>
														</div>
										</div>
										<br>
										<div class="form-group">
														<label for="option4" class="control-label col-xs-4">Enter The Fourth Option :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-8">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
																<input type="text" name="option4" class="form-control" id="option4" placeholder="Enter the Option 4" value="<?php echo $option4;?>"></input>
															</div>
														</div>
										</div>
										<br>
										
										<div class="form-group">
														<label for="Answer" class="control-label col-xs-4">Enter The Answer to Options :<span style="color:red" class"require">*</span></label>
														<div class="col-xs-8">
															<div class="input-group">
																<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
																<input type="text" name="Answer" class="form-control" id="Answer" placeholder="Enter the Answer"value="<?php echo $Answer;?>"></input>
															</div>
														</div>
										</div>
									</div>						
				
							
						<div  class="col-lg-12" style=" padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
								<div  class="col-lg-7" >
													<button  type="submit"  name="save" class="btn btn-success">Save New question</button>
										</div>
										<div  class="col-lg-5" style="align:left;">
											<?php echo $mail_error; ?>
										</div>
										
									</form>
						</div>	
					</div>
				<div  class="col-sm-2 col-md-2 col-lg-2"></div>
						
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
