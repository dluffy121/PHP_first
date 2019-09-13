<html>
    <head>
        <title>
            User's Page
        </title>
    </head>
    <body>
    <?php
    session_start();

    //Database Connection
    $servername = "localhost";
    $user = "root";
    $password = "";
    $database = "phplearndb";

    $mysqli = new mysqli($servername, $user, $password, $database);
    if($mysqli->connect_error){
        die("ERROR: Could not connect.".$mysqli->connect_error);
    }

    $email = $_SESSION["useremail"];
    $uservalues = mysqli_fetch_array(mysqli_query($mysqli,"SELECT name,gender,email,website,comment,reg_date FROM myguests WHERE email = '".$email."'"));

    $name = $uservalues[0];
    $gender = $uservalues[1];
    $email = $uservalues[2];
    $website = $uservalues[3];
    $comment = $uservalues[4];

    ?>
        <center>
            <h1>
                Successfully Logged In
            </h1>
            <p style="color:black">
                <?php echo "<b>Name: </b>".$name."<br><b>Gender: </b>".$gender."<br><b>Email: </b>".$email."<br><b>Website: </b>".$website."<br><b>Comment: </b>".$comment;
                ?>
            </p>
            <button type="button" onclick="location.href = 'EditProfile.php'">Edit Profile</button>
            <button type="button" onclick="location.href = 'start.php'">LogOut</button>
        <center>
    </body>
</html>