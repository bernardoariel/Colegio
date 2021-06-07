<?php
$item = 'id';
$valor = $_SESSION['id'];

$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);


?>
<div class="content-wrapper">

  <section class="content-header">

    <h1>
      
      Administrar MI Perfil <?php echo "[".strtoupper($_SESSION['usuario'])."]"; ?>
      
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar MI Perfil </li>
    
    </ol>

  </section>

  <section class="content">
  
     <div class="row">

        <div class="col-md-6 col-xs-12">
          
          <div class="box box-primary">

              <div class="box-header with-border">

                <h3 class="box-title">Mi FOTO</h3>
            
              </div>

              
              <div class="box-body">
              
                <div class="form-group">
                  
                  <label>Cambiar mi Foto</label>

                  <p class="pull-right">
                    
                    <img src="<?php  echo $_SESSION["foto"]; ?>" class="img-thumbnail previsualizarMiFoto" width="100px">

                  </p>
                  
                  <input type="hidden" id="idUsuario" value="<?php  echo $_SESSION["id"]; ?>">
                  <input type="hidden" id="carpeta" value="<?php  echo $_SESSION["usuario"]; ?>">
                  <input type="hidden" id="foto" value="<?php  echo $_SESSION["foto"]; ?>">
                  <input type="file" id="subirMiFoto">

                  <p class="help-block">Tamaño recomendado 172px * 172px</p>  

                </div>  

              </div>

              <div class="box-footer">
                
                <button type="button" id="guardarMiFoto" class="btn btn-primary pull-right">Guardar Mi Foto</button>

              </div>
            
            </div>
        
        </div>
               <!--=====================================
              FOTO RECIBO
              ======================================-->
        <div class="col-md-6 col-xs-12">
          
          <div class="box box-primary">

              <div class="box-header with-border">

                <h3 class="box-title">MI CONTRASEÑA</h3>
            
              </div>

              <div class="box-body">
              
                <div class="form-group">
                  
                  <label>Cambiar mi Contraseña</label>



                   <input type="password" class="form-control input-lg" name="nuevoPassword" id="nuevoPassword" placeholder="Ingresar contraseña" required>

                </div>  

              </div>

              <div class="box-footer">
                
                <button type="button" id="guardarMiPass" class="btn btn-primary pull-right">Guardar mi Contraseña</button>

              </div>

          </div>
        
        </div>

    </div>
  
   

  </section>

</div>








