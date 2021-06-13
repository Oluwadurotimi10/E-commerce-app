<?php 

     // include database and path file
    include_once 'Backend/config/database.php';
    include_once 'path.php';

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
</script>
</body>
</html>
