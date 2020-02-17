<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
//$_SESSION['ss']="";
$ss="sds";
$user_full_name = "";
$profile_Pics='<img src="Server_Pictures_Print/Server_Pics/defaultpasport.jpg"  style="height:200px;width:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
//$_SESSION['ss']="1A";
//$_SESSION[$_SESSION['ss']] ="";
$choozen_answer ="";
if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_login']))
{
	header("location: exam_logout.php");
}

//this log user out if he refresh the page
if(!isset($_SESSION['All_Log_In']))
{
	header("location: exam_logout.php");
}


	$user_name = $_SESSION['user_name'];
	
	//get the last question from Db
	$stmt = $conn->prepare("SELECT id FROM online_cbt_question ORDER BY id DESC LIMIT 1");
	$stmt->execute();
	$affected_rows = $stmt->rowCount();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$_SESSION['last_question'] = $row['id'];
	//ends here
	
	
	//update user has login so he cant login in other computers again
	$stmt = $conn->prepare("UPDATE online_cbt_user SET Login_Status=? Where Reg_No=? Limit 1");
	$stmt->execute(array('1',$_SESSION['user_name']));
	$affected_rows = $stmt->rowCount();

	//retrieve the users details 
	$stmt = $conn->prepare("SELECT Pic_Ext, Full_Name, Reg_No FROM online_cbt_user where Reg_No=?");
	$stmt->execute(array($_SESSION['user_name']));
	if ($stmt->rowCount () == 1)
	{
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		//mkdir('PRINT/UPLOADS/'.$userfolder,0777);
		$user_full_name = $row['Full_Name'];
		
		if ($row['Pic_Ext'] <> "")
		{
			$user_name =str_replace("/","",$_SESSION['user_name']);
			$user_name = $user_name.$row['Pic_Ext'];
			$profile_Pics='<img src="Server_Pictures_Print/Server_Pics/'.$user_name.'" style="height:200px;width:200px;border:4px solid black;padding:3px"  class="img-responsive img-thumbnail"  ></img>';
		}
	}
	

//set all the session to hold answers here
	$stmt = $conn->prepare("SELECT * FROM online_cbt_question");
	$stmt->execute();
	if ($stmt->rowCount () >= 1)
	{
		$_SESSION['Q_id'] = 1;
		$display_for_move ="";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
		{
			//$_SESSION['Q_id'] = $row['id'];
			//stores the id of the current id of dat element
			$Q_id_Ansa =$row['id']."A";
			
			$JAVA = "onClick="."Mark_choice_question(".$row['id'].")";
			//answer chooz for current question bf question navigate is click
			$_SESSION[$Q_id_Ansa]="O";
			$choozen_answer = $choozen_answer.'<p class="question_ansa" id="'.$Q_id_Ansa.'">'.$_SESSION[$Q_id_Ansa].'</p>';
			
			$display_for_move = $display_for_move."<a ".$JAVA."  href='#' id=".$row['id'].">".$row['id']."</a>";
		
							
		}
		//$display_for_move = $display_for_move.'</p>';
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>

<p id="choic"></p>
<script type="text/javascript" language=Javascript>


	
</script>
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
<script type="text/javascript" src="Exam_Question_next_prev.js"></script>
<script type="text/javascript" src="Exam_Question_Timer.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#myModal").modal('show');		
	});
</script>
<script type="text/javascript">


function call_the_main_convert()
{
	var hrs_S = '<?php  echo $_SESSION['Exam_hours'];?>';
	var mins_S = '<?php echo $_SESSION['Exam_minutes'];?>';
	var secs_S = '<?php echo $_SESSION['Exam_seconds'];?>';
	var  cur = hrs_S + " " + mins_S +  " " + secs_S
	//alert (cur);
	convert_to_seconds_to_continue(hrs_S, mins_S, secs_S);

}

</script>
<style>
#ansa_show > a
{
	height:20px;
	width:20px;
	Padding:5px;
	//background-color:yellow;
	color:yellow;
	float:left;
	margin-left:5px;
	margin-top:5px;
	margin-bottom:5px;
}
</style>
</head>
<body style="padding-top:5%;font-family:Tahoma, Times, serif;font-weight:bold;" onload="call_the_main_convert()" >

<div class="navbar navbar-inverse navbar-fixed-top" style="background-color:green" role="navigation" >
            <div class="navbar-header" style="background-color:grey">
                <div class="container-fluid">
					<a class="navbar-brand" style="font-size:20px;font-weight:bold;color:yellow"  id="countdown" href="#">
					</a>
					
                </div>
			</div>
			<ul class="nav navbar-nav navbar-right" style="background-color:grey">
					<li><a class="navbar-brand" style="font-size:20px;font-weight:bold;color:white" href="#">Pesoka Computers Nigeria Limited Ajaokuta - CBT Exam</a></li>
			</ul>
    </div>

 <div class="nav-overflow"></div>

<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-lg modal-sm modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:grey">
                <button type="button" style="color:RED;font-family:Tahoma, Times, serif;font-size:20px;font-weight:bold" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color:yellow;font-family:Tahoma, Times, serif;font-size:20px;font-weight:bold">Important Notice</h4>
            </div>
            <div class="modal-body" style="background-color:cadetBlue" >
               <p style="color:YELLOW;font-family:Tahoma, Times, serif;font-size:15px;font-weight:bold" >Don't Refresh Or Reload This Page By Any Means As this may Log you Out of the Exam and as well terminate the Exam at that Point.</p>
				<p  style="color:YELLOW;font-family:comic sans ms;font-size:15px;font-weight:bold">Signed By : Management .</p>
                <p class="text-warning"><small style="color:white;font-family:comic sans ms;">Copyright © 2015</small></p>
            </div>
            <div class="modal-footer" style="background-color:grey">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>




<div class="container" style="padding-top:20px;" >
	<!-- middle content starts here where vertical nav slides and news ticker statr -->
		<div class="row">
		<form role="form" name="quizform"  id="frm1" class="form-horizontal"  action="Question_Ajax_Script.php" enctype="multipart/form-data" method="POST">
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
					<p><?php echo $_SESSION['user_name'];?></P>
					<p></P>
					
				</div>
			</div>
				<div  class="col-sm-7 col-md-7 col-lg-7">
					<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<div  class="col-lg-6">
									<button  type="button" name="previous" onclick="Mark_choice('previous')" class="btn btn-success">Previous</button>
									<button  type="button"  name="next" onclick="Mark_choice('next')" class="btn btn-success">Next</button>
									<button  type="button"  name="sule"  onclick="validate_questions();" class="btn btn-success">Submit Exam</button>
						</div>
						<div  id="error1" class="col-lg-4">

						</div>
						<div  class="col-lg-2">
					<p style="color:yellow" ><span id="Q_id2"><?php echo $_SESSION['Q_id'];?></span> Of <span  id="Q_id_total2"><?php echo $_SESSION['last_question'];?></span></p>
						</div>
					</div>
					<div  id="Question_Container"  class="col-sm-12 col-md-12 col-lg-12"  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:CadetBlue;margin-bottom:1%">
						
						<?php
						$stmt = $conn->prepare("SELECT * FROM online_cbt_question where id=?");
						$stmt->execute(array('1'));
						//$row = $stmt->fetch(PDO::FETCH_ASSOC);
						if ($stmt->rowCount () >= 1)
						{
							echo '<table>';
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
							{
								$_SESSION['row_id']=$row['id'];
								$question =htmlspecialchars_decode($row['Cbt_Question']);
								echo '<tr>
											<td style="vertical-align:top;">'.$row['id'].'</td>
											<td width="15px"></td>
											<td>'.$question.'</td>
										</tr>
										<tr>
											<td colspan="2"></td>
											<td>A. <input type="radio" onClick="Mark_choice_current_question()" id="A" name="'.$row['id'].'" value="A" >'."	".$row['Option_1'].'</input></br>
											B. <input type="radio" onClick="Mark_choice_current_question()" id="B" name="'.$row['id'].'" value="B" >'."	".$row['Option_2'].'</input></br>
											C. <input type="radio" onClick="Mark_choice_current_question()" id="C" name="'.$row['id'].'" value="C" >'."	".$row['Option_3'].'</input></br>
											D. <input type="radio" onClick="Mark_choice_current_question()" id="D" name="'.$row['id'].'" value="D" >'."	".$row['Option_4'].'</input></br>
											<input style="visibility:hidden;" id="O" type="radio"  checked="checked" name="'.$row['id'].'" value="O"></input></td>
										</tr>
										<tr>
										<td colspan="3"><input type="hidden" id="hide" name="hide" value="'.$row['id'].'"></input><td>
										<tr>';
							}
							echo '</table>';
						}
						?>
						
					</div>
					
				<div  class="col-lg-12" style="width:100%; padding-top:10px; padding-left:5px; padding-bottom:10px; background-color:grey;margin-bottom:1%">
						<div  class="col-lg-6">
									<button  type="button" name="previous" onclick="Mark_choice('previous')"  class="btn btn-success">Previous</button>
									<button  type="button"  name="next" onclick="Mark_choice('next')"   class="btn btn-success">Next</button>
									<button  type="button"  name="sule"  onclick="validate_questions();"  class="btn btn-success">Submit Exam</button>
						</div>
						<div  id="error" class="col-lg-4">
						</div>
						<div  class="col-lg-2"><p style="color:yellow"><span id="Q_id"><?php echo $_SESSION['Q_id'];?></span> Of <span id="Q_id_total"><?php echo $_SESSION['last_question'];?></span></p><p></div>
					</div>
					
				<!--chooze answers -->
					<div  class="col-lg-12" style="Display:none">
						<?php echo $choozen_answer;?>
						
					</div>
					<div  class="col-lg-12" id="ansa_show" style="width:100%;background-color:CadetBlue;padding-bottom:10px">
						<?php echo $display_for_move;?>
						
					</div>
				</div>		
				
				<div  class="col-sm-1 col-md-1 col-lg-1"></div>
				
				<div class="clearfix visible-sm-block"></div>
				<div class="clearfix visible-md-block"></div>
				<div class="clearfix visible-lg-block"></div>
			</form>
		</div>
		<!-- middle content ends here where vertical nav slides and news ticker ends -->
	
	<?php //unset the session so user can not refresh page
				unset($_SESSION['All_Log_In']); ?>
				
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
<script type="text/javascript">
	//change the color of the first question in navigation
	document.getElementById("1").style.color="black";
</script>
</body>
</html>  
