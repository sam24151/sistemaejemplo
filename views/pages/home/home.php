<?php

if(isset($routesArray[1])){
  echo '<div class="container-fluid p-3">
  <div class="card">
  <div class="p-2 text-justify">
  <h3>Bienvenidos al Sistema</h3>
  <p>Mi nombre es Samuel Orozco y llevo programando ya varios años en varios lenguajes, en este momento
   muestro lo que puedo realizar con PHP y JavaScript.</p>
  <p>Este sistema fue creado para fines de muestra de proyecto.</p>
  <p>El sistema consiste en un ejemplo de administración de Tiendas.</p>
  <p>
  El sistema esta habilitado para crear, leer, escribir, eliminar, generar reportes en PDF, Excel, Word, CSV.
  </p>
  <p>La visualización es para todo tipo de dispositivos.</p>
  <p>Las tecnologías utilizadas son:</p>
  <ul>
  <li>PHP(sin framework).</li>
  <li>Base de datos MySQL.</li>
  <li>Ajax.</li>
  <li>JQuery.</li> 
  <li>JavaScript.</li>
  <li>Boostrap.</li>
  <li>Summernote para texto enriquecido.</li>
  <li>Dropzone para carga de archivos varios.</li>
  <li>Chart.js para graficar.</li>
  <li>knob.js para graficar tipo donas.</li>
  <li>SweetAlert.js para mostrar alertas.</li>
  <li>Moment.js para manejo de fechas.</li>
  <li>Daterangepicker.js para mostrar calendario.</li>
  </ul>
  <p>
  Los patrones de diseño utilizados para este proyecto son POO y MVC.
  </p>
  </div>
  </div>
  </div>';
}else{
  
  echo '<section class="content-header">
  
  <div class="container-fluid">

    <!-- BOXES -->';
    include "modules/boxes.php";
  echo '
    <!-- GRÁFICOS -->';
    include "modules/chart.php";
  echo '
    <div class="row">

      <!-- ÓRDENES -->';
    include "modules/orders.php";
  echo '
      <!-- PRODUCTOS -->';
    include "modules/products.php";
  echo '
    </div><!-- /.container-fluid -->
  
  </div>

  </section>';
  
}

?>


