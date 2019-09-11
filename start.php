<html>
    <head>
        <title>
            Welcome
        </title>
        <style>
            .error {color: red;}
            .success {color: chartreuse;}
            .halted {color: orange;}
        </style>
    </head>
<body>
<?php
//Database Connection
$servername = "localhost";
$user = "root";
$pass = "";
$database = "phplearndb";

$mysqli = new mysqli($servername, $user, $pass, $database);
if($mysqli->connect_error){
    die("ERROR: Could not connect.".$mysqli->connect_error);
}

$emailErr = $passwordErr = "";
$email = $password = "";
$emailexist = false;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $password = $_POST["pwd"];
    if(empty($email)) {
        $emailErr = "Please Enter Email";
    }
    if(empty($password)) {
        $passwordErr = "Password is Empty";
    }
    elseif(isset($_POST['submit'])) {
        checkmail($mysqli, $email);
    }
}

function checkmail($mysqli, $email){
    if(mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM myguests WHERE email = '".$email."' AND password = '".$password."' "))){
        header('location: User.php');
    }
    else{
        echo "<p class=\"error\">Wrong Email or Password</p>";
    }
}

?>


<center>
<h1>Hello Newcomer</h1>
<br><br>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
E-mail: <input type="text" name="email">
        <span class="error"><?php echo $emailErr;?></span>
        <br><br>
Password: <input type="password" name="pwd">
          <span class="error"><?php echo $passwordErr;?></span>
          <br><br>
<input type="submit" onclick="" name="login" value="Sign In" autofocus>
<input type="button" onclick="location.href = 'Register.php'" name="register" value="Register">
</form>
</center>

</body>
</html>