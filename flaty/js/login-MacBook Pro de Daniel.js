var carregando = 'Carregando...';
$(function(){
	$('form').submit(function(){
		$.ajax({
			type:'POST',
			url:$(this).attr('action'),
			data:$(this).serialize(),
			beforeSend:function() {
				$('#alert').html('<div class="alert alert-info">' + carregando + '</div>').hide().fadeIn('slow');
			},
			success:function(data){
				if(parseInt(data['retorno'])) {
					$('#alert').html('<div class="alert alert-success">' + data['aviso'] + '</div>').hide().fadeIn('slow', function() { window.location = window.location });
				} else {
					$('#alert').html('<div class="alert alert-danger">' + data['aviso'] + '</div>').hide().fadeIn('slow');
				}
			}
		});
		return false;
	});
});