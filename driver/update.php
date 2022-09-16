<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$date = $deliveryNo  = $dlocation = "";
$date_err = $deliveryNo_err = $dlocation_err ="";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate date
    $input_date = trim($_POST["date"]);
    if(empty($input_date)){
        $date_err = "Please enter a date.";
    } else{
        $date = $input_date;
    }
    
    // Validate number of deliveries
    $input_deliveryNo = trim($_POST["deliveryNo"]);
    if(empty($input_deliveryNo)){
        $deliveryNo_err = "Please enter a Telephone contact.";     
    } else{
        $deliveryNo = $input_deliveryNo;
    }
    
    // Validate delivery location
    $input_dlocation = trim($_POST["dlocation"]);
    if(empty($input_dlocation)){
        $dlocation_err = "Please enter the delivery locstion.";
    }  else{
        $dlocation = $input_dlocation;

    }
    
    // Check input errors before inserting in database $driverName_err = $telContact_err = $placeOfResidence_err = "";
    if(empty($date_err) && empty($deliveryNo_err) && empty($dlocation_err)){
        // Prepare an update statement
        $sql = "UPDATE dregister SET date=?, deliveryNo=?, dlocation=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_date, $param_deliveryNo, $param_dlocation, $param_id);
            
            // Set parameters
            $param_date = $date;
            $param_deliveryNo = $deliveryNo;
            $param_dlocation = $dlocation;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM dregister WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $date = $row["date"];
                    $deliveryNo = $row["deliveryNo"];
                    $dlocation = $row["dlocation"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
 <?php 
include "header.inc.php";
?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="date" name="date" class="form-control <?php echo (!empty($date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $date; ?>">
                            <span class="invalid-feedback"><?php echo $date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Number of Deliveries</label>
                            <textarea name="deliveryNo" class="form-control <?php echo (!empty($deliveryNo_err)) ? 'is-invalid' : ''; ?>"><?php echo $deliveryNo; ?></textarea>
                            <span class="invalid-feedback"><?php echo $deliveryNo_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Place Of Residence</label>
                            <input type="text" name="dlocation" class="form-control <?php echo (!empty($dlocation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dlocation; ?>">
                            <span class="invalid-feedback"><?php echo $dlocation_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
