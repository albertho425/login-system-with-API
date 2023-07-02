<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";


 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM loginusers WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            

                            //add the current datetime to lastlogin

                            // time zone is hard coded to PST
                            date_default_timezone_set("America/Vancouver");
                            $param_lastupdate = date('y-m-d h:i:s');
                            

                            $sql = "UPDATE loginusers SET lastlogin = ? WHERE id = ?";
                            
                                                        
                            if($stmt = $mysqli->prepare($sql)){
                                // Bind variables to the prepared statement as parameters
                                // sssi stands for string and integer
                                $stmt->bind_param("si", $param_lastlogin, $param_id);
                                // $stmt->bind_param("s", $param_id);
                            

                                // Set parameters
                                
                                // time zone is hard coded to PST
                                // date_default_timezone_set("America/Vancouver");
                                $param_lastupdate = date('y-m-d h:i:s');
                                $param_id = $_SESSION["id"];
                                
                            }

            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>
<!-- load tags, CSS, and Bootstrap -->
<?php require 'template-parts/header.php'; ?>
<body>
    <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <div class="login-form">
        <?php 
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
        ?>
        <form class="validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            <div class="form-group">
                <h5 class="text-center">Login System with API</h5>                
                <div class="col text-center"><br>
                    <a href="index.php"><img class="signup-icon" src="images/login.png"/></a>
                </div><br>
            </div>  
             
            <div class="form-group">  
                <label class="form-margin-top"></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <div class="input-group-text"><i class="bi bi-person-circle"></i></i></div>
                    </div>
                    <input class="form-control" type="text" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
                    <div class="valid-feedback text-end"></div>
                    <div class="invalid-feedback text-end">Username field cannot be blank</div>            
                </div>
            </div>
            <div class="form-group">
                <label class="form-margin-top"></label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    <div class="valid-feedback text-end"></div>
                    <div class="invalid-feedback text-end">Password field cannot be blank</div>
                 </div>
            </div>
            <div class="col text-center">
              <div class="d-grid gap-1 p-1">
                  <input type="submit" class="btn btn-primary form-margin-top mb-1" value="Login">
                  <a href="register.php" class="text-center btn btn-warning">Register</a>
              </div>
            </div>
    
            <div class="col text-center">
              <div class="login-row form-nav-row p-3">
                <p>Or sign up with:</p>
                <a href="#"><img src="images/apple.png"
                  class="signup-icon" /></a>
                <a href="#"><img src="images/facebook.png"
                  class="signup-icon" /></a>
                  <a href="#"><img src="images/google.png"
                  class="signup-icon" /></a>
                
            </div>
          </div>
          <div class="col text-center p-1">
            <p>Forget password? <a href="#">Reset password</a>.</p>
          </div>
        </form>

        </div>
    </div>

<?php require 'template-parts/footer.php'; ?>