<?php session_start(); ?>
<?php require_once('header.php');?>
<?php require_once('sidebar.php');?>
<?php
    //IF THERE IS NO SESSION VALUE N $USER VARIABLE
    //THE SYSTEM REDIRECTS TO LOGIN PAGE
    if(!$_SESSION['user'])
    {
        header('Location: login2.php');
    }

    if(isset($_POST['submit']))
    {
        add_new_branch();
    }

    function add_new_branch()
    {
        if(!empty($_POST['name']) && !empty($_POST['address']) 
            && !empty($_POST['area']) && !empty($_POST['phone'])) 
        {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $area = $_POST['area'];
            $phone = $_POST['phone'];

            
            $conn = oci_connect("hr","shohanhr","localhost/XE");
            
            //inserting the data to the database
            $query = "INSERT INTO branch(b_id, b_name, address, area, phone) 
                VALUES (branch_seq.nextval,'$name', '$address', '$area', '$phone')";

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

<div class="donor-section">
    <h1 class="menu-title">Add New Branch : </h1>
    <a href="branch.php" class="hlink cat-link">Back to Branch List</a>
    
        <form id="add-donor-form" name="donorform" action="add-branch.php" method="post">
       <br>
        <p class="form-text">Branch Name : </p>
        <input name="name" class="form-field" type="text" placeholder="Name">
        
        <p class="form-text">Address : </p>
        <textarea name="address" id="textarea" class="form-field" cols="30" rows="10" placeholder="Address"></textarea>
        
        <p class="form-text">Area : </p>
        <input name="area" class="form-field" type="text" placeholder="Area">
        
        <p class="form-text">Phone : </p>
        <input name="phone" class="form-field" type="text" placeholder="Phone">
        
        <br>
        <input type="submit" name="submit" id="submit" value="Add Branch" class="form-field">
        
    </form>
    
</div>

<?php require_once('footer.php')?>
