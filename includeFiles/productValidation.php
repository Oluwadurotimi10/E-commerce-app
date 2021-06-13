<?php 


// defining varaibles and setting them to empty values
      $nameErr = $descriptionErr = $skinTypeErr = $quantityErr = $priceErr = $categoryErr = $brandErr = $imageErr = "";
      $name = $description = $skinType = $quantity = $price = $cate = $brand = $image_name = $image = "";

//if the post form was submitted for creation

if ((isset($_POST['create'])) || (isset($_POST['update']))) {
    //$database->display($_FILES);
    //form validatipn 
    if(empty($_POST['name'])){
        $nameErr = "Product name is required";
    }
    else{
        $name = test_input($_POST['name']);
         }
    
    if(empty($_POST['description'])){
        $descriptionErr = "Brief description of product is required";
    }
    else{
        $description = test_input($_POST['description']);
        }
    
    if(empty($_POST['brand_id'])){
        $brandErr = "Brand name is required";
    }
    else{
        $brand = test_input($_POST['brand_id']);
        }

    if(!isset($_POST['skintype'])){
        $skinTypeErr = "Please select the suitable skintype for this product";
    }
    else{
        foreach ($_POST['skintype'] as $_skintype){
            $checkval[] = $_skintype;
        }
        $skinType = implode(',', $checkval);
    }

    if(empty($_POST['quantity'])){
        $quantityErr = "The quantity of the product is required ";
        }
    else{
        $quantity = test_input($_POST['quantity']);
    }

    if(empty($_POST['category_id'])){
        $categoryErr = "Category of product is required";
    }
    else{
        $cate = test_input($_POST['category_id']);
        }

    if(empty($_FILES['image']['name'])){
        $imageErr = "An image upload is required for this product";
    }
    else{
       $image_name = time() . '_' . $_FILES['image']['name'];
       $image_directory = ROOT_PATH. '/others/images/' . $image_name; 

       $result = move_uploaded_file($_FILES['image']['tmp_name'], $image_directory);

       if($result){
            $_POST['image'] = $image_name;
            $image = $_POST['image'];
       }
       else{
        echo "<div class='alert alert-danger'>Unable to upload image</div>";
       }
    }

    if(empty($_POST['price'])){
        $priceErr = "Product price is required";
    }
    else{
        $price = test_input($_POST['price']);
    }
} 
//validation for category

if ((isset($_POST['create_category'])) || (isset($_POST['create_brand']))){
    if(empty($_POST['name'])){
        $nameErr = "Name is required";
    }
    else{
        $name = test_input($_POST['name']);
         }
 }

//function to enusre the data input is valid and secure        
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}