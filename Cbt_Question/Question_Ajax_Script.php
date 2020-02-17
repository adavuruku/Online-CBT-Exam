<?php
session_start(); 
require_once 'settings/connection.php';
require_once 'settings/filter.php';
$_SESSION['ss']="1A";
//give all the initial answers
if(!isset($_SESSION['user_name']) AND !isset($_SESSION['user_login']))
{
	header("location: exam_logout.php");
}






//submitting of the form
$Answer_score=$P=$R =0;

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	//user click submit eida at the first or the last question
	$hide= $_POST['hide'];
	//stores the id of the current id of dat element
	$Q_id_Ansa =$hide."A";
	//answer chooz for current question bf question navigate is click
	$_SESSION[$Q_id_Ansa]=$_POST[$hide];
	
	
	$stmt = $conn->prepare("SELECT * FROM online_cbt_question");
	$stmt->execute();
	//$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$P = $stmt->rowCount ();
	
	for ($x=1; $x<=$P; $x++)
	{
		$y = $x."A";
		$R = $_SESSION[$y];
		//echo $R;
		//clear the session of its data
		unset($_SESSION[$y]);
		
		//RETRIEVE THE QUESTION TO MARK
		$stmt = $conn->prepare("SELECT id, Cbt_Answer FROM online_cbt_question where id=?");
		$stmt->execute(array($x));
		if ($stmt->rowCount () == 1)
		{
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($R == $row['Cbt_Answer'])
			{
				$Answer_score = $Answer_score + 1;
			}
		}
	} 
		
		//calc percent
		$percentage_score = (100 * $Answer_score)/$P;
		
		
		echo $Answer_score;
		echo $percentage_score." %";
		
		$_SESSION['movin_nxtpagee'] = $_SESSION['user_name'];
		$_SESSION['movin_result_nxtpagee'] = "yes";
		$_SESSION['score_result_no'] = $Answer_score;
		$_SESSION['percent_result_score'] = $percentage_score." %";
		
		unset($_SESSION['user_login']);
		unset($_SESSION['user_name']);
		
		//unset this session to it wont interfere with reprint page ...check Exam_user_reprint_Result.php page
		//and Exam_Result_View.php page so u can understand
		if(isset($_SESSION['reprint']))
		{
			unset($_SESSION['reprint']);
		}
		header("location: Exam_Result_View.php?id=".$_SESSION['movin_nxtpagee']);
}

//take former answer
/*if(isset($_GET['new_id']))
{
	$Q_id = $_GET['new_id']."A";
	echo $_SESSION[$Q_id];
	//echo $_GET['new_id'];
}*/


//Ajax process for question change
if(isset($_GET['Q_id']))
{
	//current id of the next or previous question
	$Q_id = $_GET['Q_id'];
	
	
	//stores the id of the current id of dat element
	$Q_id_Ansa = $_GET['current_id']."A";
	//answer chooz for current question bf question navigate is click
	$_SESSION[$Q_id_Ansa]=$_GET['answer_chooz'];
	
	$stmt = $conn->prepare("SELECT * FROM online_cbt_question where id=?");
	$stmt->execute(array($Q_id));
	//$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($stmt->rowCount () >= 1)
	{
		echo '<table>';
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
		{
				$question =htmlspecialchars_decode($row['Cbt_Question']);
				echo	'<tr>
							<td style="vertical-align:top;">'.$row['id'].'</td>
							<td width="15px"></td>
							<td>'.$question.'</td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td>A. <input type="radio" id="A" name="'.$row['id'].'" value="A" >'."	".$row['Option_1'].'</input></br>
							B. <input type="radio" id="B" name="'.$row['id'].'" value="B" >'."	".$row['Option_2'].'</input></br>
							C. <input type="radio" id="C" name="'.$row['id'].'" value="C" >'."	".$row['Option_3'].'</input></br>
							D. <input type="radio" id="D" name="'.$row['id'].'" value="D" >'."	".$row['Option_4'].'</input></br>
							<input style="visibility:hidden;" type="radio"  checked="checked" name="'.$row['id'].'" value="O"></input></td>
						</tr>
						<tr>
							<td colspan="3"><input type="hidden" id="hide" name="hide" value="'.$row['id'].'"></input><td>
						<tr>';
		}
		echo '</table>';
	}
}
?>