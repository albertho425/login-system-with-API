<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_firstname = $new_lastname = $new_email = $new_username = $new_password = $confirm_password = "";
$firstname = $lastname = $username = $email = "";
$new_firstname_err = $new_lastname_err = $new_email_err = $new_username_err = $new_password_err = $confirm_password_err = "";


// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Get URL parameter
    $id =  trim($_GET["id"]);
    
    // Prepare a select statement
    $sql = "SELECT * FROM loginusers WHERE id = ?";
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            if($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $email = $row["email"];
                $username = $row["username"];
                $date = $row["date"];
            } else{
                // URL doesn't contain valid id. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    
    // Close statement
    $stmt->close();
    
    // Close connection
    $mysqli->close();
} 


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate First name
    if(empty(trim($_POST["new_firstname"]))){
        $new_firstname_err = "Please enter a first name.";     
    } else{
        $new_firstname = trim($_POST["new_firstname"]);
        
    }

    // Validate Last name
    if(empty(trim($_POST["new_lastname"]))){
        $new_lastname_err = "Please enter a last name.";     
    } else{
        $new_lastname = trim($_POST["new_lastname"]);
        
    }

     // Validate email
     if(empty(trim($_POST["new_email"]))){
        $new_email_err = "Please enter an email";     
    } else{
        $new_email = trim($_POST["new_email"]);
    }

    // Validate username
     if(empty(trim($_POST["new_username"]))){
        $new_username_err = "Please enter a username";     
    } else{
        $new_username = trim($_POST["new_username"]);
     
        
    }
        
    // Check input errors before updating the database
    if(empty($new_lastname_err) && empty($new_firstname_err) && empty($new_password_err) && empty($confirm_password_err) && empty($new_username_err) && empty($new_email_err) ){
        // Prepare an update statement
        $sql = "UPDATE loginusers SET firstname=?, lastname=?, email=?, username=?, password = ? WHERE id = ?";
        echo "No errors";
        
        
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            // sssi stands for string and integer
            $stmt->bind_param("ssssssi", $param_firstname, $param_lastname, $param_email, $param_username, $param_password, $param_lastupdate, $param_id);
           

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            $param_firstname = $new_firstname;
            $param_lastname = $new_lastname;
            $param_email = $new_email;
            $param_username = $new_username;

            // time zone is hard coded to PST
            date_default_timezone_set("America/Vancouver");
            $param_lastupdate = date('y-m-d h:i:s');
            
            
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: welcome.php");
                exit();
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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <div class="login-form">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 

        
        
        <div class="form-group">    
            <h3 class="text-center">Edit Profile</h3>
            <div class="col text-center"><br>
                <img class="signup-icon" src="images/login.png"/>
            </div>
        </div>    
        
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-margin-top"></label>
                    <input type="text" name="new_firstname" class="form-control <?php echo (!empty($new_firstname_err)) ? 'is-invalid' : ''?>" value="<?php echo $firstname; ?>">
                    <span class="invalid-feedback"><?php echo $new_firstname_err?></span>
                    <span><?php echo $new_firstname;?></span>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="form-margin-top"></label>
                    <input type="text" name="new_lastname" class="form-control <?php echo (!empty($new_lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname ?>">
                    <span class="invalid-feedback"><?php echo $new_lastname_err; ?></span>
                    <span><?php echo $new_lastname;?></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="form-margin-top"></label>
            <div class="input-group">
                <div class="input-group-addon">
                    <div class="input-group-text"><i class="bi bi-envelope"></i></div>
                </div>
            <input type="email" name="new_email" class="form-control <?php echo (!empty($new_email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email ?>">
            <span class="invalid-feedback"><?php echo $new_email_err; ?></span>
            <span><?php echo $new_email;?></span>
        </div></div>
        <div class="form-group">
            <label class="form-margin-top"></label>
            <div class="input-group">
                <div class="input-group-addon">
                    <div class="input-group-text"><i class="bi bi-person-circle"></i></i></div>
                </div>    
            <input type="text" name="new_username" class="form-control <?php echo (!empty($new_username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username ?>">
            <span class="invalid-feedback"><?php echo $new_username_err; ?></span>
            <span><?php echo $new_username;?></span>
        </div></div>
        
        <div class="form-group">
            <label class="form-margin-top"></label>
            <div class="input-group">
                <div class="input-group-addon">
                    <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                </div>
            <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>" placeholder="New password">
            <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            <span><?php echo $new_password;?></span>
        </div></div>
        <div class="form-group">
            <label class="form-margin-top"></label>
            <div class="input-group">
                <div class="input-group-addon">
                    <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                </div>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" placeholder="Confirm Password">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            <span><?php echo $confirm_password;?></span>
        </div></div>
        <div class="form-group">
            <label class="form-margin-top">Member since</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <div class="input-group-text"><i class="bi bi-calendar-check"></i></div>
                </div>
            <input type="text" name="" class="form-control" value="<?php echo $date ?>" disabled readonly>
        </div></div>
        
        <div class="col text-center pt-1">
              <div class="d-grid gap-1 p-1">
                  <input type="submit" class="btn btn-primary form-margin-top mb-1" value="Submit">
                  <a class="text-center btn btn-warning" href="welcome.php">Cancel</a>      
              </div>
            </div>
    </form>
    </div>
</div>
<script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>