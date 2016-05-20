<?php session_start(); ?>

<?php
    //IF THE PREVIOUS SESSION VALUE REMAINS, 
    //THEN USER WILL BE REDIRECTED TO HOMEPAGE
    if(!empty($_SESSION['user']))
    {
        header('Location: home.php');
    }
    //SUBMIT BUTTON WILL RUN THE LOGIN FUNCTION
    if(isset($_POST['submit']))
    {
        login();
    }

function login()
{
    if(!empty($_POST['username']) && !empty($_POST['password']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $conn = oci_connect("hr","shohanhr","localhost/XE");

        $stid = oci_parse($conn, "SELECT * FROM user_info WHERE username='$username' AND password='$password'");
        oci_execute($stid);
        
        $row = oci_fetch_array($stid, OCI_BOTH); 

        // if the credentials are correct then user is redirected to homepage
        //AND IMPORTANTLY $_SESSION['user'] = $username;
        //SESSION VARIABLE USER IS SET TO THE NAME OF THE USER
        if($username === $row['USERNAME'] && $password === $row['PASSWORD'])
        {
            $_SESSION['user'] = $username;
            header('Location: home.php');
        }
        else {
            echo '<p id="failed">Login Failed !</p>';
        }

        
    }else {
        echo '<p id="failed">Fill All The Information</p>';
    }
}

?>


<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]>-->
<!--[if !IE]> <!--> <html lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Login</title>
	
	

</head>

<body>

    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <div class="logo"></div>
        <div class="login-block">
           <form action="login2.php" method="post" name="loginform" id="loginform" >
                <h1>Online Donation <br> Management System</h1>
                <input name="username" type="text" value="" placeholder="Username" id="username" />
                <input name="password" type="password" value="" placeholder="Password" id="password" />
                <input id="login_submit" type="submit" name="submit" value="Login">
            </form>
        </div>

</body> 

</html>

