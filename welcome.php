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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
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

                                "<tr><td>" . "ID: " . "</td>" . "<td>" . $row["id"]. "</td></tr>" . 

                                "<tr><td>" . "Full Name: " . "</td>" . "<td>" . $row["firstname"]. " "  . $row["lastname"] . "</td></tr>" .       

                                "<tr><td>" . "User Name: " .  "</td>" . "<td>" . $row["username"] . "</td></tr>" . 

                                "<tr><td>" . "Email: " .  "</td>" . "<td>" . $row["email"] . "</td></tr>" . 

                                "<tr><td>" . "Member since: " .  "</td>" . "<td>" . $row["date"] . "</td></tr>" .
                                
                                "<tr><td>" . "Logins: " .  "</td>" . "<td>" . $row["logins"] . "</td></tr>" ; 

                            echo '<tr><td><p class="card-text">IP Address </td><td><span class="" id="ipaddress"></span></tr></td>';
                            
                            echo '<tr><td><p class="card-text">Location </td><td><span class="" id="location"></span></tr></td>';

                            echo '<tr><td><p class="card-text">Country</td><td><span class="" id="country"></span></tr></td>';

                            echo '<tr><td><p class="card-text">Time Zone </td><td><span class="" id="timezone"></span></tr></td>';

                            echo '<tr><td><p class="card-text">Current Time </td><td><span class="" id="dateTime"></span></tr></td>';

                            echo '<tr><td><p class="card-text">Weather (Celcius) </td><td><span class="" id="weather"></span></tr></td></table>';


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
</body>
</html>

<?php mysqli_close($conn); ?>