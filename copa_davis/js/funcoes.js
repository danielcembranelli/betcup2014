$(document).ready(function() {
    
	$(".fancybox").fancybox();
			
	$('input[type=tel]').mask("(99) 9999-9999?9").live('focusout', function(event) {
		var target, phone, element;
		target = (event.currentTarget) ? event.currentTarget : event.srcElement;
		phone = target.value.replace(/\D/g, '');
		element = $(target);
		element.unmask();
		if(phone.length > 10) {
			element.mask("(99) 99999-999?9");
		} else {
			element.mask("(99) 9999-9999?9");
		}
	});
	$('input[name=cep]').mask('99999-999');
		
	$("#btn-language").toggle(
		function(){
			$("#idiomas").slideDown("fast");
		},
		function(){
			$("#idiomas").slideUp("fast");
		}
	);
	
	$("#idiomas a").click(function(){
		$("#idiomas").slideUp("fast");
	})
	
	// Zebra na Tabela
		$("tbody tr:even").addClass("even");
		$("td:even").addClass("even");
	
	$('.filter').alphanumeric({ichars:"*’“'@%#/\[](){}¨$&:;,.?!+|=1234567890ªº"});
	$('.filter2').alphanumeric({ichars:"*’“'@%#/\[](){}¨$&:;.?!+|=ªº"});
	$('.email').alphanumeric({ichars:"*’“'´`^~%#/\[](){}¨$&:;,?!+|=ªº "});
	$('.numbers').numeric({ichars:"çÇ*’“'´`^~@%#/\[](){}¨$&:;,?!+-_|=. ªºáÁàÀéÉííóÓúÚãÃâÂ"});
	$('.filter,.filter2,.email').alphanumeric({ichars:'"'});
	$('.numbers').numeric({ichars:'"'});
	
	
	
})