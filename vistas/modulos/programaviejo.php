<?php 
function conectar_db1(){
  //funcion conectar con la base de datos - funcion mas sencilla posible
  $servidor = 'localhost';
  $user='root';
  $pass = '';
  $db = 'escribano';
  // realice todos las variables en una misma funcion para evitar cambios
  $con = @mysql_connect($servidor,$user,$pass);
  mysql_set_charset('utf8',$con);
  @mysql_select_db($db,$con);

}
function conectar_db2(){
  //funcion conectar con la base de datos - funcion mas sencilla posible
  $servidor = 'localhost';
  $user='root';
  $pass = '';
  $db = 'colorado';
  // realice todos las variables en una misma funcion para evitar cambios
  $con = @mysql_connect($servidor,$user,$pass);
  mysql_set_charset('utf8',$con);
  @mysql_select_db($db,$con);

}
function desconectar(){
  @mysql_close();
  
}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Realizar Copia de Datos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar Copia de Datos</li>
    
    </ol>

  </section>

  <section class="content">
    
   <div class="callout callout-info">
     
     <h1>Copiar la tabla de escribanos</h1>

     <?php
      
      conectar_db1();

      $ssql ="select * from escribanos where activo=1 order by apellido";
      $result=mysql_query($ssql);
      $numero = mysql_num_rows($result);

      $contador=0;
      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $arrayEscribano[$contador]['idescribano']=$line['idescribano'];
        $arrayEscribano[$contador]['apellido']=$line['apellido'];
        $arrayEscribano[$contador]['nombre']=$line['nombre'];
        $arrayEscribano[$contador]['direccion']=$line['direccion'];
        $arrayEscribano[$contador]['ciudad']=$line['ciudad'];
        $arrayEscribano[$contador]['telefono1']=$line['telefono1'];
        $arrayEscribano[$contador]['dni']=$line['dni'];
        $arrayEscribano[$contador]['cuit']=$line['cuit'];
        $arrayEscribano[$contador]['email']=$line['email'];
        $arrayEscribano[$contador]['categoriaescribano']=$line['categoriaescribano'];
        $arrayEscribano[$contador]['escribanorelacionado']=$line['escribanorelacionado'];
        $arrayEscribano[$contador]['categoriaosde']=$line['categoriaosde'];
        $arrayEscribano[$contador]['ultimolibrocomprado']=$line['ultimolibrocomprado'];
        $arrayEscribano[$contador]['ultimolibrodevuelto']=$line['ultimolibrodevuelto'];

        $contador++;  
      }

      $respuesta = ModeloProgramaViejo::mdlEliminarEscribanos();

      $tabla = "escribanos";
      foreach($arrayEscribano as $rsEscribano){
        # code...
        $datos = array("id"=>$rsEscribano["idescribano"],
                       // "apellido"=>$rsEscribano["apellido"],
                       "nombre"=>$rsEscribano["apellido"].' '.$rsEscribano["nombre"],
                       "direccion"=>$rsEscribano["direccion"],
                       "localidad"=>$rsEscribano["ciudad"],
                       "telefono"=>$rsEscribano["telefono1"],
                       "documento"=>$rsEscribano["dni"],
                       "cuit"=>$rsEscribano["cuit"],
                       "email"=>$rsEscribano["email"],
                       "id_categoria"=>$rsEscribano["categoriaescribano"],
                       "id_escribano_relacionado"=>$rsEscribano["escribanorelacionado"], 
                       "id_osde"=>$rsEscribano["categoriaosde"], 
                       "ultimolibrocomprado"=>$rsEscribano["ultimolibrocomprado"], 
                       "ultimolibrodevuelto"=>$rsEscribano["ultimolibrodevuelto"]);

         $respuesta = ModeloProgramaViejo::mdlEscribanos($tabla, $datos);

         if($respuesta=="ok"){

            echo '<br>'.$rsEscribano["apellido"].' '.$rsEscribano["nombre"].'<i class="fa fa-check"></i>';

          }else{

            echo 'no';
          }
      }
      
      desconectar();

    ?>

   </div>

   <div class="callout callout-warning">
     
     <h1>Copiar la tabla de comprobantes</h1>

     <?php
      
      conectar_db1();

      $ssql ="select * from nrocomprobante";
      $result=mysql_query($ssql);
      $numero = mysql_num_rows($result);

      $contador=0;
      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $arrayComprobantes[$contador]['idnrocomprobante']=$line['idnrocomprobante'];
        $arrayComprobantes[$contador]['nombre']=$line['nombre'];
        $arrayComprobantes[$contador]['cabezacomprobante']=$line['cabezacomprobante'];
        $arrayComprobantes[$contador]['nrocomprobante']=$line['nrocomprobante'];

        $contador++;  
      }

      $respuesta = ModeloProgramaViejo::mdlEliminarComprobantes();

      $tabla = "comprobantes";

      foreach($arrayComprobantes as $rsComprobantes){
        # code...
        
        $datos = array("id"=>$rsComprobantes["idnrocomprobante"],
                       "nombre"=>$rsComprobantes["nombre"],
                       "cabezacomprobante"=>$rsComprobantes["cabezacomprobante"],
                       "numero"=>$rsComprobantes["nrocomprobante"]);

        $respuesta = ModeloProgramaViejo::mdlComprobantes($tabla, $datos);

         if($respuesta=="ok"){

            echo '<br>'.$rsComprobantes["nombre"].'<i class="fa fa-check"></i>';

          }else{

            echo 'no';
          }
      }
      
      desconectar();

    ?>

   </div>
   
   <div class="callout callout-success">
     
     <h1>Copiar la tabla de osde</h1>

     <?php
      
      conectar_db1();

      $ssql ="select * from l_osde";
      $result=mysql_query($ssql);
      $numero = mysql_num_rows($result);

      $contador=0;
      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $arrayOsde[$contador]['idosde']=$line['idosde'];
        $arrayOsde[$contador]['nombre']=$line['nombre'];
        $arrayOsde[$contador]['importe']=$line['importe'];
        $contador++;  
      }

      $respuesta = ModeloProgramaViejo::mdlEliminarOsde();

      $tabla = "osde";

      foreach($arrayOsde as $rsOsde){
        # code...
        
        $datos = array("id"=>$rsOsde["idosde"],
                       "nombre"=>$rsOsde["nombre"],
                       "importe"=>$rsOsde["importe"]);

        $respuesta = ModeloProgramaViejo::mdlOsde($tabla, $datos);

         if($respuesta=="ok"){

            echo '<br>'.$rsOsde["nombre"].'<i class="fa fa-check"></i>';

          }else{

            echo 'no';
          }
      }
      
      desconectar();

    ?>

   </div>

   <div class="callout callout-danger">
     
     <h1>Copiar la tabla de rubros</h1>

     <?php
      
      conectar_db1();

      $ssql ="select * from rubros";
      $result=mysql_query($ssql);
      $numero = mysql_num_rows($result);

      $contador=0;
      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $arrayRubros[$contador]['idrubro']=$line['idrubro'];
        $arrayRubros[$contador]['nombre']=$line['nombre'];
        $arrayRubros[$contador]['movimiento']=$line['movimiento'];
        $arrayRubros[$contador]['mensual']=$line['mensual'];
        $arrayRubros[$contador]['obs']=$line['obs'];
        $arrayRubros[$contador]['activo']=$line['activo'];
        $arrayRubros[$contador]['obsdel']=$line['obsdel'];
        $contador++;  
      }

      $respuesta = ModeloProgramaViejo::mdlEliminarRubros();

      $tabla = "rubros";

      foreach($arrayRubros as $rsRubros){
        # code...
        
        $datos = array("id"=>$rsRubros["idrubro"],
                       "nombre"=>$rsRubros["nombre"],
                       "movimiento"=>$rsRubros["movimiento"],
                       "mensual"=>$rsRubros["mensual"],
                       "obs"=>$rsRubros["obs"],
                       "activo"=>$rsRubros["activo"],
                       "obsdel"=>$rsRubros["obsdel"]);

        $respuesta = ModeloProgramaViejo::mdlRubros($tabla, $datos);

         if($respuesta=="ok"){

            echo '<br>'.$rsRubros["nombre"].'<i class="fa fa-check"></i>';

          }else{

            echo 'no';
          }
      }
      
      desconectar();

    ?>

   </div>

   <div class="callout callout-info">
     
     <h1>Copiar la tabla de productos</h1>

     <?php
      
      conectar_db1();

      $ssql ="select * from productos";
      $result=mysql_query($ssql);
      $numero = mysql_num_rows($result);

      $contador=0;
      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $arrayProductos[$contador]['idproducto']=$line['idproducto'];
        $arrayProductos[$contador]['nombre']=$line['nombre'];
        $arrayProductos[$contador]['descripcion']=$line['descripcion'];
        $arrayProductos[$contador]['codigo']=$line['codigo'];
        $arrayProductos[$contador]['nrocomprobante']=$line['nrocomprobante'];
        $arrayProductos[$contador]['cantventa']=$line['cantventa'];
        $arrayProductos[$contador]['idrubro']=$line['idrubro'];

        $arrayProductos[$contador]['cantminima']=$line['cantminima'];
        $arrayProductos[$contador]['cuotas']=$line['cuotas'];
        $arrayProductos[$contador]['importe']=$line['importe'];
        $arrayProductos[$contador]['ultimonrocompra']=$line['ultimonrocompra'];
        $contador++;  
      }

      $respuesta = ModeloProgramaViejo::mdlEliminarProductos();

      $tabla = "productos";

      foreach($arrayProductos as $rsProductos){
        # code...
        
        $datos = array("id"=>$rsProductos["idproducto"],
                       "nombre"=>$rsProductos["nombre"],
                       "descripcion"=>$rsProductos["descripcion"],
                       "codigo"=>$rsProductos["codigo"],
                       "nrocomprobante"=>$rsProductos["nrocomprobante"],
                       "cantventa"=>$rsProductos["cantventa"],
                       "idrubro"=>$rsProductos["idrubro"],
                       "cantminima"=>$rsProductos["cantminima"],
                       "cuotas"=>$rsProductos["cuotas"],
                       "importe"=>$rsProductos["importe"],
                       "ultimonrocompra"=>$rsProductos["ultimonrocompra"]);

        $respuesta = ModeloProgramaViejo::mdlProductos($tabla, $datos);

         if($respuesta=="ok"){

            echo '<br>'.$rsProductos["nombre"].'<i class="fa fa-check"></i>';

          }else{

            echo 'noa';
          }
      }
      
      desconectar();

    ?>

   </div>

   <div class="callout callout-info">
     
     <h1>Copiar la tabla de VENTAS</h1>

     <?php
      
      conectar_db1();

      $ssql ="select * from cta where adeuda >0";
      $result=mysql_query($ssql);
      $numero = mysql_num_rows($result);

      $contador=0;
      while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $arrayCta[$contador]['idcta']=$line['idcta'];
        $arrayCta[$contador]['fecha']=$line['fecha'];
        $arrayCta[$contador]['tipo']=$line['tipo'];
        $arrayCta[$contador]['idescribano']=$line['idescribano'];
        $arrayCta[$contador]['nrofc']=$line['nrofc'];
        $arrayCta[$contador]['total']=$line['total'];
        $arrayCta[$contador]['adeuda']=$line['adeuda'];

        $contador++;  
      }

      $respuesta = ModeloProgramaViejo::mdlEliminarVentas();

      $tabla = "ventas";

      foreach($arrayCta as $rsCta){
        # code...
         // $ssql ="select * from cta_art where idcta =".$rsCta["idcta"];
         // $result=mysql_query($ssql);
         // $numero = mysql_num_rows($result);

         // $contador=0;
         //  while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
         //    $arrayCta_art[$contador]['idctaart']=$line['idctaart'];
         //    $arrayCta_art[$contador]['idcta']=$line['idcta'];
         //    $arrayCta_art[$contador]['idproducto']=$line['idproducto'];
         //    $arrayCta_art[$contador]['nombre']=$line['nombre'];
         //    $arrayCta_art[$contador]['cantidad']=$line['cantidad'];
         //    $arrayCta_art[$contador]['importe']=$line['importe'];
         //    $arrayCta_art[$contador]['folio1']=$line['folio1'];
         //    $arrayCta_art[$contador]['folio2']=$line['folio2'];
         //    $contador++;  
         //  }

        
        

        $datos = array("fecha"=>$rsCta["fecha"],
                       "tipo"=>$rsCta["tipo"],
                       "productos"=>"",
                       "idescribano"=>$rsCta["idescribano"],
                       "total"=>$rsCta["total"],
                       "adeuda"=>$rsCta["adeuda"]);

        // [{"id":"20","descripcion":"CUOTA MENSUAL JULIO/2018","idnrocomprobante":"100","cantventaproducto":"1","folio1":"1","folio2":"1","cantidad":"1","precio":"100","total":"100"}]
        $respuesta = ModeloProgramaViejo::mdlVentas($tabla, $datos);

         if($respuesta=="ok"){

            echo '<br>'.$rsCta["idcta"].' '.$rsCta["adeuda"].'<i class="fa fa-check"></i>';

          }else{

            echo 'noa';
          }
      }
      
      desconectar();

    ?>

   </div>

  </section>

</div>



    
