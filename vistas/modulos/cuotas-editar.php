<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar cuotas a facturar
    
    </h1>
  
    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar cuotas a facturar</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box cajaPrincipal">

      <div class="box-header with-border">
        
      </div>

      <div class="box-body">
      <form method="POST">
        <label for="fechaCUEditar">Fecha</label>
        <input type="text" name="fechaCUEditar">
        <label for="tipoComprobante">Tipo</label>
        <input type="text" name="tipoComprobante">
        <label for="importe1">Importe 1</label>
        <input type="text" name="importe1">
        <label for="importe2">Importe 2</label>
        <input type="text" name="importe2">
        <label for="importe3">Importe 3</label>
        <input type="text" name="importe3">
        <button type="submit">MODIFICAR</button>
      </form>
       
        <?php

        $modificarCuota = new ControladorCuotas();
        $modificarCuota -> ctrModificarImporte();

        ?>   

            
       
     
       

      </div>

    </div>

  </section>

</div>


      


