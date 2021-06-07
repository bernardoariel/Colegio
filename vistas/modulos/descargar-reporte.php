<?php

require_once "../../controladores/ventas.controlador.php";
require_once "../../modelos/ventas.modelo.php";
require_once "../../controladores/escribanos.controlador.php";
require_once "../../modelos/escribanos.modelo.php";
require_once "../../controladores/enlace.controlador.php";
require_once "../../modelos/enlace.modelo.php";
require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";

$reporte = new ControladorVentas();
$reporte -> ctrDescargarReporte();