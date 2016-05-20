<?php session_start(); ?>
<?php require_once('header.php');?>
<?php require_once('sidebar.php');?>
<?php
    if(!$_SESSION['user'])
    {
        header('Location: login.php');
    }

    if(isset($_GET['p']))
    {
        $p = $_GET['p'];
        
        $conn = oci_connect("hr","shohanhr","localhost/XE");
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        $query = 'DELETE FROM item_request WHERE item_request_id='.$p;

        $stid = oci_parse($conn, $query);
        oci_execute($stid);
        
        header('Location: item-request.php');
        
    }
?>

<div class="donor-section">
    <h1 class="menu-title">Item Requests: </h1>
    <a href="add-request.php" class="hlink cat-link">Add New Item Request</a>
    
    <?php

        $conn = oci_connect("hr","shohanhr","localhost/XE");
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM item_request');
        oci_execute($stid);
    
    
    
        echo '<table class="tbls">
            <tr>
            <td>Name</td>
            <td>Phone</td>
            <td>Address</td>
            <td>Item Name</td>
            <td>Item Amount</td>
            <td>Confirmation</td>
            <td>Edit</td>
            <td>Delete</td>
            </tr>';

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            

                echo '<tr>
                <td>'.$row["NAME"].'</td>
                <td>'.$row["PHONE"].'</td>
                <td>'.$row["ADDRESS"].'</td>
                <td>'.$row["ITEM_NAME"].'</td>
                <td>'.$row["ITEM_AMOUNT"].'</td>
                <td>'.$row["CONFIRM_REQUEST"].'</td>
                <td> <a id="edit" href="edit-request.php?e='.$row['ITEM_REQUEST_ID'].'">Edit</a></td>
                <td> <a id="delete" onclick="return confirm(\'You Want To Delete This Item ?\');" href="item-request.php?p='.$row['ITEM_REQUEST_ID'].'">Delete</a></td>
                </tr>';
        }
     echo '</table>';


    ?>
    
</div>

<?php require_once('footer.php')?>
