<?php
    
    // include database and object files
    include_once '../../../config/Database.php';
    include_once '../../../../path.php';
    include_once(ROOT_PATH.'/backEnd/models/product.php');
    include_once(ROOT_PATH.'/backEnd/models/category.php');
    include_once(ROOT_PATH.'/backEnd/models/user.php');
    
    // get database connection
    $database = new Database();
    $db = $database->connect();
    
    // prepare objects
    $post = new Product($db);
    $category = new Category($db);
    $user = new User($db);

// set page headers
include_once(ROOT_PATH.'/includeFiles/header.php');
//including validation
include_once(ROOT_PATH.'/includeFiles/productValidation.php');
  
echo "<button class='view-products-redirec'><a href='../index.php'>View Products</a></button>";
  

    
    //setting the conditions for a post to be created
if (isset($_POST["name"]) && !empty($_POST["name"]) && empty($nameErr)) {
              
        // set product property values
        $category->name = $name;
        $category->admin_id = $_SESSION['id'];
    
        // create the category
        if($category->create()){
            echo "<div class='alert alert-success'>Category was added.</div>";
        }
    
        // if unable to create the post, tell the user
        else{
            echo "<div class='alert alert-danger'>Unable to add category.</div>";
        }
    } 
?>
 
<!-- HTML form for creating a post -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class = "category-wrapper">
<div class = "category-inner-wrapper">

            <h4 class = "text-wrapper"> Category Name </h4>
            <span class ="error"> <?php echo $nameErr;?></span> 
            <input type='text' id='name' name= 'name' value = '<?php echo $name ?>' class='form-control' />
            <?php
            echo "<br/><button type='submit' name='create_category'  class='btn btn-primary form-control'>Add Category</button>";
            ?>
           </div>
</form>
  
<?php

  //adding page footer
  //include_once '../../includeFiles/footer.php';
    ?> 