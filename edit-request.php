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
        add_new_request();
    }

    function add_new_request()
    {
        if(!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['address']) && !empty($_POST['branch']) 
            && !empty($_POST['bg']) && !empty($_POST['dreport']) && !empty($_POST['iamount'])) 
        {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $branch = $_POST['branch'];
            $iamount = $_POST['iamount'];
            $bg = $_POST['bg'];
            $dreport = $_POST['dreport'];
            
            $conn = oci_connect("hr","shohanhr","localhost/XE");
                
            global $e;
            
            $query = "INSERT INTO item_request(item_request_id, b_id, name, phone, item_name, confirm_request, address,
             item_amount) VALUES (item_request_seq.nextval, $branch, '$name', '$phone', '$bg', '$dreport', '$address', '$iamount')";
            
            $query = "UPDATE item_request SET name ='$name', phone ='$phone', item_name ='$bg', confirm_request ='$dreport', 
            address ='$address', item_amount ='$iamount' WHERE item_request_id =".$e;

               $stid = oci_parse($conn, $query);
               
                $result = oci_execute($stid);
                
                if(!$result) {
                    echo "Failed !";
                }else {
                    echo "Successfully added New Item Request !";
                    header('Location: item-request.php');
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
            
            $query = 'SELECT * FROM item_request WHERE item_request_id ='.$e;

            $stid = oci_parse($conn, $query);
            oci_execute($stid);
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                
        
 ?>


<div class="donor-section">
    <h1 class="menu-title">Edit Requests: </h1>
    <a href="item-request.php" class="hlink cat-link">Back to Request List</a>
    
        <form id="add-donor-form" name="donorform" action="edit-request.php?e=<?php echo $e; ?>" method="post">
       <br>
        <p class="form-text">Name : </p>
        <input name="name" class="form-field" type="text" placeholder="Name" value="<?php echo $row['NAME']?>">
        
        <p class="form-text">Phone : </p>
        <input name="phone" class="form-field" type="text" placeholder="Phone" value="<?php echo $row['PHONE']?>">
        
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
        
        <p id="pcat" class="form-text">Item Name : </p>
             <select name="bg">
                 <?php
                    $cob = oci_connect("hr","shohanhr","localhost/XE");
                
                    $var = $row['ITEM_NAME'];
                   $sdtt = oci_parse($cob, "SELECT * FROM item");
                   oci_execute($sdtt);
                 
                    if($sdtt) {
                        while (($bg = oci_fetch_array($sdtt, OCI_BOTH)) != false) {
                            if($row['ITEM_NAME'] == $bg['ITEM_NAME'])
                            {
                                echo "<option selected='selected' value=\"".$bg['ITEM_NAME']."\">".$bg['ITEM_NAME']."</option>";
                            }
                            else {
                                echo "<option value=\"".$bg['ITEM_NAME']."\">".$bg['ITEM_NAME']."</option>";
                            }
                        }
                    } else {
                        echo "Branch Failed !";
                    }
                 ?>
            </select>
        
        <p class="form-text">Confirm Request : </p>
        <input name="dreport" class="form-field" type="text" placeholder="Report" value="<?php echo $row['CONFIRM_REQUEST']?>">
        
        <p class="form-text">Address : </p>
        <textarea name="address" id="textarea" class="form-field" cols="30" rows="10" placeholder="Address"><?php echo $row['ADDRESS']?></textarea>>
        
        <p class="form-text">Item Amount : </p>
        <input name="iamount" class="form-field" type="text" placeholder="ITEM Amount" value="<?php echo $row['ITEM_AMOUNT']?>">
        
        <br>
        <input type="submit" name="submit" id="submit" value="Update Request" class="form-field">
        
    </form>
</div>

<?php 
    }
?>


<?php require_once('footer.php')?>
