<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation Example</title>
    <style>
        .error {
            color: red;
        }
    </style>

</head>
<body>

<style>
html, body {
    color: #636b6f;
    font-family: 'Nunito', sans-serif;
    font-weight: 200;
    height: 110vh;
    margin: 5;
    }

input {
    color: #636b6f;
    padding:5px 15px;
    background:#bae3f5;
    border:0 none;
    cursor:pointer;
    -webkit-border-radius:5px;
    border-radius:5px;
    font-family: 'Nunito', sans-serif;
    font-size: 15px;
    }

textarea {
    padding:5px 15px;
    background:#bae3f5;
    border:0 none;
    cursor:pointer;
    -webkit-border-radius:5px;
    border-radius:5px;
}

.success{
    font-size: 25px;
    top: 100px;
    color: #003377;
    }

hr.style-six {
    border: 0;
    height: 0;
    border-top: 1px solid rgba(0,0,0,0.1);
    border-bottom: 1px solid rgba(255,255,255,0.3);
}

.submit {
    color: #636b6f;
    padding:5px 15px;
    background:#eacbf5;
    border:0 none;
    cursor:pointer;
    -webkit-border-radius:5px;
    border-radius:5px;
    font-family: 'Nunito', sans-serif;
    font-size: 15px;

}
</style>

<?php
    $nameErr = $emailErr = $websiteErr = $genderErr = "";
    $name = $email = $website = $comment = $gender = "";    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty($_POST["name"])){
            $nameErr = "Name is required";
        } else {
            $name = test_input($_POST["name"]);
        }
        if (empty($_POST["email"])){
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            //check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $emailErr = "Invalid email format";
            }
        }
        if (empty($_POST["website"])){
            $website = "";
        } else {
            $website = test_input($_POST["website"]);
            // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
                $websiteErr = "Invalid URL";
            }
        }
        if (empty($_POST["comment"])){
            $comment = "";
        } else {
            $comment = test_input($_POST["comment"]);
        }
        if (empty($_POST["gender"])){
            $genderErr = "Gender is required";
        } else {
            $gender = test_input($_POST["gender"]);
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
?>

<h2>Form Validation Example</h2>
<p><span class="error">* required field</span></p>
<form action = <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> method = post>
    Name: <input type = "text" name = "name">
    <span class = "error">* <?php echo $nameErr;?></span>
    <br><br>
    E-mail: <input type = "text" name = "email">
    <span class = "error">* <?php echo $emailErr;?></span>
    <br><br>
    Website: <input type = "text" name = "website">
    <br><br>
    Comment: <textarea rows = "5" cols = "40" name = "comment"></textarea>
    <br><br>
    Gender: 
    <input type = "radio" name = "gender" value = "Female">Female
    <input type = "radio" name = "gender" value = "Male">Male
    <input type = "radio" name = "gender" value = "Other">Other
    <span class = "error">* <?php echo $genderErr;?></span>
    <br><br>
    <input type = "submit" name = "submit" value = "Submit" class = "submit">
    <input type = "submit" name = "reset" value = "Reset" class = "submit">
    <br><br>
    <hr class = "hr.style-six"/>
</form>

<?php
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $website;
echo "<br>";
echo $comment;
echo "<br>";
echo $gender;
echo "<br>";

if (isset($_POST["submit"])){
    include "conn.php";
    $sql = "INSERT INTO `comment`(`name`, `email`, `website`, `comment`, `gender`) VALUES ('$name', '$email', '$website', '$comment', '$gender')";

    if (!mysqli_query($db, $sql)){
        die(mysqli_error($db));
        echo "Error inserting comment into database";
    }else{
        //成功將留言存進資料庫
        echo '<div class="success"><strong>Added succesfully!</strong></div>';
    }
}



?>

</body>
</html>