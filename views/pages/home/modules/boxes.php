<?php 
/*=============================================
total de productos
=============================================*/

$url = "products?select=id_product&linkTo=approval_product&equalTo=approved";
$method = "GET";
$tabla = "products";
$fieldss = [
  "select" => "id_product",
  "linkTo" => "approval_product",
  "equalTo" => "approved"
];
//$products = CurlController::request($url,$method,$fields); 
$products = json_decode(Routes::getDataApi($method, $url, $tabla, $fieldss));
error_log(json_encode($products));

if($products->status == 200){ 

  $products = $products->total;

}else{

$products = 0;

} 

/*=============================================
total de tiendas
=============================================*/
$url = "stores?select=id_store";
//$stores = CurlController::request($url,$method,$fields);
$tabla = "stores";
$fieldss = [
  "select" => "id_store"
];
$stores = json_decode(Routes::getDataApi($method, $url, $tabla, $fieldss));
if($stores->status == 200){ 

$stores = $stores->total;

}else{

$stores = 0;

}  


/*=============================================
total de ventas
=============================================*/ 

$url = "sales?select=id_sale&linkTo=status_sale&equalTo=ok";
//$sales = CurlController::request($url,$method,$fields);
$tabla = "sales";
$fieldss = [
  "select" => "id_sale",
  "linkTo" => "status_sale",
  "equalTo" => "ok"
]; 
$sales = json_decode(Routes::getDataApi($method, $url, $tabla, $fieldss));
if($sales->status == 200){ 

$sales = $sales->total;

}else{

$sales = 0;

} 

/*=============================================
total de usuarios
=============================================*/
$url = "users?select=id_user&linkTo=rol_user&equalTo=default";
//$users = CurlController::request($url,$method,$fields);  
$tabla = "users";
$fieldss = [
  "select" => "id_user",
  "linkTo" => "rol_user",
  "equalTo" => "default"
];

$users = json_decode(Routes::getDataApi($method, $url, $tabla, $fieldss));
if($users->status == 200){ 

$users = $users->total;

}else{

$users = 0;

} 

?>


<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-bag"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Productos</span>
        <span class="info-box-number">
          <?php echo $products ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-store"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Tiendas</span>
        <span class="info-box-number"><?php echo $stores ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Ventas</span>
        <span class="info-box-number"><?php echo $sales ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Usuarios</span>
        <span class="info-box-number"><?php echo $users ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>