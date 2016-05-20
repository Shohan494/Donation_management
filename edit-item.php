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
        add_new_item();
    }

    function add_new_item()
    {
        if(!empty($_POST['bamount'])) 
        {
            $bamount = $_POST['bamount'];

            
            $conn = oci_connect("hr","shohanhr","localhost/XE");
                
            global $e;
            $query = "UPDATE item SET item_amount ='$bamount' WHERE item_id ='$e'";

               $stid = oci_parse($conn, $query);
               
                $result = oci_execute($stid);
                
                if(!$result) {
                    echo "Failed !";
                }else {
                    echo "Successfully updated Branch !";
                    header('Location: item.php');
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
            
            $query = 'SELECT * FROM item WHERE item_id ='.$e;

            $stid = oci_parse($conn, $query);
            oci_execute($stid);
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                
        
 ?>


<div class="donor-section">
    <h1 class="menu-title">Edit Item : <?php echo $row['ITEM_NAME']?></h1>
    <a href="item.php" class="hlink cat-link">Back to Item List</a>
    
    <form id="add-donor-form" name="donorform" action="edit-item.php?e=<?php echo $e; ?>" method="post">
       <br>
        <p class="form-text">Item Amount : </p>
        <input name="bamount" class="form-field" type="text" placeholder="Amount of Item" value="<?php echo $row['ITEM_AMOUNT']?>">
        
        <br>
        <input type="submit" name="submit" id="submit" value="Update Item" class="form-field">
        
    </form>
    
    
</div>

<?php 
    }
?>

<?php require_once('footer.php')?>
