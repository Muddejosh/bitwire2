<?php
require_once "config.php";
 
// Define variables and initialize with empty values
$driverName = $telContact  = $placeOfResidence = $placeOfResidence = "";
$driverName_err = $telContact_err = $placeOfResidence_err = $placeOfResidence_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["driverName"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $driverName = $input_name;
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

    }// Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email = "Please enter the email.";
    }  else{
        $email = $input_email;
    }
    
    // Check input errors before inserting in database $driverName_err = $telContact_err = $placeOfResidence_err = "";
    if(empty($driverName_err) && empty($telContact_err) && empty($placeOfResidence_err) && empty($email_err)){
        // Prepare an update statement
        $sql = "UPDATE driver SET driverName=?, telContact=?, placeOfResidence=?, email=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_driverName, $param_telContact, $param_placeOfResidence, $param_email, $param_id);
            
            // Set parameters
            $param_driverName = $driverName;
            $param_telContact = $telContact;
            $param_placeOfResidence = $placeOfResidence;
            $param_email = $email;
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
        $sql = "SELECT * FROM driver WHERE id = ?";
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
                    $driverName = $row["driverName"];
                    $telContact = $row["telContact"];
                    $placeOfResidence = $row["placeOfResidence"];
                    $email = $row["email"];
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
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                            <label>Place Of Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
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
