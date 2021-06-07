<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
#CONTROLADORES QUE SE USAN:::::::::::::::::::::::::::::
require_once "controladores/plantilla.controlador.php";

require_once "controladores/escribanos.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/empresa.controlador.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/osde.controlador.php";
require_once "controladores/rubros.controlador.php";
require_once "controladores/comprobantes.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/parametros.controlador.php";
require_once "controladores/caja.controlador.php";
require_once "controladores/tipoiva.controlador.php";
require_once "controladores/enlace.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "controladores/articulos.controlador.php";
require_once "controladores/delegaciones.controlador.php";
require_once "controladores/remitos.controlador.php";
require_once "controladores/cuotas.controlador.php";
require_once "controladores/ws.controlador.php";

#MODELOS QUE SE USAN::::::::::::::::::::::::::::::::::::
require_once "modelos/escribanos.modelo.php";
require_once "modelos/empresa.modelo.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/categorias.modelo.php";
require_once "modelos/osde.modelo.php";
require_once "modelos/rubros.modelo.php";
require_once "modelos/comprobantes.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/parametros.modelo.php";
require_once "modelos/caja.modelo.php";
require_once "modelos/programaviejo.modelo.php";
require_once "modelos/tipoiva.modelo.php";
require_once "modelos/enlace.modelo.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/articulos.modelo.php";
require_once "modelos/delegaciones.modelo.php";
require_once "modelos/remitos.modelo.php";
require_once "modelos/cuotas.modelo.php";
require_once "modelos/ws.modelo.php";
$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();

