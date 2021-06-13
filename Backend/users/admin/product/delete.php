<?php
 // check if value was posted
 $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

  
   // include database and object files
   include_once '../../../config/Database.php';
   include_once '../../../../path.php';
   include_once(ROOT_PATH.'/backEnd/models/product.php');
   include_once(ROOT_PATH.'/backEnd/models/category.php');
   include_once(ROOT_PATH.'/backEnd/models/user.php');
   include_once(ROOT_PATH.'/backEnd/models/brand.php');

  
    // get database connection
    $database = new Database();
    $db = $database->connect();
  
    // prepare objects
    $product = new Product($db);
    $category = new Category($db);
    $user = new User($db);
    $b = new Brand($db);

    // set product id to be deleted
    $product->id = $id;


    // set page headers
    include_once(ROOT_PATH.'/includeFiles/header.php');

      
    // delete the post
    if($product->delete()){
        echo "<p class = 'delete-noti'>Product has been deleted</p>";
    }   
    // if unable to delete the post
    else{
        echo "<p class = 'delete-noti'>Unable to delete product</p>";
    }

//include_once '../../includeFiles/footer.php';  
?>
