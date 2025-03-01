<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charity Donation Platform</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <div id="logo" class="container-fluid col-3">
           <a href="#" class="navbar-brand pe-5"><h3><span style="color: orange;">Go</span> <span class="text-light">help</span> <span style="color: orange;"> me</span></h3></a>
    </div>
    <div class="container flex-lg-row">       
           <button class="navbar-toggler ps-1 pe-1 " type="button" data-bs-toggle="collapse" data-bs-target="#navbar" >
               <span class="navbar-toggler-icon bg-light"></span>
           </button>
  <div class="collapse navbar-collapse" id="navbar">
    <ul class="navbar-nav ml-auto">
    <li class="nav-item" ><a class="nav-link text-light"  href="index.php">HOME</a></li>
      <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
    <li class="nav-item" ><a class="nav-link text-light"  href="dashboard.php">Dashboard</a></li>
    <li class="nav-item" ><a class="nav-link text-light"  href="logout.php">Logout</a></li>

      <?php else: ?>
        <li class="nav-item" ><a class="nav-link text-light"  href="login.php">Login</a></li>
        <li class="nav-item" ><a class="nav-link text-light"  href="register.php">DONATE</a></li>
      <?php endif; ?>
    </ul>
  </div>
      </div>
</nav>
<div class="container">