$("#selectescribanos").change(function () {	 
	
	// var datos = new FormData();
	// datos.append("idEscribano", $(this).val());
	var tipo = $("#btnVerCuotas").attr("valor");
	window.location = "index.php?ruta=historico&idEscribano="+$(this).val()+"&tipo="+tipo;
	
});

$("#btnVerCuotas").on("click",function(){

	var tipo = $("#btnVerCuotas").attr("valor");
	var idEsctibano = $("#btnVerCuotas").attr("idEscribano");
	window.location = "index.php?ruta=historico&idEscribano="+idEsctibano+"&tipo="+tipo;
	
})