<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}


// Include config file
require_once "config.php";

?>

<?php
// Create connection
$conn = mysqli_connect("localhost", "root", "root", "maplesyrupweb");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM loginusers WHERE username = '".$_SESSION['username']."'";
$result = mysqli_query($conn, $sql);

  
  

?>
 
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<head>

    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">     
    
</head>
<body>
    <div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">


        <div class="login-form" style="margin-top:0";>
            <img src="" class="card-img-top" alt="">
            <form>
            <div class="card-body">
                <h5 class="card-title"><b></b>Your Dashboard</h5>
                <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped mt-5">  
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                            
                        echo
                                //get data from database and output
                                "<tr><td>" . "ID: " . "</td>" . "<td>" . $row["id"]. "</td></tr>" . 
                                //First and last name
                                "<tr><td>" . "Full Name: " . "</td>" . "<td>" . $row["firstname"]. " "  . $row["lastname"] 
                                . "</td></tr>" .       
                                //Username
                                "<tr><td>" . "User Name: " .  "</td>" . "<td>" . $row["username"] . "</td></tr>" . 
                                //Email
                                "<tr><td>" . "Email: " .  "</td>" . "<td>" . $row["email"] . "</td></tr>" . 
                                //Member since
                                "<tr><td>" . "Member since: " .  "</td>" . "<td>" . $row["date"] . "</td></tr>" .
                                //Last login
                                "<tr><td>" . "Last Login: " .  "</td>" . "<td>" . $row["lastlogin"] . "</td></tr>" ; 

                            //Output data from API

                            //IP
                            echo '<tr><td><p class="card-text">IP Address </td><td><span class="" id="ipaddress"></span></tr></td>';
                            //Location
                            echo '<tr><td><p class="card-text">City </td><td><span class="" id="city"></span></tr></td>';
                            //Country emoji
                            echo '<tr><td><p class="card-text">Country</td><td><span class="" id="country"></span></tr></td>';
                            //Time zone
                            echo '<tr><td><p class="card-text">Time Zone </td><td><span class="" id="timezone"></span></tr></td>';
                            //Current weather condition
                            echo '<tr><td><p class="card-text">Current Conditions </td><td><span class="" id="condition"></span></tr></td>';
                            //Weather icon
                            echo '<tr><td><p class="card-text">Weather icon </td><td><span class="" id="weatherIcon"></span></tr></td>';
                            //Current temperature based on IP
                            echo '<tr><td><p class="card-text">Temperature </td><td><span class="" id="weather"></span></tr></td>';
                            //Currency Exchange Rate (1 USD to your location)
                            echo '<tr><td><p class="card-text">Exchange Rate</td><td><span class="" id="exchangeRate"></span></tr></td></table>';


                            echo '<div class="col text-center">
                                  <div class="d-grid gap-1 p-1">';

                            echo '<a href="edit-profile.php?id='. $row['id'] .'" class="btn btn-primary form-margin-top">Edit</a>';   
                            
                            echo '<a href="logout.php" class="btn btn-warning form-margin-top mb-1">Logout</a>
                            </div>
                            </div>
                            ';
                        }            
                    } else {
                    echo "Oops! Something went wrong. Please try again later.";
                    }
                    ?>
                </div>
                
            </div>
        </form>
        </div>    
    </div>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>

<?php mysqli_close($conn); ?>