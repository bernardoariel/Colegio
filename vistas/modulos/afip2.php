<?php

function cvf_convert_object_to_array($data) {

    if (is_object($data)) {
        $data = get_object_vars($data);
    }

    if (is_array($data)) {
        return array_map(__FUNCTION__, $data);
    }
    else {
        return $data;
    }

}

include('extensiones/afip/consulta.php');

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar Comprobantes Homologados de Afip
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Comprobantes Homolagados</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box box-danger">
      
      <div class="box-header with-border">
      
        
        <div class="col-lg-2">
          
          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-file"></i></span> 

                  <?php 
                    $cmp = $afip->consultarUltimoComprobanteAutorizado($PTOVTA,11);
                  ?>

                  <input type="number" class="form-control input-lg" name="numero" id="numero" value="<?php echo $cmp['number'];?>"> 

                </div>

          </div>

        </div>
        <div class="col-lg-3">
          
          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-file"></i></span> 

                  <select class="form-control input-lg" name="tipoComprobante" id="tipoComprobante">

                    <option value="11">Factura</option>
                    <option value="13" <?php if ($_GET['comprobante']=='13'){echo "selected";} ?>>Nota Credito</option>

                  </select>

                </div>

          </div>

        </div>

        <div class="col-lg-2">
          
          <div class="form-group">
                
                <div class="input-group">
                
                  <button class="btn btn-danger" id="btnAfip">Buscar</button>

                </div>

          </div>

        </div>
      
        <div class="col-lg-6 pull-right">
          
          <?php
            
            if(isset($_GET['comprobante'])){

              $cmp = $afip->consultarUltimoComprobanteAutorizado($PTOVTA,$_GET['comprobante']);

            }else{

              $cmp = $afip->consultarUltimoComprobanteAutorizado($PTOVTA,11);  

            }
            
            echo '<h5><strong>Ultimo Nro. de Comprobante: '.$cmp["number"].'</strong></h5>';
           ?>

        </div>

      </div>
     

      <div class="box-body">
        
        <div class="col-lg-6">

          <?php

            $ultimoComprobante = $afip->consultarUltimoComprobanteAutorizado($PTOVTA,11);  
          

              if(isset($_GET['comprobante'])){
                

                $result = $afip->consultarComprobante($PTOVTA,$_GET['comprobante'],$_GET['numero']);

              }else{

                

                $result = $afip->consultarComprobante($PTOVTA,11,$ultimoComprobante);

              }
           
             $miObjeto=cvf_convert_object_to_array($result["datos"]);


          ?>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: blue;color:white;">Cuit</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $miObjeto['DocNro'];?>"> 

                </div>

          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: blue;color:white;">Fecha</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $miObjeto['CbteFch'];?>"> 

                </div>

          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: blue;color:white;"> Importe</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $miObjeto['ImpTotal'];?>"> 

                </div>

          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: blue;color:white;">Nro Comprobante</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $miObjeto['CbteDesde'];?>"> 

                </div>
                
          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: blue;color:white;">CAE</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $miObjeto['CodAutorizacion'];?>"> 

                </div>
                
          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: blue;color:white;"> Fecha Cae</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $miObjeto['FchVto'];?>"> 

                </div>
                
          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: blue;color:white;">Punto Venta</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $miObjeto['PtoVta'];?>"> 

                </div>
                
          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: blue;color:white;"> Tipo Comprobante</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $miObjeto['CbteTipo'];?>"> 

                </div>
                
          </div>

        </div>

        <div class="col-lg-6">


          
          <?php
          // print_r($miObjeto);  

            if (!empty($miObjeto)){
             
              #BUSCO EL CAE DE LA FACTURA PARA TENER LOS DATOS QUE TENGO GUARDADO EN MI TABLA
              $item = "cae";
              $valor = $miObjeto['CodAutorizacion'];

 // echo $miObjeto['CodAutorizacion'];
              $ventas = ControladorVentas::ctrMostrarVentas($item,$valor);
              // echo '<pre>'; print_r($ventas); echo '</pre>';
              echo "<strong>".strtoupper($ventas['tabla'])."</strong>";
              $nombre =$ventas['nombre'];
              $cuit=$ventas['documento'];

              if($ventas['tabla']=="escribanos"){

                $item = "cuit";
                $valor = $miObjeto['DocNro'];

                $respuesta = ControladorEscribanos::ctrMostrarEscribanos($item,$valor);

                $item = "id";
                $valor = $respuesta["id_tipo_iva"];

                $tipoIva = ControladorTipoIva::ctrMostrarTipoIva($item,$valor);

                $tipoIva =$tipoIva['nombre'];

              }
              
              if($ventas['tabla']=="clientes"){

                $item = "cuit";
                $valor = $miObjeto['DocNro'];

                $respuesta = ControladorClientes::ctrMostrarClientes($item,$valor);

                $tipoIva = $respuesta['tipoiva'];

              }

              if($ventas['tabla']=="casual"){

                $tipoIva = "CONSUMIDOR FINAL";

              }

              if($ventas['tabla']=="consumidor_final"){

                $tipoIva = "CONSUMIDOR FINAL";
                
              }
             
             ?>
              <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: red;color:white;">Nombre</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $nombre;?>"> 

                </div>

          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: red;color:white;">Cuit</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $cuit;?>"> 

                </div>
                
          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: red;color:white;">Tipo Iva</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $tipoIva;?>"> 

                </div>
                
          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: red;color:white;">Fecha</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $ventas['fecha'];?>"> 

                </div>
                
          </div>
          
          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: red;color:white;">Tipo</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $ventas['tipo'];?>"> 

                </div>
                
          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: red;color:white;">Comprobante Nro.</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $ventas['codigo'];?>"> 

                </div>
                
          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: red;color:white;">Fecha Cae</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $ventas['fecha_cae'];?>"> 

                </div>
                
          </div>

          <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon" style="background-color: red;color:white;">Total Fc</span> 

                  <input type="text" class="form-control input-lg"  value="<?php echo $ventas['total'];?>"> 

                </div>
                
          </div>

        </div>

     

             <?php
            }else{


            }

          ?>

          
          

  </section>

</div>