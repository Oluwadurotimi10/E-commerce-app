<?php

 // include database and path file
 include_once '../config/database.php';
 include_once '../../path.php';

 include_once(ROOT_PATH.'/BackEnd/models/rating.php');

$product_id =  $_POST['product_id'];
$rating = $_POST['rating'];

// instantiate classes and objects
$database = new Database();
$db = $database->connect();
$ratingg = new Rating($db);

$ratingg->user_id = $_SESSION['id'];
$ratingg->product_id = $product_id;
$ratingg->rating = $rating;

//inserts the rating into the database
//checking if the user has rated the product before
//checking if the user has rated this product
$stmt_of_rates = $ratingg->display($ratingg->product_id);
$num_of_rates = $stmt_of_rates->rowCount();
//creating array to put users that have rated the product
$users_rated = array();

if ($num_of_rates > 0){
    while($user_rated =  $stmt_of_rates->fetch(PDO::FETCH_ASSOC)){
        extract($user_rated);
        $users_rated[] = $user_id;
    }}
    if(in_array($ratingg->user_id, $users_rated)){
        echo "<div class='alert alert-danger'>Please you have rated this item before!</div>"; 
        }
    else{
        // input user rating
        if($ratingg->rate()){
            echo "<div class='alert alert-success'>You have rated this item.</div>";
        }
        // if unable to rate product, tell the user
        else{
            echo "<div class='alert alert-danger'>You're unable to rate this item.</div>";
        }
}


/*
<?php
                    //checking if the user has rated this product
                    $stmt_of_rates = $rating->display($product->id);
                    $num_of_rates = $stmt_of_rates->rowCount();
                    //creating array to put users that have rated the product
                    $users_rated = array();

                    if ($num_of_rates > 0){
                        while($user_rated =  $stmt_of_rates->fetch(PDO::FETCH_ASSOC)){
                            extract($user_rated);
                            $users_rated[] = $user_id;
                        }
                        if(in_array($_SESSION['id'], $users_rated)){
                            echo "<div class='alert alert-danger'>Please you have rated this item before!</div>"; 
                        }
                        else{*/
?> 