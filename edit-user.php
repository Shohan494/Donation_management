<?php session_start(); ?>
<?php require_once('header.php');?>
<?php require_once('sidebar.php');?>
<?php
    if(!$_SESSION['user'])
    {
        header('Location: login.php');
    }

    //global $e;

    if(isset($_REQUEST['e']))
    {
        $e = $_GET['e'];
    }

    if(isset($_POST['submit']))
    {
        update_user();
    }

    function update_user()
    {
        if(!empty($_POST['name']) && !empty($_POST['password'])) 
        {
            $name = $_POST['name'];
            $password = $_POST['password'];
            
            $conn = oci_connect("hr","shohanhr","localhost/XE");
                
            global $e;
            $query = "UPDATE user_info SET username ='$name', password ='$password' WHERE user_id =".$e;

               $stid = oci_parse($conn, $query);
               
                $result = oci_execute($stid);
                
                if(!$result) {
                    echo "Failed !";
                }else {
                    echo "Successfully added New User !";
                    header('Location: user.php');
                }

        }else {
            echo "<p id=\"warning\">Fill All The Information !</p>";
        }
    }
?>


<?php
            global $e;
            $conn = oci_connect("hr","shohanhr","localhost/XE");
            if (!$conn) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            
            $query = 'SELECT * FROM user_info WHERE user_id ='.$e;

            $stid = oci_parse($conn, $query);
            oci_execute($stid);
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                
        
 ?>

<div class="donor-section">
    <h1 class="menu-title">Edit User : </h1>
    <a href="user.php" class="hlink cat-link">Back to User List</a>
    
    <form id="add-donor-form" name="donorform" action="edit-user.php?e=<?php echo $e; ?>" method="post">
       <br>
        <p class="form-text">User Name : </p>
        <input name="name" class="form-field" type="text" placeholder="Name" value="<?php echo $row['USERNAME']?>">
        
        <p class="form-text">Password : </p>
        <input name="password" class="form-field" type="password" placeholder="Password" value="<?php echo $row['PASSWORD']?>">
        
        
        <br>
        <input type="submit" name="submit" id="submit" value="Update User" class="form-field">
        
    </form>
</div>

<?php 
    }
?>

<?php require_once('footer.php')?>
