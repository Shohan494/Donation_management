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
        
        $query = 'DELETE FROM user_info WHERE user_id='.$p;

        $stid = oci_parse($conn, $query);
        oci_execute($stid);
        
        header('Location: user.php');
        
    }
?>

<div class="donor-section">
    <h1 class="menu-title">Admins : </h1>
    <a href="add-user.php" class="hlink cat-link">Add New Admin</a>
    <a href="log.php" class="hlink cat-link">Admins Log Report</a>
    
    <?php

        $conn = oci_connect("hr","shohanhr","localhost/XE");
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM user_info');
        oci_execute($stid);

    
        echo '<table class="tbls">
            <tr>
            <td>Username</td>
            <td>Edit</td>
            <td>Delete</td>
            </tr>';

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            
            echo '<tr>
            <td>'.$row["USERNAME"].'</td>
            <td> <a id="edit" href="edit-user.php?e='.$row['USER_ID'].'">Edit</a></td>
            <td> <a id="delete" onclick="return confirm(\'You Want To Delete This Item ?\');" href="user.php?p='.$row['USER_ID'].'">Delete</a></td>
            </tr>';
        }
     echo '</table>';

    ?>
</div>


<?php require_once('footer.php')?>
