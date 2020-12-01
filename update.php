<?php
var_dump($_SERVER['QUERY_STRING']);
require 'header.php';
require 'database.php';
require 'uploader.php';
require 'input.php';

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: view.php");
}

$genderInput = new Gender();
$countryInput = new Country();


if (!empty($_POST)) {
    $uploader = new Uploader();

    // keep track validation errors
    $nameError = null;
    $emailError = null;
    $mobileError = null;
    $imageError = null;
    $genderError = null;
    $countryError = null;

    // keep track post values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $image = $_POST['image'];
    $gender = $_POST['gender'];
    $country = $_POST['country'];

    // validate input
    $valid = true;
    if (empty($name)) {
        $nameError = 'Please enter Name';
        $valid = false;
    }

    if (empty($email)) {
        $emailError = 'Please enter Email Address';
        $valid = false;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Please enter a valid Email Address';
        $valid = false;
    }

    if (empty($mobile)) {
        $mobileError = 'Please enter Mobile Number';
        $valid = false;
    }

    if (!empty($_FILES['image']['name']) && !$uploader->valid($_FILES['image']))
    {
        $imageError = 'Invalid file uploaded';
        $valid = false;
    }

    if (!$genderInput->isValid($gender))
    {
        $genderError = 'Invalid gender';
        $valid = false;
    }

    if (!$countryInput->isValid($country))
    {
        $countryError = 'Invalid country';
        $valid = false;
    }

    // update data
    if ($valid) {
        // upload file
        // delete old
        if (!empty($image)) {
            $uploader->delete($image);
        }
        $image = $uploader->upload($_FILES['image']);

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE customers  set name = ?, email = ?, mobile =?, image = ?, gender = ?, country = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($name, $email, $mobile, $image, $gender, $country, $id));
        Database::disconnect();
        header("Location: view.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM customers where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $name = $data['name'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $image = $data['image'];
    $gender = $data['gender'];
    $country = $data['country'];
    Database::disconnect();
}
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
            <h3>Update a Customer</h3>
        </div>

        <form class="form-horizontal" action="update.php?id=<?php echo $id ?>" method="post"
              enctype="multipart/form-data">
            <div class="control-group <?php echo !empty($nameError) ? 'error' : ''; ?>">
                <label class="control-label">Name</label>

                <div class="controls">
                    <input name="name" type="text" placeholder="Name" value="<?php echo !empty($name) ? $name : ''; ?>">
                    <?php if (!empty($nameError)): ?>
                        <span class="help-inline"><?php echo $nameError; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($emailError) ? 'error' : ''; ?>">
                <label class="control-label">Email Address</label>

                <div class="controls">
                    <input name="email" type="text" placeholder="Email Address"
                           value="<?php echo !empty($email) ? $email : ''; ?>">
                    <?php if (!empty($emailError)): ?>
                        <span class="help-inline"><?php echo $emailError; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($mobileError) ? 'error' : ''; ?>">
                <label class="control-label">Mobile Number</label>

                <div class="controls">
                    <input name="mobile" type="text" placeholder="Mobile Number"
                           value="<?php echo !empty($mobile) ? $mobile : ''; ?>">
                    <?php if (!empty($mobileError)): ?>
                        <span class="help-inline"><?php echo $mobileError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group <?php echo !empty($imageError) ? 'error' : ''; ?>">
                <label class="control-label">Image</label>
                <div class="controls">
                    <input name="image" type="file" placeholder="File">
                    <input name="image" type="hidden" value="<?php echo $image; ?>">
                    <?php if (!empty($imageError)): ?>
                        <span class="help-inline"><?php echo $imageError; ?></span>
                    <?php endif; ?>
                </div>
            </div>


            <?php if (!empty($image)): ?>
                <div class="control-group">
                    <div class="controls">
                        <img src="<?php echo $image; ?>" class="thumbnail"/>
                    </div>
                </div>
            <?php endif; ?>


            <div class="control-group <?php echo !empty($genderError) ? 'error' : ''; ?>">
                <label class="control-label">Gender</label>
                <div class="controls">
                    <?php
                    echo $genderInput->input($gender);
                    ?>
                    <?php if (!empty($genderError)): ?>
                        <span class="help-inline"><?php echo $genderError; ?></span>
                    <?php endif; ?>
                </div>
            </div>


            <div class="control-group <?php echo !empty($countryError) ? 'error' : ''; ?>">
                <label class="control-label">Country</label>
                <div class="controls">
                    <?php
                    echo $countryInput->input($country);
                    ?>
                    <?php if (!empty($countryError)): ?>
                        <span class="help-inline"><?php echo $countryError; ?></span>
                    <?php endif; ?>
                </div>
            </div>



            <div class="form-actions">
                <button type="submit" class="btn btn-success">Update</button>
                <a class="btn" href="view.php">Back</a>
            </div>
        </form>
    </div>

</div>
<!-- /container -->
</body>
</html>