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


//setting the conditions for a user to be created
if (isset($_POST["username"]) && isset($_POST["email"])  && isset($_POST["isAdmin"]) && isset($_POST["passcode"]) && isset($_POST["passconfirm"]) ){
    if(!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["passcode"]) && !empty($_POST["passconfirm"]) ){
        if(empty($usernameErr) && empty($emailErr) && empty($isAdminErr) && empty($passErr) && empty($unidenticalpass)){
           
            // set user property values
        $user->username = $username;
        $user->email = $email;
        $user->passcode = $pass;
        $user->isAdmin = $isAdmin;

            // create the user
        if($user->create()){
            echo "<div class='alert alert-success'>User was created.</div>";
        }

        // if unable to create the user, tell the user
        else{
            echo "<div class='alert alert-danger'>Unable to create user.</div>";
        }
 
        //selecting the newly created user
        $stmt = $user->selectOne($email); 
         //fetching statement
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        //logging user in after creating an account
        $_SESSION['id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['message'] = 'You are now logged in';
        $_SESSION['type'] = 'alert alert-success';
        if($isAdmin == '0'){
            header('location: ../../index.php');
        }
        else{
            header('location: admin/index.php');
        }
        exit();
        }
    }
}
  
?>
<!-- HTML form for creating a user -->
<div>
<h3 class = "heading"> Welcome to 5KLuxury :) </h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class = "register-wrapper">
    <div class = "register-inner-wrapper">
        <p><span class = "error">* required field </span></p>

        <span class ="error">*</span>
        <span class ="error"> <?php echo $usernameErr;?></span> 
        <input type='text' id ='username' name='username' value = '<?php echo $username ?>' placeholder = "&#xf007 username" class='form-control textFont' />
       
         <span class ="error">* </span>
        <span class ="error"><?php echo $emailErr;?></span>
        <input type='text' id ='email' name='email' value = '<?php echo $email ?>' placeholder = "&#xf0e0 email" class='form-control textFont' />
        
        <h5 class = "text-wrapper" for="isAdmin">Select user type: <span class ="error">* </span></h5>
        <span class ="error"> <?php echo $isAdminErr;?></span><br/>
        <input type='radio' id='admin' name='isAdmin' value= '1' />
        <label for = 'admin'>Admin User</label>
        <br/>
        <input type='radio' id='user' name='isAdmin' value= '0' />
        <label for = 'user'>Normal User</label>
        <br/>
         <span class ="error">*</span>
        <span class ="error"> <?php echo $passErr;?></span>
        <input type='password' name='passcode' value = '<?php echo $pass ?>' placeholder = "&#61475 password" class='form-control textFont' />
        
        <span class ="error">*</span>
        <span class ="error"><?php echo $unidenticalpass;?></span> 
        <input type='password' name='passconfirm' placeholder = "&#61475 password confirmation" class='form-control textFont'/>
        
        <br/><button type="submit" name="register" id="btn" class="btn btn-big">Register</button>
        <br/><p class="login-redirec"> Or an existing user <a href="<?php echo 'loginUser.php' ?>">LogIn</a></p>

    </div>
</form>
</div>
<?php

  //adding page footer
  //include_once '../../includeFiles/footer.php';
    ?> 
