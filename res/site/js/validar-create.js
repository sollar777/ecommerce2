$(document).ready(function(){
	$('#cadastrar2').click(function(){

		$.ajax({

			url: "www.google.com.br",
			success: function(){
				alert("deu certo");
			}

		});
	});
});