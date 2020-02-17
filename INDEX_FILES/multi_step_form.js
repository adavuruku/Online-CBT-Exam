
$(document).ready(function() {
var count = 0; // To Count Blank Fields
var count_b = 0;
/*------------ Validation Function-----------------*/
$(".submit_btn").click(function(event) 
{
		var radio_check = $('.rad'); // Fetching Radio Button By Class Name
		var input_field = $('.text_field'); // Fetching All Inputs With Same Class Name text_field & An HTML Tag textarea
		var text_area = $('textarea');
		var check_boxes = $('.course');
		// Validating Radio Button
		if (radio_check[0].checked == false && radio_check[1].checked == false) {
		var y = 0;
		} else {
		var y = 1;
		}
			
			for (var q = check_boxes.length; q > 0; q--) {
				if (document.getElementById(q).checked == true){
					//alert(document.getElementById(q).value);
					count_b = count_b + 1;
				}
			}
		// For Loop To Count Blank Inputs
		for (var i = input_field.length; i > count; i--) 
		{
			if (input_field[i - 1].value == '' || text_area.value == '') {
			count = count + 1;
			} else {
			count = 0;
			}
		}
		//alert(count_b);
	// Notifying Validation
	if ((count != 0 || y == 0) || count_b == 0) {
	alert("*Error: All or Some Fields are Empty*");
	event.preventDefault();
	} else {
	return true;
	}
});
/*---------------------------------------------------------*/
$(".next_btn").click(function() { // Function Runs On NEXT Button Click
$(this).parent().parent().next().fadeIn('slow');
$(this).parent().parent().css({
'display': 'none'
});
// Adding Class Active To Show Steps Forward;
$('.active').next().addClass('active');
});
$(".pre_btn").click(function() { // Function Runs On PREVIOUS Button Click
$(this).parent().parent().prev().fadeIn('slow');
$(this).parent().parent().css({
'display': 'none'
});
// Removing Class Active To Show Steps Backward;
$('.active:last').removeClass('active');
});
// Validating All Input And Textarea Fields
$(".submit_btn").click(function(e) {
if ($('input').val() == "" || $('textarea').val() == "") {
alert("*Error: All or Some Mandatory Fields are Empty*");
return false;
} 
});

});



