
var question_remain_message="";
var quest_details="";
function validate()
{
		question_remain_message="";
		quest_details="";
		var last_question = document.getElementById('all_question').innerHTML;
		last_question = new Number(last_question);
		var Question_not_ansa = 0;
		for (var i=1; i<=last_question; i++)
		{
			var  p_ansa_id = i + "O";
			if (document.getElementById(p_ansa_id).checked==true)
			{
				Question_not_ansa = Question_not_ansa + 1;
				quest_details = quest_details  + i + ", ";
			}
		}
		//alert ("you have not answer = " + Question_not_ansa);
		if (Question_not_ansa > 0){
			question_remain_message ="And You Have Not ANSWER " + Question_not_ansa + " Question's - which are \n Question : " + quest_details;
		}else{
			question_remain_message="";
		}

		var r=confirm("Are You sure You want to Submit the Exam ... \nYou still have Some Time Left " + question_remain_message+ "\n\nClick OK to Submit \nor \nClick CANCEL to Continue with the Exam");
		if (r==true)
		  {
			document.forms["quizform"].submit();
		  }
		  else
		  {
			return false;
		  }
}

//for exam question 2 navigator
function Mark_the_Question(visited){

	var vis =  visited + "P";
	document.getElementById(vis).style.color="black";
}



/*###############################################################################################
#									JAVASCRIPT FOR COUNTDOWN TIMER - BY SHERIF					#
###############################################################################################*/            
		function countdown_clock(Total_seconds, hrs, mins, secs)
        {		
			var	Exam_Hrs =  new Number(hrs);
			var	Exam_Min = new Number(mins);
			var	Exam_Secs = new Number(secs);
			var where_status = "from count down time";
			if(Total_seconds > 0)
			{
					Total_seconds = new Number(Total_seconds) - 1;
			}else{ 
				document.forms["quizform"].submit();
				exit;
			}
			
			
			
			//dis ends here
			
			//give alert warning user on time about to end
				if(Total_seconds == 59)
				{
					alert("Start Rounding up your Exam, you have less than 1 (One) Minute Left");
				}
				if(Total_seconds == 29)
				{
					alert("Start Rounding up your Exam, you have less than 30 (Thirty) Seconds Left");
				}
				
				if(Total_seconds == 9)
				{
					alert("Start Rounding up your Exam, you have less than 10 (Ten) Seconds Left");
				}
			//give alert warning user on time about to end - stops here
			
			
			if (Exam_Secs <= 0){
				Exam_Min = Exam_Min - 1;
				Exam_Secs=59;
			}else{
				Exam_Secs = Exam_Secs - 1;
			}
			
			document.getElementById('countdown').innerHTML ="Time Left = 0" + Exam_Hrs + " Hrs : "+ Exam_Min + " Min : " + Exam_Secs +  " Secs";
			if(Exam_Hrs > 0)
			{
				if(Exam_Min <=0)
				{
					Exam_Hrs = Exam_Hrs - 1;
					Exam_Min=59;
				}
				document.getElementById('countdown').innerHTML ="Time Left = 0" + Exam_Hrs + " Hrs : "+ Exam_Min + " Min : " + Exam_Secs +  " Secs";
			}

			if((Exam_Min < 10) && (Exam_Secs > 10))
			{
					document.getElementById('countdown').innerHTML ="Time Left = 0" + Exam_Hrs + " Hrs : 0"+ Exam_Min + " Min : " + Exam_Secs +  " Secs";
			}
			
			if((Exam_Min > 10) && (Exam_Secs < 10))
			{
					document.getElementById('countdown').innerHTML ="Time Left = 0" + Exam_Hrs + " Hrs : "+ Exam_Min + " Min : 0" + Exam_Secs +  " Secs";
			}
			
			if((Exam_Min < 10) && (Exam_Secs < 10))
			{
					document.getElementById('countdown').innerHTML ="Time Left = 0" + Exam_Hrs + " Hrs : 0"+ Exam_Min + " Min : 0" + Exam_Secs +  " Secs";
			}
			//1000 - 1seconds interval
			 //Recursive call, keeps the clock ticking.
			 setTimeout('countdown_clock(' + Total_seconds + ',' + Exam_Hrs + ',' + Exam_Min + ',' + Exam_Secs + ');', 1000);
         }
		 
		 function convert_to_seconds_to_continue(hrs, mins, secs){
			
			var	Exam_Hrs_s =  new Number(hrs);
			var	Exam_Min_s = new Number(mins);
			var	Exam_Secs_s = new Number(secs);
			Exam_Min_s = Exam_Min_s * 60;
			Exam_Hrs_s = Exam_Hrs_s * 60 * 60;
			var Total_seconds = Exam_Hrs_s + Exam_Min_s + Exam_Secs_s;
			countdown_clock(Total_seconds, hrs, mins, secs)
		}
/*###############################################################################################
#									JAVASCRIPT FOR COUNTDOWN TIMER - BY SHERIF					#
###############################################################################################*/