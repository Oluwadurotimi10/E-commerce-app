<header>
    <div class="navbar">
        <div class="start">
            <div class ="logo"><h2 class = "logo-text">5kLuxury</h2></div>
            <div class = "search" >
               <?php 
            // search_template contains the search form 
            include_once(ROOT_PATH. "/Backend/api/search_template.php"); 
            ?>      
            </div> 
        </div>
        <ul class = "options">
            <!--conditions for when a user is logged in-->
            <?php if(isset($_SESSION['id'])): ?>
            <li><a href="#">
                <?php echo $_SESSION['username']; ?>
            <?php else: ?>
           <li> <a href="#" class="signup">
                Sign Up / Sign In
            <?php endif;?>
            <i class= "fa fa-user" ></i> 
            <span class="drop"><i class="fa fa-chevron-down"></i></span>
        </a>
            <ul class = "dropdown">
                <?php if(!isset($_SESSION['id'])): ?>
                <li><a href = "<?php echo BASE_URL .'/Backend/users/register.php'?>"> SignUp </a></li>
                <?php endif;?>
                <li><a href = "<?php echo BASE_URL .'/Backend/users/loginUser.php'?>"> Login User </a></li>
                <li><a href = "<?php echo BASE_URL .'/Backend/users/admin/login.php'?>"> Login Admin </a></li>
                <li><a href = "<?php echo BASE_URL .'/BackEnd/users/logout.php'?>" class="logout"> Logout</a></li>
            </ul>
            </li>
        </ul>     
        <ul class = "menu" id = "js-menu">
        <li ><a href="<?php echo BASE_URL .'/index.php' ?>" class="list active">Home</a></li>
        <li ><a href="" class="list active">Women</a></li>
        <li ><a href="" class="list active">Men</a></li>
        <li ><a href="" class="list active">Gifts</a></li>
        <li ><a href="" class="list active">Services</a></li>
        <li ><a href="" class="list active">Brands</a></li>
        </ul>  
    </div>
</header>