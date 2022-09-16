<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$date = $deliveryNo  = $dlocation ="";
$driverName_err = $deliveryNo_err = $dlocation_err ="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate number of Deliveries
    $input_deliveryNo = trim($_POST["deliveryNo"]);
    if(empty($input_deliveryNo)){
        $deliveryNo_err = "Please enter Number of Deliveries";

    // } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
    //     $name_err = "Please enter a valid location.";

    } else{
        $deliveryNo = $input_deliveryNo;
    }
    
    // Validate Delivery location
    $input_dlocation = trim($_POST["dlocation"]);
    if(empty($input_dlocation)){
        $dlocation_err = "Please enter a Delivery location.";     
    } else{
        $dlocation = $input_dlocation;
    }
    
    // Validate date
    $input_date = trim($_POST["date"]);
    if(empty($input_date)){
        $date_err = "Please enter a date.";     
    } else{
        $date = $input_date;
    }
    // $input_placeOfResidence = trim($_POST["placeOfResidence"]);
    // if(empty($input_placeOfResidence)){
    //     $placeOfResidence_err = "Please enter the Place of residence.";
    // }  else{
    //     $placeOfResidence = $input_placeOfResidence;
    // }
    // // Validate email
    // $input_email = trim($_POST["email"]);
    // if(empty($input_email)){
    //     $email_err = "Please enter the email.";
    // }  else{
    //     $email = $input_email;
    // }
    
    // Check input errors before inserting in database
    if(empty($dlocation_err) && empty($deliveryNo_err) && empty($date_err)){
 // Prepare an insert statement
 $sql = "INSERT INTO dregister(date, deliveryNo, dlocation) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_date, $param_deliveryNo, $param_dlocation);

            // if($stmt = mysqli_prepare($link, $sql)){
            //     // Bind variables to the prepared statement as parameters
            //     mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            
            // Set parameters
            $param_date = $date;
            $param_deliveryNo = $deliveryNo;
            $param_dlocation = $dlocation;           
            
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
                    <p>Please fill this form and submit to register into the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                            <label>Number of deliveries</label>
                            <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                        </div><div class="form-group">
                            <label>Number of deliveries</label>
                            <input type="text" name="deliveryNo" class="form-control <?php echo (!empty($deliveryNo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $deliveryNo; ?>">
                            <span class="invalid-feedback"><?php echo $deliveryNo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Delivery Location</label>
                            <textarea name="dlocation" class="form-control <?php echo (!empty($dlocation_err)) ? 'is-invalid' : ''; ?>"><?php echo $dlocation; ?></textarea>
                            <span class="invalid-feedback"><?php echo $dlocation_err;?></span>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>