<?php session_start(); ?>
<?php require_once('header.php');?>
<?php require_once('sidebar.php');?>
<?php
    if(!$_SESSION['user'])
    {
        header('Location: login.php');
    }

    global $e;

    if(isset($_REQUEST['e']))
    {
        $e = $_GET['e'];
    }

    if(isset($_POST['submit']))
    {
        add_new_branch();
    }

    function add_new_branch()
    {
        if(!empty($_POST['name']) && !empty($_POST['address'])
            && !empty($_POST['phone']) && !empty($_POST['area'])) 
        {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $area = $_POST['area'];
            $phone = $_POST['phone'];

            
            $conn = oci_connect("hr","shohanhr","localhost/XE");
            
            global $e;
            $query = "UPDATE branch SET b_name ='$name', address ='$address', area ='$area', phone ='$phone' WHERE b_id =".$e;

               $stid = oci_parse($conn, $query);
               
                $result = oci_execute($stid);
                
                if(!$result) {
                    echo "Failed !";
                }else {
                    echo "Successfully added New Branch !";
                    header('Location: branch.php');
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
            
            $query = 'SELECT * FROM branch WHERE b_id ='.$e;

            $stid = oci_parse($conn, $query);
            oci_execute($stid);
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                
        
 ?>

<div class="donor-section">
    <h1 class="menu-title">Edit Branch : </h1>
    <a href="branch.php" class="hlink cat-link">Back to Branch List</a>
    
        <form id="add-donor-form" name="donorform" action="edit-branch.php?e=<?php echo $e;?>" method="post">
       <br>
        <p class="form-text">Branch Name : </p>
        <input name="name" class="form-field" type="text" placeholder="Name" value="<?php echo $row['B_NAME']?>">
        
        <p class="form-text">Address : </p>
        <textarea name="address" id="textarea" class="form-field" cols="30" rows="10" placeholder="Address"><?php echo $row['ADDRESS']?></textarea>
        
        <p class="form-text">Area : </p>
        <input name="area" class="form-field" type="text" placeholder="Area" value="<?php echo $row['AREA']?>">

        <p class="form-text">Phone : </p>
        <input name="phone" class="form-field" type="text" placeholder="Phone" value="<?php echo $row['PHONE']?>">
        
        <br>
        <input type="submit" name="submit" id="submit" value="Update Branch" class="form-field">
        
    </form>
    
</div>

<?php 
    }
?>


<?php require_once('footer.php')?>
