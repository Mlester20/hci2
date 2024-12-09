$(document).on('submit', '#reg-form', function(){  
	$.post('submit_update.php', $(this).serialize(), function(data){
		   $(".result").html(data);  
		});  
		  return false;		
		})

$(".uncheck").click(function () {
	$('input:checkbox').removeAttr('checked');
});