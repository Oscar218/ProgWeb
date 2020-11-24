<?php
require 'database.php';
require 'input.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM customers where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
}

$genderInput = new Gender();
$countryInput = new Country();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">

    <div class="span10 offset1">
        <div class="row">
            <h3>Read a Customer</h3>
        </div>

        <div class="form-horizontal">
            <div class="control-group">
                <label class="control-label">Name</label>

                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['name']; ?>
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Email Address</label>

                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['email']; ?>
                    </label>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Mobile Number</label>

                <div class="controls">
                    <label class="checkbox">
                        <?php echo $data['mobile']; ?>
                    </label>
                </div>
            </div>

            <?php if (!empty($data['image'])): ?>
                <div class="control-group">
                    <div class="controls">
                        <img src="<?php echo $data['image']; ?>" class="thumbnail"/>
                    </div>
                </div>
            <?php endif; ?>

            <div class="control-group">
                <label class="control-label">Gender</label>

                <div class="controls">
                    <label class="checkbox">
                        <?php echo $genderInput->show($data['gender']); ?>
                    </label>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label">Country</label>

                <div class="controls">
                    <label class="checkbox">
                        <?php echo $countryInput->show($data['country']); ?>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <a class="btn" href="index.php">Back</a>
            </div>


        </div>
    </div>

</div>
<!-- /container -->
</body>
</html>