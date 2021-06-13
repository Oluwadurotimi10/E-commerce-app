<?php 

     // include database and path file
    include_once 'Backend/config/database.php';
    include_once 'path.php';

    //including model files
    include_once(ROOT_PATH.'/BackEnd/models/product.php');
    include_once(ROOT_PATH.'/BackEnd/models/category.php');
    include_once(ROOT_PATH.'/BackEnd/models/user.php');
    include_once(ROOT_PATH.'/BackEnd/models/brand.php');
    include_once(ROOT_PATH.'/BackEnd/models/rating.php');

    //including header
    include_once(ROOT_PATH."/includeFiles/header.php");
    include_once(ROOT_PATH."/includeFiles/messagesPopup.php");

    // instantiate classes and objects
    $database = new Database();
    $db = $database->connect();
    $product = new Product($db);
    $category = new Category($db);
    $ratingg = new Rating($db);

    // query products
    $results = $product->read();
    $num = $results->rowCount();
?>

<!-- creating animation show slide -->
<div class="slidershow-container">
        <div class="slides">  
            <!--indicators-->
            <input type ="radio" name ="radio-btn" id="radio1">
            <input type ="radio" name ="radio-btn" id="radio2">
            <input type ="radio" name ="radio-btn" id="radio3">
            <input type ="radio" name ="radio-btn" id="radio4">

        <!-- wrapper for slides -->
            <div class="image first">
                <img src = 'others/images/park-street-KYUiTYOaE9M-unsplash.jpg' alt = ''>
            </div>
            <div class="image">
                <img src = 'others/images/simple.jpg' alt = ''>
            </div>
            <div class="image">
                <img src = 'others/images/lumin-1mp7rF7_j2I-unsplash.jpg' alt = ''>
            </div>
            <div class="image">
                <img src = 'others/images/valeriia-miller-_42NKYROG7g-unsplash.jpg' alt = ''>
            </div>

        <!-- slide automation -->
        <div class="navigation-auto">
            <div class="auto-btn1"></div>
            <div class="auto-btn2"></div>
            <div class="auto-btn3"></div>
            <div class="auto-btn4"></div>
        </div>
    </div>
        <!-- manual slide -->
        <div class="navigation-manual">
            <label for="radio1" class="manual-btn"></label>
            <label for="radio2" class="manual-btn"></label>
            <label for="radio3" class="manual-btn"></label>
            <label for="radio4" class="manual-btn"></label>
        </div>        
</div>
 
<!--display of products -->

<?php
$array1 = array();
$array2 = array();
$array3 = array();
$array4 = array();
$array5 = array();
if($num>0){ 
    echo "<div class='container'>";
    while ($row = $results->fetch(PDO::FETCH_ASSOC)){
         extract($row);
            if($category_id == 1){
                $array1[] = $row;
            }
            elseif($category_id == 5){
                $array2[] = $row;
            }
            elseif($category_id == 6){
                $array3[] = $row;
            }
            elseif($category_id == 7){
                $array4[] = $row;
            }
            elseif($category_id == 8){
                $array5[] = $row;
            }
         }
     } 
     echo "</div>";

     //pushung each array into another array for easy access
     $arrayall = array($array1, $array2, $array3, $array4, $array5);
     
// displaying each products within their categories
    foreach($arrayall as $key){
     //containers for each category of products
     echo "<div class = 'category-container'>";
     for ($x = 0; $x < count($key); $x++){
        echo "<div class='product-wrapper' id='pd' product-id = '". $key[$x]['id'] ."' onclick = 'viewOne(this)'>";
        echo "<img src ='others/images/".$key[$x]['image']."' alt='' class='post-image'>";
          echo "<p>".$key[$x]['name']."</p>"; 
          echo "<p>₦".$key[$x]['price']."</p>"; 
          echo "<div class ='rating'>";
           //displaying the average rating for each item
           //getting id of item to be rated
           $users_rate = $ratingg->display($key[$x]['id']);
           $num_of_rates  = $users_rate->rowCount();
           $rate = 0;
           while($rates = $users_rate->fetch(PDO::FETCH_ASSOC)){
                extract($rates);
                $rate += $rating;
           }
            //calculating the average rating
           $avg_rating = 0;
           if($rate > 0){
                $avg_rating = $rate / $users_rate->rowCount();
           }
           //displaying the avg rating as starr
        echo "<div class='ratings' data-rating='".$avg_rating."' rate_count='".$num_of_rates."'></div>";
        echo "(".$num_of_rates." ratings)";
          echo "</div>"; 
        echo "</div>";
   }
   echo "</div>";
     }

    /* echo "<div class = 'toner-container'>";
     for ($x = 0; $x < count($array3); $x++){
        //print_r($array1[$x]['image']);
        echo "<div class='product-wrapper' id='pd' product-id = '". $array3[$x]['id'] ."' onclick = 'viewOne(this)'>";
            echo "<img src ='others/images/".$array3[$x]['image']."'alt='' class='post-image'>";    
            echo "<p>".$array3[$x]['name']."</p>"; 
            echo "<p>₦".$array3[$x]['price']."</p>";
        echo "</div>";
    }
    echo "</div>";*/
     //print_r($array[0]);  
 ?>

<!-- automating slide -->
<script type="text/javascript">
var counter = 1;
setInterval(function(){
    document.getElementById('radio'+counter).checked = true;
    counter++;
    if(counter>4){
        counter = 1;
    }
},5000);

// clicking to view a single product
function viewOne(self){
    var views, x, pidd;
    var views = document.querySelectorAll(".product-wrapper");
    var view = document.getElementById("pd");
    //console.log(views[2]);
    for (x = 0; x < views.length; x++){
        view.onclick = function(){
        } 
   }
   var pidd = self.getAttribute("product-id");
   //console.log(pidd);
   window.location.href = "Backend/api/read_one.php?id="+pidd;
} 
</script>
<!-- displaying avg ratings in star form -->
<div class="rating">
<script type="text/javascript">
var ratings = 0; 
var rate_counts;
    $(function(){
        $(".starrr").starrr().on("starrr:change", function(event,value){
            ratings = value;
        });
        var ratings = document.getElementsByClassName('ratings');
        for(var a = 0; a < ratings.length; a++){
            $(ratings[a]).starrr({
                readOnly: true,
                rating: ratings[a].getAttribute("data-rating")
            });
            var rate_counts = ratings[a].getAttribute("rate_count");
        }
    });
</script>
</div>
</body>
</html>
