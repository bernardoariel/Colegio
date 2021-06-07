/*=============================================
CONSULTAR COMPROBANTE
=============================================*/
$("#btnAfip").on("click",function(){

	window.location = "index.php?ruta=afip&numero="+$('#numero').val()+"&comprobante="+$('#tipoComprobante').val();
	
})

$('#numero').focus();
$('#numero').select();