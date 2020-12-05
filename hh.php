<html lang="en">
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <meta name="description" content="">
 <meta name="author" content="">
 <title>SB Admin - Start Bootstrap Template</title>
 <!-- Bootstrap core CSS-->
 <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
 <!-- Custom fonts for this template-->
 <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
 <!-- Custom styles for this template-->
 <link href="css/sb-admin.css" rel="stylesheet">
</head>
<body class="bg-dark">
 <div class="container">
   <div class="card card-register mx-auto mt-5">
     <div class="card-header">Register an Account</div>
     <div class="card-body">
       <form method="post" action="register.php">
         <?php include('errors.php'); ?>
         <div class="form-group">
           <div class="form-row">
             <div class="col-md-12">
               <label for="exampleInputName">Username</label>
               <input class="form-control" id="exampleInputName" type="text"   name="username" value="<?php echo $username; ?>" >
             </div>
           </div>
         </div>
         <div class="form-group">
           <label for="exampleInputEmail1">Email address</label>
           <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" name="email" value="<?php echo $email; ?>" >
         </div>
         <div class="form-group">
           <div class="form-row">
             <div class="col-md-6">
               <label for="exampleInputPassword1">Password</label>
               <input class="form-control" id="exampleInputPassword1" type="password" name="password_1" >
             </div>
           </div>
         </div>
          <button type="submit" class="btn btn-primary btn-block" name="reg_user">Register</button>
       </form>
       <div class="text-center">
         <a class="d-block small mt-3" href="login.php">Login Page</a>
       <!--- <a class="d-block small" href="forgot-password.html">Forgot Password?</a>-->
       </div>
     </div>
   </div>
 </div>
 <!-- Bootstrap core JavaScript-->
 <script src="vendor/jquery/jquery.min.js"></script>
 <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 <!-- Core plugin JavaScript-->
 <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>
</html>


<?php
if (isset($_POST['reg_user'])) {
// receive all input values from the form
$username = mysqli_real_escape_string($db, $_POST['username']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);


$query = "INSERT INTO admin(username, password, email)
VALUES('$username', '$password', '$email')";
mysqli_query($db, $query);
$_SESSION['username'] = $username;
$_SESSION['success'] = "You are now logged in";
header('location: adminpanel\index.php');
}

?>