
       <?php 
include "header.inc.php";
?>
       <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Driver Details</h2>
                        <!-- <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Employee</a> -->
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    ?>
                    <form action="search.php" method="GET">
                    <table class="table table-bordered table-striped">                            <tr>
                                <td >
                                <input type="text" name="query" />
		<input type="submit" value="Search" />
                                </td>
                            </tr>
                        
                        </table>
		
	</form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>