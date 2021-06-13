<?php 

    // get ID of the product to be viewed
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

     // include database and path file
    include_once '../config/database.php';
    include_once '../../path.php';
    //ensures session is empty
    //session_destroy();  
    //including model files
    include_once(ROOT_PATH.'/BackEnd/models/product.php');
    include_once(ROOT_PATH.'/BackEnd/models/category.php');
    include_once(ROOT_PATH.'/BackEnd/models/user.php');
    include_once(ROOT_PATH.'/BackEnd/models/brand.php');
    include_once(ROOT_PATH.'/BackEnd/models/rating.php');

    //including header
    include_once(ROOT_PATH."/includeFiles/header.php");

    // instantiate classes and objects
    $database = new Database();
    $db = $database->connect();
    $product = new Product($db);
    $category = new Category($db);
    $rating = new Rating($db);

    // set ID property of post to be read
    $product->id = $id;
    
    // read the details of post to be read
    $product->readOne();

    //including header
    include_once(ROOT_PATH."/includeFiles/header.php");
    include_once(ROOT_PATH."/includeFiles/messagesPopup.php");

    //ensures user is logged in
    if(isset($_SESSION['id'])){
        echo "<div class = 'Rone-wrapper'>";
            echo "<div class = 'Rone-image'>";
                echo "<img src ='../../others/images/{$product->image}' alt='' class='post-image'>";
            echo "</div>";
            echo "<div class = 'Rone-rightside'>";
                echo "<p><b>{$product->name}</b></p>";
                    echo "<div class = 'Rone-brand'>";
                        echo "<h5>Brand</h5>";
                        echo "<p><b>{$product->brand_name}</b></p>";
                    echo "</div>";
                echo "<p>₦{$product->price}</p>";
                //making the skintypes as an array
                $skintype_arr = explode(",",$product->skin_type);
                if (count($skintype_arr) == 2){ 
                    echo "<span class ='Type Stype1'>".$skintype_arr[0]. "</span>";
                    echo "<span class ='Type Stype2'>".$skintype_arr[1]. "</span>";
                }
                else{
                echo "<span class ='Type Stype1'>".$skintype_arr[0]. "</span>";
                }
                echo "<h4>Rate this item</h4>";
                echo "<div class ='rating'>";
                ?>
                <!-- star ratings -->
                <form method="POST" onsubmit="return saveRatings(this);">
                    <input type='hidden' name='product_id' value="<?php echo $product->id ?>">
                        <div class='starrr'>
                        </div>
                    <button type="submit" name="rate"> Rate </button>
                </form>
                
                <div class = "ratings"></div>
                <script type="text/javascript">
                    var ratings = 0; 
                    $(function(){
                        $(".starrr").starrr().on("starrr:change", function(event,value){
                            ratings = value;
                        });
                    });

                    function saveRatings(form){
                        var product_id = form.product_id.value;

                        $.ajax({
                            url:"save-ratings.php",
                            method: "POST",
                            data:{
                                "product_id":product_id,
                                "rating": ratings
                            },
                            success: function (response){
                                alert(response);
                            }
                        });
                        return false;
                    }
                </script> 

            <?php
                echo "</div>";
            echo "<div class='addToCart'>";
                echo "<button class='form-control cart' id='cart' product-id='{$product->id}' onclick='AddToCart(this)'> Add to cart </button>";
            echo "</div>";
            echo "</div>";
            
            echo "<div class = 'Rone-description'>";
                echo "<h3><b>Description</b></h3>";
                echo "<p>{$product->description}</p>";
            echo "</div";
        echo "</div";
            }
    else{
        echo "<div class = 'alert alert-danger'> Please ensure you are logged in </div>";
    }

    //saving items in cart using session
$product_ids =array();
//checking if add to cart button has been clicked
if(isset($_POST['add'])){
    if(isset($_SESSION['shopping_cart'])){

        //to get the number of products in the session cart
        $count = count($_SESSION['shopping_cart']);
        //echo $count;
        //getting the ids of the products in the cart
        $product_ids = array_column($_SESSION['shopping_cart'], 'id');
        //pre_r($product_ids);
        //checking if item is not in cart already
        if(!in_array($_POST['pid'],$product_ids)){

            $_SESSION['shopping_cart'][$count] = array(
            'id' => $_POST['pid'],
            'user_id' => $_SESSION['id'],
            'name' => $_POST['pname'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity']
            );
            echo "<script>alert('Product has been added to cart')</script>";
        }
        else{
         //increasing quantity if item is in cart
         for ($i = 0; $i < count($product_ids); $i++){
             if($product_ids[$i] == $_POST['pid']){
                 $_SESSION['shopping_cart'][$i]['quantity'] += $_POST['quantity'];
             }
         }
         echo "<script>alert('Product quantity has been increased')</script>";
     }
}
    else{//if shopping cart does not exist
        $_SESSION['shopping_cart'][0] = array(
            'id' => $_POST['pid'],
            'user_id' => $_SESSION['id'],
            'name' => $_POST['pname'],
            'price' => $_POST['price'],
            'quantity' => $_POST['quantity']
        );
        echo "<script>alert('Product has been added to cart')</script>";
    }
 }  
//pre_r($_SESSION);

 function pre_r($array){
     echo "<pre>";
     print_r($array);
     echo "</pre>";
 }
/*$quantity_data = $product->quantity;

//initializing the variables
$quantity = $quantityErr ="";
//validating if the quantity being added to cart is available
if (isset($_POST['add'])){
    if($_POST['quantity'] > $quantity_data){
        $quantityErr = "The quantity required is above the one available";
    }
    else{
        $quantity = $_POST['quantity'];
    }
}

//redirecting to add to cart page
if(isset($_POST['quantity']) && empty($quantityErr) && !empty($_POST['quantity'])){
    $cart_quantity = $quantity;
    $product_id = $product->id;
    header('location: add_to_cart.php?id='.$product_id);
}*/
     ?>

<!-- add to cart modal -->
<div id= "modalWhole" class="modal">
    <!-- modal content --> 
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h4> Add product to cart </h4>
        </div>
        <!-- form to enter quantity and add to cart -->
        <form action="read_one.php?id=<?php echo $product->id ?>" method="POST">
            <div class="modal-body">
                <h4> Please enter the product quantity </h4>
                <input type="hidden" id ="pid" name="pid" value = "<?php echo $product->id ?>" >
                <input type="hidden" id ="pname" name="pname" value = "<?php echo $product->name ?>" >
                <input type="hidden" id ="price" name="price" value = "<?php echo $product->price ?>" >
                <input type="text" id="quantity" name="quantity"  class="form-control" />
            </div>
            <div class="modal-footer">
                <button type="submit" name="add" id="add" class="btn btn-secondary" data-dismiss="modal"> ADD </button>
            </div>
        </form>
    </div>
</div>
    
<script type="text/javascript">
    function AddToCart(self){
        //getting the modal
        var modall = document.getElementById('modalWhole');
        //button that opens modal
        var btn = document.querySelectorAll(".cart");
        for( var x = 0; x < btn.length; x++){
            //when cart btn is clicked
            modall.style.display = "block";
        }

        //span element that closes the modal
        var xclose = document.getElementsByClassName('close')[0];
        
        //when the x in the span tag is clicked
        xclose.onclick = function(){
            modall.style.display = "none";
            //resets the product id
            var pid = '';
        }
    }
</script>

<!--
//getting id of product to be deleted 
        $("#add").on("click",function(){
            var pid = self.getAttribute("product-id"); 
            
            //redirect to the cart page
            //window.location.href = "add_to_cart.php?id="+pid+"&quantity=2";
            $.ajax({
                url: 'add_to_cart.php',
                type: 'POST',
                data:{
                    "product_id": pid,
                    "quantity": quantity
                },
                success: function (data){
                    console.log(data);
                           // window.location.href = window.location.href=obj.url;
                            }
                        });   
        }); -->