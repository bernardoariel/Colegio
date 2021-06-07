/*=============================================
CONSULTAR COMPROBANTE
=============================================*/
$("#btnNotaCredito").on("click",function(){

	window.location = "extensiones/afip/notacredito.php?cuit="+$('#notaCreditoCuit').val()+'&total='+$('#notaCreditoTotal').val();
	
	
})

$('#notaCreditoCuit').focus();
$('#notaCreditoCuit').select();