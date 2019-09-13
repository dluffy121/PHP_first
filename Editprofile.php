<!DOCTYPE HTML>
<html>
    <head>
        <title>
            Edit Profile
        </title>
        <style>
            .error {color: red}
            .success{color:chartreuse}
        </style>
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

//Variables
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $gender = $website = $comment = "";
$nameflag = $websiteflag = $commentflag = $genderflag = false;
$status="";
$del=false;
$columns = array("name", "gender", "website","comment");

$email = $_SESSION["useremail"];

$oldvalues = mysqli_fetch_array(mysqli_query($mysqli,"SELECT name,gender,website,comment FROM myguests WHERE email = '".$email."'"));

$name = $oldvalues[0];
$gender = $oldvalues[1];
$website = $oldvalues[2];
$comment = $oldvalues[3];

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST["name"])){
        $nameErr = "Will Remain Same As Before";
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
        $genderErr = "Will Remain Same As Before";
        $genderflag = false;
    }
    else{
        $gender = input_formating($_POST["gender"],false);
        $genderflag=true;
    }

    if(empty($_POST["website"])){
        $websiteErr = "Will Remain Same As Before";
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

    if(empty($_POST["comment"])){
        $commentErr = "Will Remain Same As Before";
        $commentflag = false;
    }
    else
    {
        $comment = $_POST["comment"];
        $commentflag = true;
    }
}

//Database Update
if($nameflag || $genderflag || $websiteflag || $commentflag == true)//Next LVL sh****************t
{
    $str = "";
    foreach($columns as $i){
        $str=$str.",".$i." = '".$$i."'";
    }
    $str=preg_replace("/,/","",$str,1);

    $updsql = "UPDATE myguests SET $str WHERE email='".$email."'";
    if($mysqli->query($updsql) === TRUE){
        $status = "Updated successfully";
    }
    else {
        $status = "UpdError: ".$updsql."<br>".$mysqli->error;
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

if(isset($_POST['delete'])){
    $deluser = "DELETE FROM myguests WHERE email = '".$email."' ";
    if($mysqli->query($deluser) === TRUE){
        $status = "Deleted successfully";
    }
    else {
        $status = "DelError: ".$deluser."<br>".$mysqli->error;
    }
    $del = false;
}

?>

<center>
<h1>Edit User Info</h1>
<h2><?php echo $email ?></h2>
</center>



<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
Name:   <input type="text" name="name" value="<?php echo $name;?>">
        <span class="error"><?php echo $nameErr;?></span>
        <br><br>
Gender: <br><input type="radio" name="gender" 
        <?php if ($gender=="male") echo "checked";?> 
        value="male">Male
        <input type="radio" name="gender"
        <?php if ($gender=="female") echo "checked";?> 
        value="female">Female
        <input type="radio" name="gender"
        <?php if ($gender=="other") echo "checked";?> 
        value="other">Other
        <span class="error"><?php echo $genderErr;?></span>
        <br><br>
Website: <input type="text" name="website" value="<?php echo $website;?>">
         <span class="error"><?php echo $websiteErr;?></span>
         <br><br>
Comment: <textarea name="comment" rows="3" cols="40"><?php echo $comment;?></textarea>
         <br><br><br>

<button type="submit" id="sshow" style="display: none">Confirm</button>
<button type="button" id="shide" onclick="getElementById('shide').style.display='none'; getElementById('sshow').style.display=''">Save Changes</button>
<br>
<button type="button" onclick="location.href = 'User.php'" name="start">Back</button>
<br>
<button type="submit" name="delete" id="dshow" style="display: none">Confirm</button>
<button type="button" id="dhide" onclick="getElementById('dhide').style.display='none'; getElementById('dshow').style.display=''">Delete Account</button>
<br>

<p>
    <?php 
        echo "<p class =\"success\">$status</p>";
    ?>
</p>

</form>

</body>
</html>