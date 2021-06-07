<?php
$item = null;
$valor = null;

$empresa = ControladorEmpresa::ctrMostrarEmpresa($item, $valor);


?>
<div class="content-wrapper">

  <section class="content-header">

    <h1>
      
      Administrar empresa
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar empresa</li>
    
    </ol>

  </section>

  <section class="content">
    
    <div class="box box-danger">

      <div class="box-body">
    
        <div class="row">
        
          <div class="col-lg-8">

            <!-- ENTRADA PARA LA EMPRESA -->
              
              <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-university"></i></span> 

                  <input type="text" class="form-control input-lg" id="editarEmpresa" name="editarEmpresa" value="<?php echo $empresa[0]['empresa']; ?>" required>

                </div>

              </div>

              <!-- ENTRADA PARA LA DIRECCION -->

               <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                  <input type="text" class="form-control input-lg" id="editarDireccion" name="editarDireccion" value="<?php echo $empresa[0]['direccion']; ?>" required>

                </div>

              </div>

              <!-- ENTRADA PARA EL TELEFONO -->

              <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                  <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" value="<?php echo $empresa[0]['telefono']; ?>" required >

                </div>

              </div>

              <!-- ENTRADA PARA EL EMAIL -->

              <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-at"></i></span> 

                  <input type="text" class="form-control input-lg" name="editarEmail" id="editarEmail" value="<?php echo $empresa[0]['email']; ?>" required >

                  
                </div>

              </div>
          

              <!-- ENTRADA PARA EL CUIT -->

               <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-hashtag"></i></span> 

                  <input type="text" class="form-control input-lg" name="editarCuit" id="editarCuit" value="<?php echo $empresa[0]['cuit']; ?>">

                  
                </div>

              </div>

              <!-- ENTRADA PARA EL WEB -->

               <div class="form-group">
                
                <div class="input-group">
                
                  <span class="input-group-addon"><i class="fa fa-chrome"></i></span> 

                  <input type="text" class="form-control input-lg" name="editarWeb" id="editarWeb" value="<?php echo $empresa[0]['web']; ?>">

                  
                </div>

              </div>

          
        </div>



        <div class="col-lg-3">

           <div class="form-group">
              
              <div class="input-group">
                
                <label for="editarDetalle1">NOTA RECIBO CLIENTE</label>
                
                <textarea name="editarDetalle1" id="editarDetalle1" cols="50" rows="5"><?php echo $empresa[0]['detalle1']; ?></textarea>

              </div>

            </div>

            
            <div class="form-group">
              
              <div class="input-group">
                
                <label for="editarDetalle2">NOTA ACEPTACION CLIENTE</label>
                
                <textarea name="editarDetalle2" id="editarDetalle2" cols="50" rows="5"><?php echo $empresa[0]['detalle2']; ?></textarea>
               
              </div>

            </div>

          
            <div class="box-footer">
                
                <button type="button" id="guardarDatosEmpresa" class="btn btn-primary pull-right">Guardar Datos de Empresa</button>

            </div>

           
          </div>

        </div>

      <div class="row">

        <div class="col-md-6 col-xs-12">
          
          <div class="box box-primary">

           
              <div class="box-header with-border">

                <h3 class="box-title">ICONO DEL MENU</h3>
            
              </div>

              <div class="box-body">
              
                <div class="form-group">
                  
                  <label>Cambiar icono del Menu</label>

                  <p class="pull-right">
                    
                    <img src="<?php  echo $empresa[0]["iconochicoblanco"]; ?>" class="img-thumbnail previsualizarIconoBlanco" width="50px">

                  </p>

                  <input type="file" id="subirIconoBlanco">

                  <p class="help-block">Tamaño recomendado 172px * 172px</p>  

                </div>  

              </div>

              <div class="box-footer">
                
                <button type="button" id="guardarIconoBlanco" class="btn btn-primary pull-right">Guardar Icono Menu</button>

              </div>

              <!--=====================================
              ICONO NEGRO
              ======================================-->

              <div class="box-header with-border">

                <h3 class="box-title">ICONO DEL NAVEGADOR</h3>
            
              </div>

              <div class="box-body">
              
                <div class="form-group">
                  
                  <label>Cambiar el icono del Navegador</label>

                  <p class="pull-right">
                    
                    <img src="<?php  echo $empresa[0]["iconochiconegro"]; ?>" class="img-thumbnail previsualizarIconoNegro" width="50px">

                  </p>

                  <input type="file" id="subirIconoNegro">

                  <p class="help-block">Tamaño recomendado 172px * 172px</p>  

                </div>  

              </div>

              <div class="box-footer">
                
                <button type="button" id="guardarIconoNegro" class="btn btn-primary pull-right">Guardar Icono Navegador</button>

              </div>
            
             <!--=====================================
              LOGO BLANCO BLOQUE
              ======================================-->

              <div class="box-header with-border">

                <h3 class="box-title">LOGO PARA EL BACKEND</h3>
            
              </div>

              <div class="box-body">
              
                <div class="form-group">
                  
                  <label>Cambiar Logo para el Backend</label>

                  <p class="pull-right">
                    
                    <img src="<?php  echo $empresa[0]["logoblancobloque"]; ?>" class="img-thumbnail previsualizarLogoBlancoBloque" width="100px">

                  </p>

                  <input type="file" id="subirLogoBlancoBloque">

                  <p class="help-block">Tamaño recomendado 500px * 183px</p>  

                </div>  

              </div>

              <div class="box-footer">
                
                <button type="button" id="guardarLogoBlancoBloque" class="btn btn-primary pull-right">Guardar Logo para Backend</button>

              </div>

           
        

            </div><!-- box box-primary -->

          </div><!-- col-md-6 col-xs-12 -->

          <div class="col-md-6 col-xs-12">
          
          <div class="box box-primary">

            
             

              <!--=====================================
               LOGO BLANCO LINEAL
              ======================================-->

              <div class="box-header with-border">

                <h3 class="box-title">LOGO LINEAL MENU</h3>
            
              </div>

              <div class="box-body">
              
                <div class="form-group">
                  
                  <label>Cambiar Lineal Menu</label>

                  <p class="pull-right">
                    
                    <img src="<?php  echo $empresa[0]["logoblancolineal"]; ?>" class="img-thumbnail previsualizarBlancoLineal" width="150px">

                  </p>

                  <input type="file" id="subirBlancoLineal">

                  <p class="help-block">Tamaño recomendado 800px * 117px</p>  

                </div>  

              </div>

              <div class="box-footer">
                
                <button type="button" id="guardarBlancoLineal" class="btn btn-primary pull-right">Guardar Lineal Menu</button>

              </div>

             
            
             <!--=====================================
              FOTO RECIBO
              ======================================-->

              <div class="box-header with-border">

                <h3 class="box-title">RECIBO</h3>
            
              </div>

              <div class="box-body">
              
                <div class="form-group">
                  
                  <label>Cambiar Recibo</label>

                  <p class="pull-right">
                    
                    <img src="<?php  echo $empresa[0]["fotorecibo"]; ?>" class="img-thumbnail previsualizarFotoRecibo" width="100px">

                  </p>

                  <input type="file" id="subirFotoRecibo">

                  <p class="help-block">Tamaño recomendado 500px * 183px</p>  

                </div>  

              </div>

              <div class="box-footer">
                
                <button type="button" id="guardarFotoRecibo" class="btn btn-primary pull-right">Guardar Foto Recibo</button>

              </div>
        

            </div><!-- box box-primary -->

          </div><!-- col-md-6 col-xs-12 -->

        </div><!-- ROW-->
  
   

  </section>

</div>








