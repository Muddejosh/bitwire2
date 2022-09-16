<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$driverName = $telContact  = $placeOfResidence = $email = "";
$driverName_err = $telContact_err = $placeOfResidence_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_driverName = trim($_POST["driverName"]);
    if(empty($input_driverName)){
        $driverName_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $driverName_err = "Please enter a valid name.";
    } else{
        $driverName = $input_driverName;
    }
    
    // Validate tel contact
    $input_telContact = trim($_POST["telContact"]);
    if(empty($input_telContact)){
        $telContact_err = "Please enter a Telephone contact.";     
    } else{
        $telContact = $input_telContact;
    }
    
    // Validate residence
    $input_placeOfResidence = trim($_POST["placeOfResidence"]);
    if(empty($input_placeOfResidence)){
        $placeOfResidence_err = "Please enter the Place of residence.";
    }  else{
        $placeOfResidence = $input_placeOfResidence;
    }
    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter the email.";
    }  else{
        $email = $input_email;
    }
    
    // Check input errors before inserting in database
    if(empty($driverName_err) && empty($telContact_err) && empty($placeOfResidence_err) && empty($email_err)){
 // Prepare an insert statement
 $sql = "INSERT INTO driver(driverName, telContact, placeOfResidence, email) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_driverName, $param_telContact, $param_placeOfResidence,$param_email);

            // if($stmt = mysqli_prepare($link, $sql)){
            //     // Bind variables to the prepared statement as parameters
            //     mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            
            // Set parameters
            $param_driverName = $driverName;
            $param_telContact = $telContact;
            $param_placeOfResidence = $placeOfResidence;
            $param_email = $email;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
 <?php 
include "header.inc.php";
?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="driverName" class="form-control <?php echo (!empty($driverName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $driverName; ?>">
                            <span class="invalid-feedback"><?php echo $driverName_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Telephone Contact</label>
                            <input type="text" name="telContact" class="form-control <?php echo (!empty($telContact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $telContact; ?>">
                            <span class="invalid-feedback"><?php echo $telContact_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Place Of Residence</label>
                            <input type="text" name="placeOfResidence" class="form-control <?php echo (!empty($placeOfResidence_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $placeOfResidence; ?>">
                            <span class="invalid-feedback"><?php echo $placeOfResidence_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>