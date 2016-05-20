<?php session_start(); ?>
<?php require_once('header.php');?>
<?php require_once('sidebar.php');?>
<?php
    if(!$_SESSION['user'])
    {
        header('Location: login2.php');
    }


    //Donor Count

    $conn = oci_connect("hr","shohanhr","localhost/XE");
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM donor');
        oci_execute($stid);
        $donor_count = 0;

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { 
        $donor_count++;
    }

    //Item Count

    $conn = oci_connect('hr', 'shohanhr', 'localhost/xe');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM item');
        oci_execute($stid);
        $item_count = 0;

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { 
        $item_count++;
    }

//Item Request

    $conn = oci_connect('hr', 'shohanhr', 'localhost/xe');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM item_request');
        oci_execute($stid);
        $item_req = 0;

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { 
        $item_req++;
    }


//Branch

    $conn = oci_connect('hr', 'shohanhr', 'localhost/xe');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM branch');
        oci_execute($stid);
        $branch = 0;

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { 
        $branch++;
    }

//Employee

    $conn = oci_connect('hr', 'shohanhr', 'localhost/xe');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM employee');
        oci_execute($stid);
        $emp = 0;

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { 
        $emp++;
    }


    //User or Admin

    $conn = oci_connect('hr', 'shohanhr', 'localhost/xe');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM user_info');
        oci_execute($stid);
        $user = 0;

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { 
        $user++;
    }

    //Log Report

    $conn = oci_connect('hr', 'shohanhr', 'localhost/xe');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM user_triger');
        oci_execute($stid);
        $log = 0;

    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) { 
        $log++;
    }
?>




<div id="dashboard-section">
    <ul id="dashboardlist">
        <li>
            <p>Donor Number : <span class="dash"><?php echo $donor_count; ?></span> </p>
        </li>
        <li>
            <p>Total Donations : <span class="dash"><?php echo $item_count; ?></span></p>
        </li>
        <li>
            <p>Total Requests : <span class="dash"><?php echo $item_req; ?></span></p>
        </li>
        <li>
            <p>Total Branchs : <span class="dash"><?php echo $branch; ?></span></p>
        </li>
        <li>
            <p>Total Employees: <span class="dash"><?php echo $emp; ?></span></p>
        </li>
        <li>
            <p>Total Admins : <span class="dash"><?php echo $user; ?></span></p>
        </li>
        <li>
            <p>Admin Log Report : <span class="dash"><?php echo $log; ?></span></p>
        </li>
        
    </ul>
    
    <div class="dashboard-links">
            <a href="add-donor.php" class="hlink">Add New Donor</a>
            <a style="margin-left: 100px;" href="add-request.php" class="hlink">Add New Request</a>
            <a href="add-branch.php" class="hlink">Add New Branch</a>
            <a style="margin-left: 79px;" href="add-employee.php" class="hlink">Add New Employee</a>
            <a href="add-user.php" class="hlink">Add New Admin</a>
            <a style="margin-left: 98px;" href="log.php" class="hlink">Admin Log Report</a>
            
    </div>
            
</div>

<?php require_once('footer.php')?>
