<?php 

     // include database and path file
    include_once '../../config/database.php';
    include_once '../../../path.php';

    //including model files
    include_once(ROOT_PATH.'/BackEnd/models/product.php');
    include_once(ROOT_PATH.'/BackEnd/models/category.php');
    include_once(ROOT_PATH.'/BackEnd/models/user.php');
    include_once(ROOT_PATH.'/BackEnd/models/brand.php');

    //including header
    include_once(ROOT_PATH."/includeFiles/header.php");
    include_once(ROOT_PATH."/includeFiles/messagesPopup.php");

    // instantiate classes and objects
    $database = new Database();
    $db = $database->connect();

    $product = new Product($db);
    $category = new Category($db);
    $user = new User($db);
    $b = new Brand($db);

    // query products
    $results = $product->read();
    $num = $results->rowCount();

    //button for creating post
    echo "<div class='right-button-margin'>
    <a href='product/create.php' class='btn btn-default pull-left'>Add Product</a>
    </div>";

    echo "<div class='right-button-margin'>
    <a href='categories/create_category.php' class='btn btn-default pull-left'>Add Category</a>
    </div>";

    echo "<div class='right-button-margin'>
    <a href='brand/create_brand.php' class='btn btn-default pull-left'>Add Brand</a>
    </div>";

    if($num>0){ 
        echo "<table id = 'myTable' class = 'table table-hover table-responsive table-bordered'>";
            echo "<tr>";
                //echo "<th> ID </th>";
                echo "<th> Product name </th>";
                echo "<th> Time product was added </th>";
                echo "<th> Time product was modified </th>";
                echo "<th> Edit </th>";
                echo "<th> Delete </th>";
            echo "</tr>";

        while ($row = $results->fetch(PDO::FETCH_ASSOC)){
             extract($row);
                if ($_SESSION['id'] == $admin_id){
                
                echo "<tr>";
                //echo "<td id = 'idd'>{$id}</td>";
                echo "<td class = 'title-wrapper'>{$name}</td>";
                echo "<td> {$created_at}</td>";
                echo "<td> {$modified_at}</td>";
                echo "<td>
                        <a href='product/update.php?id={$id}'>
                        <button class='btn btn-info'>Edit</button></a>
                    </td>";
                echo "<td>";
                //echo "<input type='hidden' id = 'delete_id' value = '{$id}'>";
                echo  "<button type = 'button' id = 'delbtn'  class='btn btn-danger delbtn' product-id = '{$id}' onclick = 'confirmDelete(this)' > Delete </button>
                    </td>";
                echo "</tr>";
            } 
        }
        echo "</table>";
         }  
    else{
        echo "No products found";
    }
    
    
    //delete popup modal (BOOSTRAP MODAL)

    ?> 

<!-- the modal --> 
<div id ="modalWhole" class = "modal">
    <!-- modal content --> 
    <div class = "modal-content" >
        <div class = "modal-header">
            <span class = "close">&times;</span>
            <h4>Delete Confirmation </h4>    
        </div> 

        
        <form  method = 'POST' >
            <input type='hidden' id = 'product_id' name='product_id'> 
            <div class="modal-body">
                <p> Are you sure you want to delete this product?</p>
            </div>
            <div class = "modal-footer">
                <button type = "button" id =  "nobtn" class = "btn btn-secondary" data-dismiss ="modal"> NO </button>
                <button type = "reset" id = "del" class = "btn btn-secondary" data-dismiss ="modal"> YES </button>
            </div>
        </form>
    </div> 
</div>
<!--Jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

<script>
function confirmDelete(self){
     //getting the modal
   var modall = document.getElementById("modalWhole");
   
   //getting the button that opens the modal
   var x;
   var btn = document.querySelectorAll(".delbtn");
   for (x = 0; x < btn.length; x++){
    //activity when delbtn is clicked
       modall.style.display = "block";
   }
   var nobtn = document.getElementById("nobtn");
   
   //getting the <span> element that closes the modal
   var xclose = document.getElementsByClassName("close")[0];
   
   //getting the id of product to be deleted
   $("#del").on("click",function(){
        //e.preventDefault();
        var pidd = self.getAttribute("product-id");
        //console.log(pidd);
        window.location.href = "product/delete.php?id="+pidd;
   });
 
   //activity when x is clicked
   xclose.onclick = function(){
       modall.style.display = "none";
       var pidd = '';
   }

   //activity when no is clicked
   nobtn.onclick = function(){
       modall.style.display = "none";
       var pidd = '';
   }
}
</script> 
</body>
</html>