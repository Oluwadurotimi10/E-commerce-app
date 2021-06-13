<?php
    
    // include database and object files
    include_once '../../../config/Database.php';
    include_once '../../../../path.php';
    include_once(ROOT_PATH.'/backEnd/models/user.php');
    include(ROOT_PATH.'/backEnd/models/brand.php');
    
    // get database connection
    $database = new Database();
    $db = $database->connect();
    
    // prepare object
    $b = new Brand($db);

// set page headers
include_once(ROOT_PATH.'/includeFiles/header.php');
//including validation
include_once(ROOT_PATH.'/includeFiles/productValidation.php');
  
echo "<button class='view-products-redirec'><a href='../index.php'>View Products</a></button>";
     
    //setting the conditions for a post to be created
if (isset($_POST["name"]) && !empty($_POST["name"]) && empty($nameErr)) {
              
        // set product property values
        $b->name = $name;
        $b->admin_id = $_SESSION['id'];
    
        // create the category
        if($b->create()){
            echo "<div class='alert alert-success'>Brand was added.</div>";
        }
    
        // if unable to create the post, tell the user
        else{
            echo "<div class='alert alert-danger'>Unable to add brand.</div>";
        }
    } 
?>
 
<!-- HTML form for creating a post -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class = "brand-wrapper">
<div class = "brand-inner-wrapper">

            <h4 class = "text-wrapper"> Brand Name </h4>
            <span class ="error"> <?php echo $nameErr;?></span> 
            <input type='text' id='name' name= 'name' value = '<?php echo $name ?>' class='form-control' />
            <?php
            echo "<br/><button type='submit' name='create_brand'  class='btn btn-primary form-control'>Add Brand</button>";
            ?>
           </div>
</form>
  
<?php

  //adding page footer
  //include_once '../../includeFiles/footer.php';
    ?> 