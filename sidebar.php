<div class="head-section">
    <h1 id="heading"><center>Online Donation Management System</center></h1>
</div>

<div id="mini-section" class="clearfix">
    <ul class="header-list">
        <li><a href="">
            <?php
                //Procedure

                $conn = oci_connect("hr","shohanhr","localhost/XE");

                $sql = 'BEGIN sayHello(:name, :message); END;';

                $stmt = oci_parse($conn,$sql);

                //  Bind the input parameter
                oci_bind_by_name($stmt,':name',$name,32);

                // Bind the output parameter
                oci_bind_by_name($stmt,':message',$message,32);

                // Assign a value to the input 
                $name = $_SESSION['user'];

                oci_execute($stmt);

                // $message is now populated with the output value
                print "$message\n";

            ?>
            </a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="sidebar">
    <ul class="main-nav">  
        <a href="home.php">
            <li>
                <p>Dashboard</p>
            </li>
        </a>
        <a href="donor.php">
            <li>
                <p>Donor List</p>
            </li>
        </a>
        <a href="branch.php">
            <li>
                <p>Branch list</p>
            </li>
        </a>
        <a href="item.php">
            <li>
                <p>Items List</p>
            </li>
        </a>
        <a href="item-request.php">
            <li>
                <p>Donation Request</p>
            </li>
        </a>
        <a href="employee.php">
            <li>
                <p>Employee List</p>
            </li>
        </a>
        <a href="user.php">
            <li>
                <p>Admin List</p>
            </li>
        </a>
        <a href="logout.php">
            <li>
                <p>Logout</p>
            </li>
        </a>
        
    </ul>
</div>