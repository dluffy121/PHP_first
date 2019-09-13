<!DOCTYPE HTML>
<html>
    <head>
        <style>
            .error {color: red;}
            .success {color: darkgreen;}
            .warning {color: orange;}
        </style>
    </head>  
<body>

<?php
//Database Connection
$servername = "localhost";
$user = "root";
$password = "";
$database = "phplearndb";

$mysqli = new mysqli($servername, $user, $password, $database);
if($mysqli->connect_error){
    die("ERROR: Could not connect.".$mysqli->connect_error);
}

//Form Validation
$nameErr = $emailErr = $genderErr = $websiteErr = $passwordErr = "";
$name = $email = $comment = $website = $gender = $password = "";
$nameflag = $websiteflag = $emailflag = $genderflag = $passflag = false;
$status="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["name"])){
        $nameErr = "Name is required";
        $nameflag = false;
    }
    else{
        $name = input_formating($_POST["name"],false);
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $nameErr = "Only letters and white space allowed";
            $nameflag = false;
        }
        else{
            $nameflag=true;
        }
    }

    if(empty($_POST["gender"])){
        $genderErr = "Please Specify your Gender";
        $genderflag = false;
    }
    else{
        $gender = input_formating($_POST["gender"],false);
        $genderflag=true;
    }

    if(empty($_POST["email"])){
        $emailErr = "Email is required";
        $emailflag = false;
    }
    else{
        $email = input_formating($_POST["email"],false);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Please Enter a Valid Email";
            $emailflag = false;
        }
        else{
            $emailflag=true;
        }
    }

    if(empty($_POST['password'])) {
        $passwordErr = "Password cannot be Empty";
        $passflag = false;
    }
    else {
        $password = $_POST["password"];
        $passflag = true;
    }

    if(empty($_POST["website"])){
        $websiteErr = "Website name is required";
        $websiteflag = false;
    }
    else
    {
        $website = input_formating($_POST["website"],true);
        $webreg = "/\b(?:(?:https|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        if (!preg_match($webreg, $website)) {
            $websiteErr = "Enter Valid URL";
            $webisteflag = false;
        }
        else{
            $websiteflag=true;
        }
    }
    
    $comment = $_POST['comment'];
}

//Database Entry Create
if($name && $genderflag && $emailflag && $passflag && $websiteflag == true){
    if(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM myguests WHERE email = '".$email."'")))
    {
        $status = "Already Registered";
    }
    else
    {
        $regsql = "INSERT INTO myguests (name, gender, email, password, website, comment) VALUES ('".$name."','".$gender."','".$email."', SHA1('".$password."'),'".$website."','".$comment."')";
        if($mysqli->query($regsql) === TRUE){
            $last_id = $mysqli->insert_id;
            $status = "New record Created successfully";
        }
        else {
            $status = "RegError: ".$regsql."<br>".$mysqli->error;
        }
    }
}


function input_formating($data,$ifwebsite) {
    if($ifwebsite == false)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    else{
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

?>

<center>
<h1>PHP form validation</h1>
</center>
<p class="error">* fields are required</p>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
Name:   <input type="text" name="name" value="<?php echo $name;?>">
        <span class="error">*<?php echo $nameErr;?></span>
        <br><br>
Gender: <br><input type="radio" name="gender" 
        <?php if (isset($gender) && $gender=="Male") echo "checked";?> 
        value="Male">Male
        <input type="radio" name="gender"
        <?php if (isset($gender) && $gender=="Female") echo "checked";?> 
        value="Female">Female
        <input type="radio" name="gender"
        <?php if (isset($gender) && $gender=="Other") echo "checked";?> 
        value="Other">Other
        <span class="error">*<?php echo $genderErr;?></span>
        <br><br>
E-mail: <input type="text" name="email" value="<?php echo $email;?>">
        <span class="error">*<?php echo $emailErr;?></span>
        <br><br>
Password: <input type="password" name="password" minlength="5">
          <span class="error">*<?php echo $passwordErr;?></span>
          <br><br>
Website: <input type="text" name="website" value="<?php echo $website;?>">
         <span class="error">*<?php echo $websiteErr;?></span>
         <br><br>
Comment: <textarea name="comment" rows="3" cols="40"><?php echo $comment;?></textarea>
         <br><br><br>
<input type="submit">
<input type="button" onclick="location.href = 'start.php'" name="start" value="Back">





<p>
    <?php 
    if($status=="Already Registered"){
        echo "<p class =\"warning\">$status</p>";
    }
    else{
        echo "<p class =\"success\">$status</p>";
    }
    ?>
</p>

</form>

</body>
</html>