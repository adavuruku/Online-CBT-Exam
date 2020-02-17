
var xmlHttp;
var inc_Q_id_Answer;
var Answer_chooz="O";
var answer_found_to_mark;
var quest_details="";
var time_remain_alert = 0;

function openloader(){
    document.getElementById("error").innerHTML ='<img src="Server_Pictures_Print/images/loader.gif" class="img-responsive" alt="Uploading...."/>';
	document.getElementById("error1").innerHTML ='<img src="Server_Pictures_Print/images/loader.gif" class="img-responsive" alt="Uploading...."/>';
}
function closeloader(){
    document.getElementById("error").innerHTML ='';
	 document.getElementById("error1").innerHTML ='';
}



function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
	  {
	  // Firefox, Opera 8.0+, Safari
	  xmlHttp=new XMLHttpRequest();
	  }
	catch (e)
	  {
	  // Internet Explorer
	  try
		{
		xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
	  catch (e)
		{
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	  }
	return xmlHttp;
}



function validate_questions()
{
		question_remain_message="";
		quest_details="";
		var last_question = document.getElementById('Q_id_total').innerHTML;
		last_question = new Number(last_question);
		var Question_not_ansa = 0;
		for (var i=1; i<=last_question; i++)
		{
			var  p_ansa_id_2 = i + "A";
			if (document.getElementById(p_ansa_id_2).innerHTML=="O")
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





function Previous()
{
	var q_id_no = document.getElementById("Q_id").innerHTML;
	xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
       {
            alert ("Your browser does not support AJAX!");
            return;
       }
            /*&"?status="+kkk*/
            var url="Question_Ajax_Script.php";
            url=url+"?Q_id="+inc_Q_id_Answer+"&answer_chooz="+Answer_chooz+"&current_id="+q_id_no;
            xmlHttp.onreadystatechange=QuestionChanged;
            xmlHttp.open("GET",url,true);
            xmlHttp.send(null);
}

//########################################### by question navigator ########################################

function Mark_choice_question(question_id_chooz)
{
	openloader();
	inc_Q_id_Answer = question_id_chooz;
	var new_id = document.getElementById("Q_id").innerHTML;
	var  p_ansa_id = new_id + "A";
	
	if (document.getElementById("A").checked==true){
		Answer_chooz = "A";
	 }else if (document.getElementById("B").checked==true){
		Answer_chooz = "B";
	 }
	 else if (document.getElementById("C").checked==true){
		Answer_chooz = "C";
	 }else if(document.getElementById("D").checked==true){
		Answer_chooz = "D";
	 }
	 else{
	 Answer_chooz = "O";
	 }
	
	document.getElementById(p_ansa_id).innerHTML = Answer_chooz;
	Previous();
}



//########################################### MARK WHEN AT THE LAST QUESTION - TO TICK AGAINST THE DIALOG BOX MSG ########################################

function Mark_choice_current_question()
{
	var new_id = document.getElementById("Q_id").innerHTML;
	var  p_ansa_id = new_id + "A";
	
	if (document.getElementById("A").checked==true){
		Answer_chooz = "A";
	 }else if (document.getElementById("B").checked==true){
		Answer_chooz = "B";
	 }
	 else if (document.getElementById("C").checked==true){
		Answer_chooz = "C";
	 }else if(document.getElementById("D").checked==true){
		Answer_chooz = "D";
	 }
	 else{
	 Answer_chooz = "O";
	 }
	
	document.getElementById(p_ansa_id).innerHTML = Answer_chooz;
}




//########################################### by next and previous ########################################
function Mark_choice(determine_n_p)
{
	openloader();
	var new_id = document.getElementById("Q_id").innerHTML;
	var  p_ansa_id = new_id + "A";
	
	if (document.getElementById("A").checked==true){
		Answer_chooz = "A";
	 }else if (document.getElementById("B").checked==true){
		Answer_chooz = "B";
	 }
	 else if (document.getElementById("C").checked==true){
		Answer_chooz = "C";
	 }else if(document.getElementById("D").checked==true){
		Answer_chooz = "D";
	 }
	 else{
	 Answer_chooz = "O";
	 }
	
	document.getElementById(p_ansa_id).innerHTML = Answer_chooz;
	var Q_id_total = document.getElementById('Q_id_total').innerHTML;
	Q_id_total = new Number(Q_id_total);
	//alert(Q_id_total);
	inc_Q_id_Answer = 0;
	  if (determine_n_p  =="previous")
	  {
		  if (new_id <= 1)
		  {
			//highest number of question is Q_id_total
			inc_Q_id_Answer = Q_id_total;
		  }
		  else
		  {
			inc_Q_id_Answer = new Number(new_id) - 1;
		  }
	}  
	  //next
	  if (determine_n_p  =="next")
	  {
		  if (new_id == Q_id_total)
		  {
			//lowest number of question is 1
			inc_Q_id_Answer = 1;
		  }
		  else
		  {
			inc_Q_id_Answer = new Number(new_id) + 1;
		  }
	  }
	  
	  Previous();
}

//###################################################################################


/* when Question is change*/
function QuestionChanged() 
{ 
	
	if (xmlHttp.readyState==4)
	{ 
		document.getElementById("Question_Container").innerHTML="";
		document.getElementById("Question_Container").innerHTML=xmlHttp.responseText;
		document.getElementById("Q_id").innerHTML = inc_Q_id_Answer;
		document.getElementById("Q_id2").innerHTML = inc_Q_id_Answer;
		
		//change the color of the question in navigation
		document.getElementById(inc_Q_id_Answer).style.color="black";
		
		
		inc_Q_id_Answer3 = inc_Q_id_Answer + "A"; 
		answer_found_to_mark = document.getElementById(inc_Q_id_Answer3).innerHTML;
		//alert(answer_found_to_mark);
		closeloader();
		if(answer_found_to_mark =="A")
		{
			document.getElementById("A").checked=true;
		}
		else if(answer_found_to_mark =="B")
		{
			document.getElementById("B").checked=true;
		}
		else if(answer_found_to_mark =="C")
		{
			document.getElementById("C").checked=true;
		}
		else if(answer_found_to_mark =="D")
		{
			document.getElementById("D").checked=true;
		}
		 else
		 {
			document.getElementById("O").checked=true;
		 }
		
	}
}

v