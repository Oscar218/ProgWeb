<?php
include'header.php';
include'home.php';
include'footer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    		<div class="row">
                <div class="span12">
    			    <h3>Orcamentos_Mençal_Anual</h3>
                </div>
    		</div>
			<div class="row">

                <div class="span6">
                    <p>
                        <a href="create.php" class="btn btn-success">Create</a>
                    </p>
                </div>

                <div class="span6">
                    <form class="form-search pull-right" action="<?php echo $_SERVER['PHP_SELF'];?>" method="get">
                        <input type="text" name="query" class="input-medium search-query" value="<?php echo isset($_GET['query'])?$_GET['query']:'';?>">
                        <button type="submit" class="btn">Search</button>
                    </form>
                </div>

                <div class="span12">
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Name</th>
		                  <th>Email_Ref</th>
		                  <th>Valor / Preços</th>
		                  <th>Action / Edit</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
                       include 'paginator.php';
                       include 'database.php';
                       $pdo = Database::connect();

                       $paginator = new Paginator();
                       $sql = "SELECT count(*) FROM customers ";
                       $paginator->paginate($pdo->query($sql)->fetchColumn());

                       $sql = "SELECT * FROM customers ";

                       $query = isset($_GET['query'])?('%'.$_GET['query'].'%'):'%';
                       $sql .= "WHERE name LIKE :query OR email LIKE :query OR mobile LIKE :query ";

                       $start = (($paginator->getCurrentPage()-1)*$paginator->itemsPerPage);
                       $length = ($paginator->itemsPerPage);
                       $sql .= "ORDER BY id DESC limit :start, :length ";

                       $sth = $pdo->prepare($sql);
                       $sth->bindParam(':start',$start,PDO::PARAM_INT);
                       $sth->bindParam(':length',$length,PDO::PARAM_INT);
                       $sth->bindParam(':query',$query,PDO::PARAM_STR);
                       $sth->execute();

	 				   foreach ($sth->fetchAll(PDO::FETCH_ASSOC) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
							   	echo '<td>'. $row['mobile'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
                <?php
                echo $paginator->pageNav();
                ?>
                </div>
    	    </div>
    </div> <!-- /container -->
  </body>
</html>
<?php

?>