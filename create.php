 <?php
include'header.php';
require 'database.php';
require 'uploader.php';
require 'input.php';


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

    // insert data
    if ($valid) {
        // file upload
        $image = $uploader->upload($_FILES['image']);
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO customers (name,email,mobile,image,gender,country) values(?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($name, $email, $mobile, $image, $gender, $country));
        Database::disconnect();
        header("Location: view.php");
    }
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
            <h4>Create nova entrada</h4>
        </div>

        <form class="form-horizontal" action="create.php" method="post" enctype="multipart/form-data">
            <div class="control-group <?php echo !empty($nameError) ? 'error' : ''; ?>">
                <label class="control-label">Name</label>

                <div class="controls">
                    <input name="name" type="text" placeholder="Name" value="<?php echo !empty($name) ? $name : ''; ?>">
                    <?php if (!empty($nameError)): ?>
                        <span class="help-inline"><?php echo $nameError; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            
            
           
           
           
           
            <div class="control-group <?php echo !empty($mobileError) ? 'error' : ''; ?>">
                <label class="control-label">Valor/Preços</label>

                <div class="controls">
                    <input name="mobile" type="number" placeholder="Valor"
                           value="<?php echo !empty($mobile) ? $mobile : ''; ?>">
                    <?php if (!empty($mobileError)): ?>
                        <span class="help-inline"><?php echo $mobileError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            
            
            
            

            
            
            <div class="control-group <?php echo !empty($genderError) ? 'error' : ''; ?>">
                <label class="control-label">Gender</label>
                <div class="controls">
                    <?php
                        echo $genderInput->input();
                    ?>
                    <?php if (!empty($genderError)): ?>
                        <span class="help-inline"><?php echo $genderError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            
            
            <div class="control-group <?php echo !empty($countryError) ? 'error' : ''; ?>">
                <label class="control-label">Tipo Entrada</label>
                <div class="controls">
                    <?php
                        echo $countryInput->input();
                    ?>
                    <?php if (!empty($countryError)): ?>
                        <span class="help-inline"><?php echo $countryError; ?></span>
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

            <div class="control-group <?php echo !empty($imageError) ? 'error' : ''; ?>">
                <label class="control-label">Image</label>
                <div class="controls">
                    <input name="image" type="file" placeholder="File">
                    <?php if (!empty($imageError)): ?>
                        <span class="help-inline"><?php echo $imageError; ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Create</button>
                <a class="btn" href="index.php">Back</a>
            </div>
        </form>
    </div>

</div>
<!-- /container -->
</body>
</html>