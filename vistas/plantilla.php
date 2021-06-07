<?php

session_start();

$item = null;
$valor = null;

$empresa = ControladorEmpresa::ctrMostrarEmpresa($item, $valor);

?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?php echo $empresa[0]['empresa']; ?></title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="<?php echo $empresa[0]['iconochiconegro'];?>">

   <!--=====================================
  PLUGINS DE CSS
  ======================================-->

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
  
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

   <!-- DataTables -->
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
 
  

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">

   <!-- Daterange picker -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <!-- Morris chart -->
  <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">

  <!--=====================================
  PLUGINS DE JAVASCRIPT
  ======================================-->

  <!-- jQuery 3 -->
  <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
  
  <!-- Bootstrap 3.3.7 -->
  <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- FastClick -->
  <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
  
  <!-- AdminLTE App -->
  <script src="vistas/dist/js/adminlte.min.js"></script>

  <!-- DataTables -->
  <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>

  <!-- SweetAlert 2 -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
  <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> -->

  <!-- iCheck 1.0.1 -->
  <script src="vistas/plugins/iCheck/icheck.min.js"></script>

  <!-- InputMask -->
  <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>

  <!-- jQuery Number -->
  <script src="vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>

  <!-- daterangepicker http://www.daterangepicker.com/-->
  <script src="vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
  <script src="vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="vistas/bower_components/morris.js/morris.min.js"></script>

  <!-- ChartJS http://www.chartjs.org/-->
  <script src="vistas/bower_components/chart.js/Chart.js"></script>

  <!-- bootstrap datepicker -->
  <script src="vistas/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

</head>

<!--=====================================
CUERPO DOCUMENTO
======================================-->

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
 
  <?php

  if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){

   echo '<div class="wrapper">';

    /*=============================================
    CABEZOTE
    =============================================*/

    include "modulos/cabezote.php";

    /*=============================================
    MENU
    =============================================*/

    include "modulos/menu.php";

    

    /*=============================================
    CONTENIDO
    =============================================*/

    if(isset($_GET["ruta"])){

      if($_GET["ruta"] == "usuarios" ||
         $_GET["ruta"] == "inicio" ||
         $_GET["ruta"] == "iniciosinconexion" ||
         $_GET["ruta"] == "usuarios" ||
         $_GET["ruta"] == "miempresa" ||
         
         $_GET["ruta"] == "escribanos" ||
         $_GET["ruta"] == "categorias" ||
         $_GET["ruta"] == "osde" ||
         $_GET["ruta"] == "rubros" ||
         $_GET["ruta"] == "comprobantes" ||
         $_GET["ruta"] == "caja" ||
         $_GET["ruta"] == "caja2" ||
         $_GET["ruta"] == "restaurar" ||
         // $_GET["ruta"] == "update" ||
         $_GET["ruta"] == "tmpcuotas" ||
    
         $_GET["ruta"] == "afacturar" ||
         $_GET["ruta"] == "productos" ||
         $_GET["ruta"] == "ctacorriente" ||
         $_GET["ruta"] == "cuotas" ||
         $_GET["ruta"] == "historico" ||
         $_GET["ruta"] == "parametros" ||
         $_GET["ruta"] == "afip" ||
         $_GET["ruta"] == "clientes" ||
         $_GET["ruta"] == "copiaritems" ||
         $_GET["ruta"] == "buscar-items" ||
         $_GET["ruta"] == "delegaciones" ||
         $_GET["ruta"] == "cuotas-editar" ||
         

         
         $_GET["ruta"] == "ventas" ||
         $_GET["ruta"] == "crear-venta" ||
         $_GET["ruta"] == "nota-credito" ||
         $_GET["ruta"] == "editar-venta" ||
         
         $_GET["ruta"] == "clorinda" ||

         $_GET["ruta"] == "colorado" ||
         $_GET["ruta"] == "ws" ||
         $_GET["ruta"] == "libros" ||
         $_GET["ruta"] == "remitos" ||
         $_GET["ruta"] == "editar-perfil" ||
         $_GET["ruta"] == "reportes" ||
         $_GET["ruta"] == "salir"){

        include "modulos/".$_GET["ruta"].".php";

      }else{

        include "modulos/404.php";

      }

    }else{

      include "modulos/inicio.php";



    }

    /*=============================================
    FOOTER
    =============================================*/

    include "modulos/footer.php";

    echo '</div>';

  }else{

    include "modulos/login.php";

  }

  ?>


<script src="vistas/js/plantilla.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/categorias.js"></script>
<script src="vistas/js/osde.js"></script>
<script src="vistas/js/escribanos.js"></script>
<script src="vistas/js/rubros.js"></script>

<script src="vistas/js/productos.js"></script>
<script src="vistas/js/ventas.js"></script>
<script src="vistas/js/restaurar.js"></script>
<script src="vistas/js/sucursales.js"></script>
<script src="vistas/js/delegaciones.js"></script>
<script src="vistas/js/remitos.js"></script>



<script src="vistas/js/crear-ventas.js"></script>

<script src="vistas/js/miempresa.js"></script>
<script src="vistas/js/reportes.js"></script>
<script src="vistas/js/editar-perfil.js"></script>
<script src="vistas/js/comprobantes.js"></script>
<script src="vistas/js/inicio.js"></script>
<script src="vistas/js/ctacorriente.js"></script>
<script src="vistas/js/caja.js"></script>
<script src="vistas/js/historico.js"></script>
<script src="vistas/js/libros.js"></script>
<script src="vistas/js/parametros.js"></script>
<script src="vistas/js/afip.js"></script>
<script src="vistas/js/nota-credito.js"></script>
<script src="vistas/js/editar-venta.js"></script>
<script src="vistas/js/colorado.js"></script>
<script src="vistas/js/clorinda.js"></script>
<script src="vistas/js/clientes.js"></script>
<script src="vistas/js/cuotas.js"></script>

</body>
</html>
