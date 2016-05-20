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
                
            global $e; 
            $query = "UPDATE employee SET b_id ='$branch', emp_name ='$name', emp_salary ='$salary', emp_address ='$address',
            emp_dept ='$dept', phone ='$phone' WHERE emp_id =".$e;

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


<?php

            global $e;
            $conn = oci_connect("hr","shohanhr","localhost/XE");
            if (!$conn) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            
            $query = 'SELECT * FROM employee WHERE emp_id ='.$e;

            $stid = oci_parse($conn, $query);
            oci_execute($stid);
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                
        
 ?>

<div class="donor-section">
    <h1 class="menu-title">Edit Employee: </h1>
    <a href="employee.php" class="hlink cat-link">Back to Employee List</a>
    
        <form id="add-donor-form" name="donorform" action="edit-employee.php?e=<?php echo $e;?>" method="post">
       <br>
        <p class="form-text">Employee Name : </p>
        <input name="name" class="form-field" type="text" placeholder="Name" value="<?php echo $row['EMP_NAME']?>">
        
        <p class="form-text">Salary : </p>
        <input name="salary" class="form-field" type="text" placeholder="Salary" value="<?php echo $row['EMP_SALARY']?>"
        
        <p class="form-text">Address : </p>
        <textarea name="address" id="textarea" class="form-field" cols="30" rows="10" placeholder="Address" ><?php echo $row['EMP_ADDRESS']?></textarea>
        
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
        
        <p class="form-text">dept : </p>
        <input name="dept" class="form-field" type="text" placeholder="Department" value="<?php echo $row['EMP_DEPT']?>">
        
        <p class="form-text">Phone : </p>
        <input name="phone" class="form-field" type="text" placeholder="Phone" value="<?php echo $row['PHONE']?>">
        
        <br>
        <input type="submit" name="submit" id="submit" value="Update Employee" class="form-field">
        
    </form>
</div>

<?php 
    }
?>

<?php require_once('footer.php')?>
