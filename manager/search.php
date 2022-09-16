<?php 
include "header.inc.php";
?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Driver Records</h2>
                        <a href="register.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Record</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";

                    $query = $_GET['query']; 
                    // gets value sent over search form
                    
                    $min_length = 3;
                    // you can set minimum length of the query if you want
                    
                    if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
                        
                        $query = htmlspecialchars($query); 
                        // changes characters used in html to their equivalents, for example: < to &gt;
                        
                        $query = mysqli_real_escape_string($link, $query);
                        // makes sure nobody uses SQL injection
                        
                        $raw_results = mysqli_query($link,"select driver.driverName, telContact, dlocation, deliveryNo from driver inner join dregister on driver.id= dregister.id 
                            WHERE (`driverName` LIKE '%".$query."%') OR (`dlocation` LIKE '%".$query."%')") or die(mysql_error());
                            
                        // * means that it selects all fields, you can also write: `id`, `title`, `text`
                        // articles is the name of our table
                        
                        // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
                        // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
                        // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'
                        
                        if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following
                            
                            while($results = mysqli_fetch_array($raw_results)){
                              echo '<table class="table table-bordered table-striped">';
                                        echo "<thead>";
                                            echo "<tr>";
                                                // echo "<th>#</th>";
                                                echo "<th>Driver Name</th>";
                                                echo "<th>Telephone</th>";
                                                echo "<th>Current Location</th>";
                                                echo "<th>Number of deliveries</th>";
                                                
                                            echo "</tr>";
                                        echo "</thead>";
                                        echo "<tbody>";
                                        while($row = mysqli_fetch_array($result)){
                                            echo "<tr>";
                                                echo "<td>" . $row['driverName'] . "</td>";
                                                echo "<td>" . $row['telContact, '] . "</td>";
                                                echo "<td>" . $row['dlocation,'] . "</td>";
                                                echo "<td>" . $row['deliveryNo'] . "</td>";
        
                                                echo "<td>";
                                                    echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                                    echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                                echo "</td>";
                                            echo "</tr>";
                                        }
                            //             echo "</tbody>";                            
                            //         echo "</table>";
                            //         // Free result set
                            //         mysqli_free_result($result);
                            //     } else{
                            //         echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                            //     }
                            // } else{
                            //     echo "Oops! Something went wrong. Please try again later.";
                            // }
                                echo "<p><h3>".$results['driverName']."</h3>".$results['dlocation']."</p>";
                                // posts results gotten from database(title and text) you can also show id ($results['id'])
                            }
                            
                        }
                        else{ // if there is no matching rows do following
                            echo "No results";
                        }
                        
                    }
                    // else{ // if query length is less than minimum
                    //     echo "Minimum length is ".$min_length;
                    // }
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>