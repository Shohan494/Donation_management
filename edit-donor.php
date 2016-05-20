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
        edit_donor();
    }

    function edit_donor()
    {
        if(!empty($_POST['name']) && !empty($_POST['address']) && !empty($_POST['branch']) && !empty($_POST['bg']) 
         && !empty($_POST['phone']) && !empty($_POST['email'])) 
        {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $branch = $_POST['branch'];
            $bg = $_POST['bg'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];

            
            $conn = oci_connect("hr","shohanhr","localhost/XE");
            
            global $e;
            $query = "UPDATE donor SET b_id ='$branch', d_name ='$name', address ='$address', donated_item ='$bg', phone ='$phone', email ='$email' WHERE d_id =".$e;

               $stid = oci_parse($conn, $query);
    
                $result = oci_execute($stid);
                
                if(!$result) {
                    echo "Failed !";
                }else {
                    echo "Donor Updated!";
                    
                    header('Location: donor.php');
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
            
            $query = 'SELECT * FROM donor WHERE d_id ='.$e;

            $stid = oci_parse($conn, $query);
            oci_execute($stid);
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                
        
 ?>


<div class="donor-section">
    <h1 class="menu-title">Update Donor : </h1>
    <a href="donor.php" class="hlink cat-link">Back to Donor List</a>
    
    <form id="add-donor-form" name="donorform" action="edit-donor.php?e=<?php echo $e;?>" method="post">
       <br>
        <p class="form-text">Donor Name : </p>
        <input name="name" class="form-field" type="text" placeholder="Name" value="<?php echo $row['D_NAME']?>">
        
        <p class="form-text">Address : </p>
        <textarea name="address" id="textarea" class="form-field" cols="30" rows="10" placeholder="Address"><?php echo $row['ADDRESS']?></textarea>
        
        <p id="pcat" class="form-text">Select Branch : </p>
             <select name="branch">
                 <?php
                    $conc = oci_connect("hr","shohanhr","localhost/XE");

                   $sdt = oci_parse($conc, "SELECT * FROM branch");
                   oci_execute($sdt);
                 
                    if($sdt) {
                        while (($bb = oci_fetch_array($sdt, OCI_BOTH)) != false) {
                            if($row['B_ID'] == $bb['B_ID'])
                            {
                                echo "<option selected='selected' value=\"".$bb['B_ID']."\">".$bb['B_NAME']."</option>";
                            }
                            else {
                                echo "<option value=\"".$bb['B_ID']."\">".$bb['B_NAME']."</option>";
                            }
                        }
                    } else {
                        echo "Branch Failed !";
                    }
                 ?>
            </select>
            
        <p id="pcat" class="form-text">Donated Item Name : </p>
             <select name="bg">
                 <?php
                    $conn = oci_connect("hr","shohanhr","localhost/XE");

                   $stid = oci_parse($conn, "SELECT * FROM item ORDER BY item_name ASC");
                   oci_execute($stid);
                 
                    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        echo "<option value=\"".$row['ITEM_NAME']."\">".$row['ITEM_NAME']."</option>";
                    }
                 ?>
            </select>
        
        <p class="form-text">Phone : </p>
        <input name="phone" class="form-field" type="text" placeholder="Phone" value="<?php echo $row['PHONE']?>">
        
        <p class="form-text">Email : </p>
        <input name="email" class="form-field" type="text" placeholder="Email" value="<?php echo $row['EMAIL']?>">
        
        <br>
        <input type="submit" name="submit" id="submit" value="Update Donor" class="form-field">
        
    </form>
</div>

<?php 
    }
?>


<?php require_once('footer.php')?>
