<?php session_start(); ?>
<?php require_once('header.php');?>
<?php require_once('sidebar.php');?>
<?php
    if(!$_SESSION['user'])
    {
        header('Location: login.php');
    }

        if(isset($_POST['submit']))
    {
        add_new_request();
    }

    function add_new_request()
    {
        if(!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['address']) 
            && !empty($_POST['branch']) && !empty($_POST['i_name']) && !empty($_POST['creport']) 
            && !empty($_POST['iamount'])) 
        {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $branch = $_POST['branch'];
            $i_name = $_POST['i_name'];
            $creport = $_POST['creport'];
            $iamount = $_POST['iamount'];
            
            $conn = oci_connect("hr","shohanhr","localhost/XE");
                
            $query = "INSERT INTO item_request(item_request_id, b_id, name, phone, item_name, confirm_request, 
                address, item_amount) VALUES (item_request_seq.nextval, $branch, '$name', '$phone', '$i_name', 
                '$creport', '$address', '$iamount')";

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

<div class="donor-section">
    <h1 class="menu-title">Add New Requests: </h1>
    <a href="item-request.php" class="hlink cat-link">Back to Request List</a>
    
        <form id="add-donor-form" name="donorform" action="add-request.php" method="post">
       <br>
        <p class="form-text">Name : </p>
        <input name="name" class="form-field" type="text" placeholder="Name">
        
        <p class="form-text">Phone : </p>
        <input name="phone" class="form-field" type="text" placeholder="Phone">
        
        <p class="form-text">Email : </p>
        <input name="email" class="form-field" type="text" placeholder="Email">
        
        <p id="pcat" class="form-text">Select Branch : </p>
             <select name="branch">
                 <?php
                    $conn = oci_connect("hr","shohanhr","localhost/XE");

                   $stid = oci_parse($conn, "SELECT * FROM branch");
                   oci_execute($stid);
                 
                    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        echo "<option value=\"".$row['B_ID']."\">".$row['B_NAME']."</option>";
                    }
                 ?>
            </select>
        
        <p id="pcat" class="form-text">Item Name : </p>
             <select name="i_name">
                 <?php
                    $conn = oci_connect("hr","shohanhr","localhost/XE");

                   $stid = oci_parse($conn, "SELECT * FROM item ORDER BY item_name ASC");
                   oci_execute($stid);
                 
                    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        echo "<option value=\"".$row['ITEM_NAME']."\">".$row['ITEM_NAME']."</option>";
                    }
                 ?>
            </select>
        
        <p class="form-text">Address : </p>
        <textarea name="address" id="textarea" class="form-field" cols="30" rows="10" placeholder="Address"></textarea>
        
        <p class="form-text">Item Amount : </p>
        <input name="iamount" class="form-field" type="text" placeholder="Item Amount">

        <p class="form-text">Confirm Request : </p>
        <input name="creport" class="form-field" type="text" placeholder="Yes or No">

        <br>
        <input type="submit" name="submit" id="submit" value="Add New Request" class="form-field">
        
    </form>
</div>

<?php require_once('footer.php')?>
