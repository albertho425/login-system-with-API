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
<!-- load tags, CSS, and Bootstrap -->
<?php require 'template-parts/header.php'; ?>

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
                                "<tr><td><i class=\"bi bi-at dashboard-icon-padding\"></i>" . "ID: " . "</td>" . "<td>" . $row["id"]. "</td></tr>" . 
                                //Username
                                "<tr><td><i class=\"bi bi-at dashboard-icon-padding\"></i>" . "User Name: " .  "</td>" . "<td>" . $row["username"] . "</td></tr>" . 
                                //Email
                                "<tr><td><i class=\"bi bi-envelope dashboard-icon-padding\"></i>" . "Email: " .  "</td>" . "<td>" . $row["email"] . "</td></tr>" . 
                                //Member since
                                "<tr><td><i class=\"bi bi-calendar-check dashboard-icon-padding\"></i>" . "Member since: " .  "</td>" . "<td>" . $row["date"] . "</td></tr>" .
                                //Last Update
                                "<tr><td><i class=\"bi bi-calendar-check dashboard-icon-padding\"></i>" . "Last Updated: " .  "</td>" . "<td>" . $row["lastlogin"] . "</td></tr>" ; 

                            //Output data from API

                            //IP
                            echo '<tr><td><i class="bi bi-geo-alt-fill dashboard-icon-padding"></i><span class="card-text">IP Address </td><td><span class="" id="ipaddress"></span></span</tr></td>';
                            //Location
                            echo '<tr><td><i class="bi bi-geo-alt-fill dashboard-icon-padding"></i><span class="card-text">City </td><td><span class="" id="city"></span></span></tr></td>';
                            //Country emoji
                            echo '<tr><td><i class="bi bi-geo-alt-fill dashboard-icon-padding"></i><span class="card-text">Country</td><td><span class="" id="country"></span></span></tr></td>';
                            //Time zone
                            echo '<tr><td><i class="bi bi-clock dashboard-icon-padding"></i><span class="card-text">Time Zone </td><td><span class="" id="timezone"></span></span></tr></td>';
                            //Current weather condition
                            echo '<tr><td><i class="bi bi-thermometer-half dashboard-icon-padding"></i><span class="card-text">Current Condition</td><td><span class="" id="condition"></span></span></tr></td>';
                            //Weather icon
                            echo '<tr><td><i class="bi bi-thermometer-half dashboard-icon-padding"></i><span class="card-text">Current Condition</td><td><span class="" id="weatherIcon"></span></span></tr></td>';
                            //Current temperature based on IP
                            echo '<tr><td><i class="bi bi-thermometer-half dashboard-icon-padding"></i><span class="card-text">Temperature </td><td><span class="" id="weather"></span></span></tr></td>';
                            //Currency Exchange Rate (1 USD to your location)
                            echo '<tr><td><i class="bi bi-currency-dollar dashboard-icon-padding"></i><span class="card-text">Exchange Rate from USD</td><td><span class="" id="exchangeRate"></span></tr></td></table>';


                            echo '<div class="col text-center">
                                  <div class="d-grid gap-1 p-1">';

                            echo '<a href="edit-profile.php?id='. $row['id'] .'" class="btn btn-primary form-margin-top">Edit</a>';   
                            
                            echo '<a href="logout.php" class="text-center btn btn-warning">Logout</a>
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
    
<?php require 'template-parts/footer.php'; ?>
<?php mysqli_close($conn); ?>