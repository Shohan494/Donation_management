<?php session_start(); ?>
<?php require_once('header.php');?>
<?php require_once('sidebar.php');?>
<?php
    //IF THERE IS NO SESSION VALUE N $USER VARIABLE
    //THE SYSTEM REDIRECTS TO LOGIN PAGE
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
        
        $query = 'DELETE FROM item WHERE item_id='.$p;

        $stid = oci_parse($conn, $query);
        oci_execute($stid);
        
        header('Location: item.php');
        
    }
?>

<div class="donor-section">
    <h1 class="menu-title">Item : </h1>
    
    <?php

        $conn = oci_connect("hr","shohanhr","localhost/XE");
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        //fetching the data from database
        $stid = oci_parse($conn, 'SELECT * FROM item ORDER BY item_name ASC');
        oci_execute($stid);
    
        echo '<table class="tbls">
            <tr>
            <td>Item Name</td>
            <td>Item Amount</td>
            <td>Edit</td>
            </tr>';

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) 
        {
            echo '<tr>
            <td>'.$row["ITEM_NAME"].'</td>
            <td>'.$row["ITEM_AMOUNT"].'</td>
            <td> <a id="edit" href="edit-item.php?e='.$row['ITEM_ID'].'">Edit</a></td>
            </tr>';
        }
     echo '</table>';


    ?>
    
</div>

<?php require_once('footer.php')?>
