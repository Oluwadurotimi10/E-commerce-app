<?php
    
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

// set page headers
include_once(ROOT_PATH.'/includeFiles/header.php');
//including validation
include_once(ROOT_PATH.'/includeFiles/productValidation.php');
  
echo "<button class='read-redirec'><a href='../index.php'>View Products</a></button>";

echo "<button class='read-redirec'><a href='../brand/create_brand.php'>Add Brand</a></button>";

echo "<button class='read-redirec'><a href='../categories/create_category.php'>Add Category</a></button>";
  

    
    //setting the conditions for a post to be created
if (isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["skintype"]) && isset($_POST["quantity"])
&& isset($_POST["brand_id"]) && isset($_POST["category_id"]) && isset($_POST["price"]) 
 && isset($_FILES['image']['name'])){
    if(!empty($_POST["name"]) && !empty($_POST["description"]) && !empty($_POST["skintype"]) && !empty($_POST["quantity"]) 
    && !empty($_POST["price"]) && !empty($_POST["brand_id"]) && !empty($_POST["category_id"])
     && !empty($_FILES['image']['name'])){
        if(empty($nameErr) && empty($descriptionErr) && empty($skintypeErr) && empty($quantityErr) && empty($brandErr)  
        && empty($categoryErr) && empty($priceErr) && empty($imageErr)){
              
        // set product property values
        $product->name = $name;
        $product->description = $description;
        $product->skin_type = $skinType;
        $product->quantity = $quantity;
        $product->price = $price;
        $product->image = $image;
        $product->admin_id = $_SESSION['id'];
        $product->category_id = $_POST['category_id'];
        $product->brand_id = $_POST['brand_id'];
    
        // create the product
        if($product->create()){
            echo "<div class='alert alert-success'>Product was added.</div>";
        }
    
        // if unable to create the post, tell the user
        else{
            echo "<div class='alert alert-danger'>Unable to add product.</div>";
        }
    }
}
} 
?>
 
<!-- HTML form for creating a post -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype = "multipart/form-data" class = "create-wrapper">
<div class = "create-inner-wrapper">
            <h4 class = "text-wrapper"> Product Name </h4>
            <span class ="error"> <?php echo $nameErr;?></span> 
            <input type='text' id='name' name='name' value = '<?php echo $name ?>' class='form-control' />

            <h4 class = "text-wrapper">Brand name of product </h4>
            <span class ="error"> <?php echo $brandErr;?></span>
            <?php
                // read the brand names from the database
                $stmt = $b->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='brand_id'>";
                    echo "<option value =''>Select product brand...</option>";
                
                    while ($row_brand = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row_brand);
                        echo "<option value='{$id}'>{$name}</option>";
                    }
                echo "</select>";
                ?>
            
            <h4 for = "skintype[]" class='text-wrapper'>Select suitable skin type:</h4>
            <span class ="error"> <?php echo $skinTypeErr;?></span>
            <?php
            if ($skinTypeErr){
                echo '</br>';
            }
            ?>
            <input type = "checkbox" id = "skintype" name = "skintype[]" value = "Normal">Normal<br/>
            <input type = "checkbox" id = "skintype" name = "skintype[]" value = "Dry">Dry<br/>
            <input type = "checkbox" id = "skintype" name = "skintype[]" value = "Oily">Oily<br/>
            <input type = "checkbox" id = "skintype" name = "skintype[]" value = "Combination">Combination<br/>
            <input type = "checkbox" id = "skintype" name = "skintype[]" value = "Sensitive">Sensitive<br/>
            
            <h4 class = 'text-wrapper'>Brief description of product</h4>
            <span class ="error"> <?php echo $descriptionErr;?></span>
            <textarea name='description' class='form-control'><?php if(!empty($_POST["description"])){ echo $description; } ?></textarea>

            <h4 class = "text-wrapper">Quantity of product</h4>
            <span class ="error"> <?php echo $quantityErr;?></span>
            <input type='text' id='quantity' name='quantity' value = '<?php echo $quantity ?>' class='form-control' />

            <h4 class = "text-wrapper">Image </h4>
            <span class ="error"> <?php echo $imageErr;?></span>
            <input type='file' name='image' class='form-control' />

            <h4 class = "text-wrapper">Category of product </h4>
            <span class ="error"> <?php echo $categoryErr;?></span>

            <?php
                // read the categories from the database
                $stmt = $category->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='category_id'>";
                    echo "<option value = ''>Select product category...</option>";
                
                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row_category);
                        echo "<option value='{$id}'>{$name}</option>";
                    }
                echo "</select>";
                ?>

            <h4 class = 'text-wrapper'>Price of item</h4>
            <span class ="error"> <?php echo $priceErr;?></span>
            <input type='text' id='price' name='price' value = '<?php echo $price ?>' class='form-control' />
            
            <br/><button type='submit' name='create'  class='btn btn-primary'>Create</button>
                
           </div>
</form>
  
<?php

  //adding page footer
  //include_once '../../includeFiles/footer.php';
    ?> 