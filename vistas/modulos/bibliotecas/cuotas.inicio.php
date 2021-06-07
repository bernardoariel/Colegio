<?php
/*=============================================
=            GENERO LAS CUOTAS                =
=============================================*/
#CHEQUEO SI SE GENERARON Y SI NO SE GENERARON GENERARLA
$GenerarCuota = ControladorCuotas::ctrChequearGeneracion("CUOTA");
$GenerarOsde = ControladorCuotas::ctrChequearGeneracion("OSDE");

?>