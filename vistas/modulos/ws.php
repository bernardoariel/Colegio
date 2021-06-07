<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Administrar escribanos WS
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar escribanos WS</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
       

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th>Nombre</th>
           <th>Nombre</th>
           <th>Apellido</th>
           <th>matricula</th>
           <th>email</th>
           <th>telefono</th>
           <th>estado</th>
          

         </tr> 

        </thead>

        <tbody>

        <?php

          $item = null;
          $valor = null;

          $escribanos = ControladorWs::ctrMostrarEscribanosWs($item, $valor);

          foreach ($escribanos as $key => $value) {
            

            echo '<tr>

                    <td>'.$value["nombre"].'</td>
                    
                    <td>'.$value["nombre_ws"].'</td>

                    <td>'.$value["apellido_ws"].'</td>

                    <td>'.$value["matricula_ws"].'</td>

                    <td>'.$value["email"].'</td>

                    <td>'.$value["telefono"].'</td>

                    <td>'.$value["inhabilitado"].'</td>   

                  </tr>';
          
            }

        ?>
   
        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

