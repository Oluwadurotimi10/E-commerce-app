<nav>
    <div class="navbar">
        <div class="start">
            <div class ="logo"><h2 class = "logo-text">5kLuxury</h2></div>
        <ul class = "menu" id = "js-menu">
            <li ><a href="<?php echo BASE_URL .'/index.php' ?>" class="list active">Home</a></li>
            <li ><a href="" class="list">About</a></li>
            <li ><a href="" class="list">Gifts</a></li>
            <li ><a href="" class="list">Brands</a></li>
            <li ><a href="" class="list">Contact</a></li>
        </ul>
        </div>
        <div class="intro">  
            <ul class = "options">
                <!--conditions for when a user is logged in-->
                <?php if(isset($_SESSION['id'])): ?>
                <li class="drop"><a href="#">
                    <?php echo $_SESSION['username']; ?>
                <?php else: ?>
                <li class="drop"> <a href="#" class="signup">
                    Sign Up / Sign In
                <?php endif;?>
                <i class= "fa fa-user" ></i> 
                <span><i class="fa fa-chevron-down"></i></span>
            </a>
                <ul class = "dropdown">
                    <?php if(!isset($_SESSION['id'])): ?>
                    <li><a href = "<?php echo BASE_URL .'/Backend/users/register.php'?>"> SignUp </a></li>
                    <?php endif;?>
                    <li><a href = "<?php echo BASE_URL .'/Backend/users/loginUser.php'?>"> Login User </a></li>
                    <li><a href = "<?php echo BASE_URL .'/Backend/users/admin/login.php'?>"> Login Admin </a></li>
                    <li><a class="logout" href = "<?php echo BASE_URL .'/BackEnd/users/logout.php'?>"> Logout</a></li>
                </ul>
                <li class="cart"><a href="<?php echo BASE_URL .'/Backend/api/add_to_cart.php' ?>"><i class="fas fa-shopping-cart">CART</i></a></li>
            </ul>
        </div>      
    </div>
</nav>