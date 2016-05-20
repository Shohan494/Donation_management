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
        add_new_employee();
    }

    function add_new_employee()
    {
        if(!empty($_POST['name']) && !empty($_POST['salary']) && !empty($_POST['address']) 
            && !empty($_POST['branch']) && !empty($_POST['dept']) && !empty($_POST['phone'])) 
        {
            $name = $_POST['name'];
            $salary = $_POST['salary'];
            $address = $_POST['address'];
            $branch = $_POST['branch'];
            $dept = $_POST['dept'];
            $phone = $_POST['phone'];
            

            
            $conn = oci_connect("hr","shohanhr","localhost/XE");
                
            $query = "INSERT INTO employee(emp_id, b_id, emp_name, emp_salary, emp_address, emp_dept, phone) VALUES 
            (emp_seq.nextval, $branch, '$name', '$salary', '$address', '$dept', '$phone')";

               $stid = oci_parse($conn, $query);
               
                $result = oci_execute($stid);
                
                if(!$result) {
                    echo "Failed !";
                }else {
                    echo "Successfully added New Employee !";
                    header('Location: employee.php');
                }

        }else {
            echo "<p id=\"warning\">Fill All The Information !</p>";
        }
    }
?>

<div class="donor-section">
    <h1 class="menu-title">Add New Employee: </h1>
    <a href="employee.php" class="hlink cat-link">Back to Employee List</a>
    
        <form id="add-donor-form" name="donorform" action="add-employee.php" method="post">
       <br>
        <p class="form-text">Employee Name : </p>
        <input name="name" class="form-field" type="text" placeholder="Name">
        
        <p class="form-text">Salary : </p>
        <input name="salary" class="form-field" type="text" placeholder="Salary">
        
        <p class="form-text">Address : </p>
        <textarea name="address" id="textarea" class="form-field" cols="30" rows="10" placeholder="Address"></textarea>
        
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
        
        <p class="form-text">Department : </p>
        <input name="dept" class="form-field" type="text" placeholder="Department">
        
        <p class="form-text">Phone : </p>
        <input name="phone" class="form-field" type="text" placeholder="Phone">
        
        <br>
        <input type="submit" name="submit" id="submit" value="Add New Employee" class="form-field">
        
    </form>
</div>

<?php require_once('footer.php')?>
