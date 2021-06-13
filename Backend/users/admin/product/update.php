<?php
// update one post 
    // get ID of the product to be edited
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

    //set ID property of product to be edited
    $product->id = $id;
    
    //read the details of product to be edited
    $product->readOne();

  
// set page headers
include_once(ROOT_PATH.'/includeFiles/header.php');
//including validation
include_once(ROOT_PATH.'/includeFiles/productValidation.php');
  
echo "<button class='read-redirec'><a href='../index.php'>View Products</a></button>";
    
    ?>
        <?php

    //setting the conditions for a post to be updated
    if (isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["skintype"]) && isset($_POST["quantity"])
    && isset($_POST["brand_id"]) && isset($_POST["category_id"]) && isset($_POST["price"])){
        if(empty($nameErr) && empty($descriptionErr) && empty($skintypeErr) && empty($quantityErr) && empty($brandErr)  
        && empty($categoryErr) && empty($priceErr)){

        // set post property values
        $product->name = $name;
        $product->description = $description;
        $product->skin_type = $skinType;
        $product->quantity = $quantity;
        $product->price = $price;
        if(!empty($_POST['image'])){
            $product->image = $image;}
        $product->category_id = $_POST['category_id'];
        $product->brand_id = $_POST['brand_id'];
        
        // update the post
        if($product->update()){
            echo "<div class='alert alert-success alert-dismissable'>";
                echo "Product was updated.";
            echo "</div>";
        }
    
        // if unable to update the post, tell the user
        else{
            echo "<div class='alert alert-danger alert-dismissable'>";
                echo "Unable to update product.";
            echo "</div>";
        }
    } }
     ?>         
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?id={$id}");?>" method='POST' enctype = "multipart/form-data" class ='update-wrapper'>
        <div class ='update-inner-wrapper'>
        <h4 class = "text-wrapper"> Product Name </h4>
        <span class ="error"> <?php echo $nameErr;?></span> 
        <input type='text' id='name' name='name' value = '<?php echo $product->name ?>' class='form-control' />

         <h4 class = 'text-wrapper'>Brand name of product</h4>
         <span class ="error"> <?php echo $brandErr;?></span>
            <?php
                $stmt = $b->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='brand_id'>";
                
                    echo "<option>Please select...</option>";
                    while ($row_brand = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $brand_id=$row_brand['id'];
                        $brand_name = $row_brand['name'];
                
                        // current category of the product must be selected
                        if($product->brand_id==$brand_id){
                            echo "<option value='$brand_id' selected>";
                        }else{
                            echo "<option value='$brand_id'>";
                        }
                        echo "$brand_name</option>";
                    }
                echo "</select>";
                ?>

        <h4 for = "skintype[]" class='text-wrapper'>Select suitable skin type:</h4>
        <span class ="error"> <?php echo $skinTypeErr;?></span>
        <?php
        if ($skinTypeErr){
            echo '</br>';
        }
        $checksub = explode(',',$product->skin_type );
        
        if(in_array("Normal", $checksub)){
         echo '<input type = "checkbox" id = "skintype" name = "skintype[]" value = "Normal" checked>Normal<br/>';
        }
         else {
             echo '<input type = "checkbox" id = "skintype" name = "skintype[]" value = "Normal">Normal<br/>';
         }
        
         if(in_array("Dry", $checksub)){
            echo '<input type = "checkbox" id = "skintype" name = "skintype[]" value = "Dry" checked>Dry<br/>';
        }
         else {
            echo '<input type = "checkbox" id = "skintype" name = "skintype[]" value = "Dry">Dry<br/>';
        }
        
        if(in_array("Oily", $checksub)){
            echo '<input type = "checkbox" id = "skintype" name = "skintype[]" value = "Oily" checked>Oily<br/>';
        }
        else {
            echo '<input type = "checkbox" id = "skintype" name = "skintype[]" value = "Oily">Oily<br/>';
        }
        
        if(in_array("Combination", $checksub)){
            echo '<input type = "checkbox" id = "skintype" name = "skintype[]" value = "Combination" checked>Combination<br/>';
           }
        else {
            echo '<input type = "checkbox" id = "skintype" name = "skintype[]" value = "Combination">Combination<br/>';
        }

        if(in_array("Sensitive", $checksub)){
            echo '<input type = "checkbox" id = "skintype" name = "skintype[]" value = "Sensitive" checked>Sensitive<br/>';
           }
        else {
            echo '<input type = "checkbox" id = "skintype" name = "skintype[]" value = "Sensitive">Sensitive<br/>';
        }
         ?>
    
        <h4 class = 'text-wrapper'>Brief description of product </h4>
        <span class ="error"> <?php echo $descriptionErr;?></span>
        <textarea name='description' class='form-control'><?php echo $product->description; ?></textarea>

        <h4 class = "text-wrapper">Quantity of product</h4>
        <span class ="error"> <?php echo $quantityErr;?></span>
        <input type='text' id='quantity' name='quantity' value = '<?php echo $product->quantity ?>' class='form-control' />

        <h4 class = 'text-wrapper'>Image </h4>
        <input type='file' name='image' class='form-control' />
            
        <h4 class = 'text-wrapper'>Category </h4>
            <?php
                $stmt = $category->read();
                
                // put them in a select drop-down
                echo "<select class='form-control' name='category_id'>";
                
                    echo "<option>Please select...</option>";
                    while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $category_id=$row_category['id'];
                        $category_name = $row_category['name'];
                
                        // current category of the product must be selected
                        if($product->category_id==$category_id){
                            echo "<option value='$category_id' selected>";
                        }else{
                            echo "<option value='$category_id'>";
                        }
                
                        echo "$category_name</option>";
                    }
                echo "</select>";
                    ?>

                <h4 class = 'text-wrapper'>Price of item</h4>
                <span class ="error"> <?php echo $priceErr;?></span>
                <input type='text' id='price' name='price' value = '<?php echo $product->price ?>' class='form-control' />

                <br/><button type='submit' name = 'update' class='btn btn-primary'>Update</button>
                 
    </div>
</form>  
        <?php        

 //adding page footer
    //include_once '../../includeFiles/footer.php';
    ?> 