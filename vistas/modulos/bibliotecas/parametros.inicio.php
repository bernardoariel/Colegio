<?php

      /*==========================================
                        PARAMETROS
      =============================================*/
      #DIAS DE ATRASO
      $item = "parametro";
      $valor = 'maxAtraso';

      $atraso = ControladorParametros::ctrMostrarParametroAtraso($item, $valor);

      #CANTIDAD DE LIBROS
      $item = "parametro";
      $valor = 'maxLibro';

      $libro = ControladorParametros::ctrMostrarParametroAtraso($item, $valor);

      $maxLibros=$libro['valor']+1;
?>