<!DOCTYPE HTML>
<html>
<head>
    <style>
        .error {color: #FF0000;}
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
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $comment = $website = $gender = "";
$checkflag=false;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["name"])){
        $nameErr = "Name is required";
        $checkflag = false;
    }
    else{
        $name = input_formating($_POST["name"],false);
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $nameErr = "Only letters and white space allowed";
            $checkflag = false;
        }
        else{
            $checkflag=true;
        }
    }

    if(empty($_POST["email"])){
        $emailErr = "Email is required";
        $checkflag = false;
    }
    else{
        $email = input_formating($_POST["email"],false);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Please Endter a Valid Email";
            $checkflag = false;
        }
        else{
            $checkflag=true;
        }
    }

    if(empty($_POST["gender"])){
        $genderErr = "Please Specify your Gender";
        $checkflag = false;
    }
    else{
        $gender = input_formating($_POST["gender"],false);
        $checkflag=true;
    }

    if(empty($_POST["website"])){
        $websiteErr = "Website name is required";
        $checkflag = false;
    }
    else
    {
        $website = input_formating($_POST["website"],true);
        $webreg = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
        if (!preg_match($webreg, $website)) {
            $websiteErr = "Enter Valid URL";
            $checkflag = false;
        }
        else{
            $checkflag=true;
        }
    }
}

//database updation
if($checkflag == true){
    $sql = "INSERT INTO myguests (name, gender, email, website, comment) VALUES ('".$name."','".$gender."','".$email."','".$website."','".$comment."')";
    if($mysqli->query($sql) === TRUE){
        $last_id = $mysqli->insert_id;
        echo "New record Created successfully";
    }
    else {
        echo "Error: ".$sql."<br>".$mysqli->error;
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

<b>PHP form validation</b>
<p class="error">* fields are required</p>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
Name:   <input type="text" name="name" value="<?php echo $name;?>">
        <span class="error">*<?php echo $nameErr;?></span>
        <br><br>
Gender: <br><input type="radio" name="gender" 
        <?php if (isset($gender) && $gender=="male") echo "checked";?> 
        value="male">Male
        <input type="radio" name="gender"
        <?php if (isset($gender) && $gender=="female") echo "checked";?> 
        value="female">Female
        <input type="radio" name="gender"
        <?php if (isset($gender) && $gender=="other") echo "checked";?> 
        value="other">Other
        <span class="error">*<?php echo $genderErr;?></span>
        <br><br>
E-mail: <input type="text" name="email" value="<?php echo $email;?>">
        <span class="error">*<?php echo $emailErr;?></span>
        <br><br>
Website: <input type="text" name="website" value="<?php echo $website;?>">
         <span class="error">*<?php echo $websiteErr;?></span>
         <br><br>
Comment: <textarea name="comment" rows="5" cols="40" value="<?php echo $comment;?>"></textarea>
         <br><br><br>
<input type="submit">
</form>

</body>
</html>