var question_remain_message="";

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
				if(Total_seconds == 30)
				{
					alert("Start Rounding up your Exam, you have less than 30 (Thirty) Seconds Left");
				}
				
				if(Total_seconds == 10)
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