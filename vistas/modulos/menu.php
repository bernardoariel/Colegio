<aside class="main-sidebar">

   <section class="sidebar">

    <ul class="sidebar-menu">
      
      <!-- inicio -->
      <li class="active">

        <a href="inicio">

          <i class="fa fa-home"></i>
          <span>Inicio</span>

        </a>

      </li>

      <!--=====================================
      =            ADMINISTRADOR            =
      ======================================-->
      <?php 

      if($_SESSION['perfil']=="Administrador"){
    
        echo   '<li class="treeview">

              <a href="#">

                <i class="fa fa-address-card"></i>
              
                <span>Admin</span>
              
                <span class="pull-right-container">
              
                  <i class="fa fa-angle-left pull-right"></i>

                </span>

              </a>

              <ul class="treeview-menu">
            
            <li>

              <a href="usuarios">

                <i class="fa fa-user"></i>
                <span>Usuarios</span>

              </a>

            </li>

            <li>

              <a href="miempresa">

                <i class="fa fa-university"></i>
                <span>Empresa</span>

              </a>

            </li>

          </ul>

        </li>';

      echo   '<li class="treeview">

              <a href="#">

                <i class="fa fa-braille"></i>
              
                <span>Datos</span>
              
                <span class="pull-right-container">
              
                  <i class="fa fa-angle-left pull-right"></i>

                </span>

              </a>

              <ul class="treeview-menu">

              <li>

        <a href="escribanos">

          <i class="fa fa-user"></i>
          <span>Escribanos</span>

        </a>

      </li>
            
            <li>

        <a href="categorias">

          <i class="fa fa-users"></i>
          <span>Categorías Escribanos</span>

        </a>

      </li>

      <li>

        <a href="rubros">

          <i class="fa fa-linode"></i>
          <span>Rubros</span>

        </a>

      </li>

      <li>

        <a href="comprobantes">

          <i class="fa fa-files-o"></i>
          <span>Comprobantes</span>

        </a>

      </li>
      
      <li>

        <a href="osde">

          <i class="fa fa-heartbeat"></i>
          <span>Osde</span>

        </a>

      </li>
        
      
      
      
      <li>

        <a href="productos">

          <i class="fa fa-product-hunt"></i>
          <span>Productos</span>

        </a>

      </li>
        
      <li>

        <a href="parametros">

          <i class="fa fa-wrench"></i>
          <span>Parametros</span>

        </a>

      </li>
              

          </ul>

        </li>';    

          
      }


?>
      
      <!--=====================================
      =            VENDEDOR            =
      ======================================-->

      <?php 
      
      if($_SESSION['perfil']=="Administrativo"||$_SESSION['perfil']=="SuperAdmin"){
      
      
      echo'<li>

        <a href="caja2">

          <i class="fa fa-money"></i>
          <span>Caja</span>

        </a>

         </li>';
      
      echo'<li>

        <a href="libros">

          <i class="fa fa-book"></i>
          <span>Libros</span>

        </a>

         </li>';
      echo'<li>

        <a href="clientes">

          <i class="fa fa-user"></i>
          <span>Clientes</span>

        </a>

         </li>';
      
        echo '<li class="treeview">

          <a href="#">

            <i class="fa fa-list-ul"></i>
            
            <span>Ventas</span>
            
            <span class="pull-right-container">
            
              <i class="fa fa-angle-left pull-right"></i>

            </span>

          </a>

          <ul class="treeview-menu">
            
            <li>

              <a href="ventas">
                
                <i class="fa fa-table"></i>
                <span>Administrar ventas</span>

              </a>

            </li>

            <li>

              <a href="crear-venta">
                
                <i class="fa fa-file"></i>
                <span>Crear venta</span>

              </a>

            </li>

            

            <li>

              <a href="ctacorriente">
                
                <i class="fa fa-spinner"></i>
                <span>Cta Corriente</span>

              </a>

            </li>

            <li>

              <a href="cuotas">
                
                <i class="fa fa-file-text-o"></i>
                <span>Cuotas</span>

              </a>

            </li>

            <li>

              <a href="remitos">
                
                <i class="fa fa-table"></i>
                <span>Administrar remitos</span>

              </a>

            </li>

            <li>

              <a href="afip">
                
                <i class="fa fa-asterisk"></i>
                <span>Afip</span>

              </a>

            </li>


            <li>

              <a href="historico">
                
                <i class="fa fa-database"></i>
                <span>Historico</span>

              </a>

            </li>';

 // <li>

 //              <a href="tmpcuotas">
                
 //                <i class="fa fa-database"></i>
 //                <span>tmpCUOTAS</span>

 //              </a>

 //            </li>
             
 //          </ul>

 //        </li>

       
      }
    
      ?>
      

    </ul>

   </section>

</aside>