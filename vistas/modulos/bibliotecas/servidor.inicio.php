<?php

/*==================================================
      = ELIMINAR LOS INHABILITADOS EN EL SERVIDOR  =
==================================================*/
#ELIMINAR LOS INHABILITADOS EN EL SERVIDOR
$respuesta = ControladorEnlace::ctrEliminarEnlace("inhabilitados");
/*============================================
=      HABILITO A TODOS LOS ESCRIBANOS      =
=============================================*/
#HABILITO A TODOS LOS DEUDORES EN LA TABLA ESCRIBANOS
#LOS PONGO A CERO
ControladorCuotas::ctrEscribanosHabilitar();

?>