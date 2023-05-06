<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$firstname = $lastname = $username =  $email = $password = $confirm_password = "";
$login_err = $firstname_error = $lastname_error = $email_error = $username_error = $password_error = $confirm_password_error = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_error = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_error = "Username can only contain letters, numbers, and underscores.";
        $login_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM loginusers WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_error = "This username is already taken.";
                    
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later";
                $login_err = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_error = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_error = "Password must have atleast 6 characters.";
        
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_error = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_error) && ($password != $confirm_password)){
            $confirm_password_error = "Password did not match.";        }
    }

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_error = "Please enter a email.";     
    } else{
        $email = trim($_POST["email"]);
        
    }

    // Validate First name
    if(empty(trim($_POST["firstname"]))){
        $firstname_error = "Please enter a first name.";  
        $login_err = "Please enter a first name.";      
    } else{
        $firstname = trim($_POST["firstname"]);
        
    }

    // Validate Last name
    if(empty(trim($_POST["lastname"]))){
        $lastname_error = "Please enter a last name.";     
        $login_err = "Please enter a last name.";  
    } else{
        $lastname = trim($_POST["lastname"]);
        
    }
    
    // Check input errors before inserting in database
    if(empty($firstname_error) && empty($lasttname_error) && empty($email_error) && empty($username_error) && empty($password_error) && empty($confirm_password_error)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO loginusers (firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss", $param_firstname, $param_lastname, $param_email, $param_username, $param_password);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
        
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: welcome.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
                $login_err = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<head>    
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">     
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
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
                <h6 class="text-center">Register</h6>                
                <div class="col text-center">
                    
                </div><br>
            </div>  
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        
                        <label class="form-margin-top"></label>
                        <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $firstname; ?>" placeholder="First name" required>
                        <span class="invalid-feedback"><?php echo $firstname_error; ?></span>

                        <div class="valid-feedback text-beginning"></div>
                        <div class="invalid-feedback text-beginning">First name field cannot be blank
                        </div>              
                    </div>
                </div>
                <div class="col">    
                    <div class="form-group">
                        <label class="form-margin-top"></label>
                        <input type="text" name="lastname" 
                        id="lastname"
                        class="form-control" value="<?php echo $lastname; ?>" placeholder="Last name" required>
                        <div class="valid-feedback text-beginning"></div>
                            <div class="invalid-feedback text-beginning">Last name field cannot be blank
                            </div>
                    </div>    
                </div>
                <!-- row -->
            </div>
                <div class="form-group">
                    <label class="form-margin-top"></label>
                    <div class="input-group">
                            <div class="input-group-addon">
                                <div class="input-group-text"><i class="bi bi-person-circle"></i></i></div>
                            </div>
                    
                    <input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>" placeholder="Username" required>
                    <span class="invalid-feedback"><?php echo $username_error; ?></span>
                    <div class="valid-feedback text-beginning"></div>
                    <div class="invalid-feedback text-beginning">Username field cannot be blank</div></div>     
                </div>    
                <div class="form-group">
                    <label class="form-margin-top"></label>
                    <div class="input-group">
                            <div class="input-group-addon">
                                <div class="input-group-text"><i class="bi bi-envelope"></i></div>
                            </div>
                        
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>" placeholder="Email"required>
                    <span class="invalid-feedback"><?php echo $email_error; ?></span>
                    <div class="valid-feedback text-beginning"></div>
                    <div class="invalid-feedback text-beginning">Email field cannot be blank</div> </div>
                </div>    
                <div class="form-group">
                    <label class="form-margin-top"></label>
                    <div class="input-group">
                    <div class="input-group-addon">
                                <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                            </div>
                    <input type="password" name="password" id="password" class="form-control" value="<?php echo $password; ?>" placeholder="Password" required>
                    <span class="invalid-feedback"><?php echo $password_error; ?></span>
                    <div class="valid-feedback text-beginning"></div>
                    <div class="invalid-feedback text-beginning">Password field cannot be blank</div>
                </div></div>

                <div class="form-group">
                    <label class="form-margin-top"></label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                        </div>
                    <label class="form-margin-top"></label>
                    <input type="password" name="confirm_password" id="confirm_password"
                    class="form-control" value="<?php echo $confirm_password; ?>" placeholder="Confirm password" required>
                    <span class="invalid-feedback"><?php echo $confirm_password_error; ?></span>
                    <div class="valid-feedback text-beginning"></div>
                    <div class="invalid-feedback text-beginning">Confirm Password field cannot be blank</div>
                    </div>
                </div>

                
        
            <div class="col text-center">
              <div class="d-grid gap-1 p-1">
                  <input type="submit" class="btn btn-primary form-margin-top mb-1" value="Submit">
                  <input type="reset" class="text-center btn btn-warning" value="Reset">  
              </div>
            </div>
        
            <div class="col text-center">
              <div class="login-row form-nav-row p-3">
                <p>Or register with:</p>
                <a href="#"><img src="images/apple.png"
                  class="signup-icon" /></a>
                <a href="#"><img src="images/facebook.png"
                  class="signup-icon" /></a>
                  <a href="#"><img src="images/google.png"
                  class="signup-icon" /></a>
                </div>
            </div>

            <div class="col text-center p-3">
                <p>Already have an account? <a href="index.php">Login</a></p>
            </div>
        <!-- login form -->
        </div> 
        <!-- container -->
        </div>
            
            
            
        </form>
    
    <script src="js/script.js"></script>

</body>
</html>