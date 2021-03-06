<?php
    
// include database and object files
include_once '../config/database.php';
include_once '../../path.php';
include_once '../models/user.php';

// get database connection
$database = new Database();
$db = $database->connect();

// prepare objects
$user = new User($db);

// set page headers
include_once '../../includeFiles/header.php';


//including validation
include_once '../../includeFiles/validation.php';

//setting the conditions for a user to be logged in
if (isset($_POST["email"]) && isset($_POST["passcode"])){
    if(!empty($_POST["email"]) && !empty($_POST["passcode"])){
        if(empty($emailErr) && empty($passErr)){
            
        //checking if the logged in user exists

        $existingUser = $user->selectOne($email);
        $count = $existingUser->rowCount();
         
        if($count > 0){
            //fetching statement
            $row = $existingUser->fetch(PDO::FETCH_ASSOC);
            extract($row);
            if(password_verify($pass,$passcode)){

            //logging user in
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['message'] = 'You are now logged in';
                $_SESSION['type'] = 'alert alert-success';
                header('location: ../../index.php');
                exit(); }
        }
        echo "<div class='alert alert-danger'>Please ensure you are registered and your password is correct!</div>"; 
       
        } 
    }
}

?>
<!-- HTML form for logging in a user -->
<div>
<h3 class = "heading"> Welcome Back :) </h3>
<br/>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class = "login-wrapper">
    <div class = "login-inner-wrapper">
        <br/>
        <span class ="error"><?php echo $emailErr;?></span>
        <input type='text' id ='email' name='email' value = '<?php echo $email ?>' placeholder = "&#xf0e0 email" class='form-control textFont' />
        <br/>
        <span class ="error"> <?php echo $passErr;?></span>
        <input type='password' name='passcode' placeholder = "&#61475 password" class='form-control textFont' />

        <br/><button type="submit" name="login" id="btn" class="form-control btn btn-big">LogIn</button>
        <br/><p class="register-redirec"> Or a new user <a href="<?php echo 'register.php' ?>">SignUp</a></p>
    
        </div>
       

        <!-- form which starts password recovery process is below -->
        <?php
        /*
        if(isset($_GET['newpwd'])){
            if($_GET['newpwd'] == "passupdated"){
                echo "<p class='reset-success'> Your password has been reset! </p>";
            }
        }*/
        ?>
        <!--<div class="forgotpass"><a href="index.php"> Forgot your password?</a></div>-->
        </form>
    </div>

    <?php

//adding page footer
//include_once '../../includeFiles/footer.php';
  ?> 