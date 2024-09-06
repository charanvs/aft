<?php require_once dirname(__FILE__).'/../config/route.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>AFT Delhi</title>
    <style type="text/css">
      .my-bg-color {
        background-color: #2E3192;
      }

      .my-color {
        color: #2E3192;
      }

      table th{
        padding: 5px !important;
        white-space: nowrap;
      }

      table td{
        padding: 3px !important;
        white-space: nowrap;
      }

      table thead{
        background-color: #2E3192;
        color: #ffffff;
      }
    </style>
  </head>
  <body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg my-bg-color navbar-dark">
      <div class="container">
      <a class="navbar-brand" href="<?php echo url; ?>">AFT Delhi</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav ml-auto">
          <!-- <li class="nav-item active">
            <a class="nav-link" href="<?php echo url; ?>">Home <span class="sr-only">(current)</span></a>
          </li> -->
          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
              Blogs
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="<?php echo url; ?>">Judgements</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo url.'views/daily-orders.php'; ?>">Daily Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo url.'views/registration-interim-judgements.php'; ?>">Interim Judgements</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="<?php echo url.'admins'; ?>">Login</a>
          </li> -->
          <!-- <li class="nav-item">
            <a class="nav-link" href="<?php echo url.'views/signup.php'; ?>">Signup</a>
          </li> -->
        </ul>
        <!-- <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
      </div>
      </div>
    </nav>
    <main>
      
    