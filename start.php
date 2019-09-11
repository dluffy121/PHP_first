<html>
    <head>
        <title>
            Welcome
        </title>
        <style>
            .error {color: red;}
            .success {color: chartreuse;}
            .warning {color: orange;}
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
$verified = false;

if (isset($_POST['email']) && isset($_POST['pwd'])) {
    $email = $_POST["email"];
    $password = $_POST["pwd"];
    if(empty($email)) {
        $emailErr = "Please Enter Email";
    }
    if(empty($password)) {
        $passwordErr = "Password is Empty";
    }
    else{
        checkmail($email, $password);
    }
}

function checkmail($email, $password){
    $ret = mysqli_query($GLOBALS['mysqli'],"SELECT * FROM myguests WHERE email = '".$email."' AND password = SHA1('".$password."') ");
    if(!mysqli_fetch_assoc($ret)){
        echo "<p class=\"error\">Wrong Email or Password</p>";
        //$GLOBALS['verified']=true;
    }
    else{
        session_start();
        $_SESSION["useremail"] = $email;
        header("Location: User.html");
    }
}

?>

<center>
<h1>Hello Human</h1>
<br><br>
<div class="content">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
E-mail: <input type="text" name="email" required>
        <span class="error"><?php echo $emailErr;?></span>
        <br><br>
Password: <input type="password" name="pwd" required>
          <span class="error"><?php echo $passwordErr;?></span>
          <br><br>
<input type="submit" name="signin" value="Sign In" autofocus>
<input type="button" onclick="location.href = 'Register.php'" name="register" value="Register">
</form>
</div>
</center>


</body>
</html>