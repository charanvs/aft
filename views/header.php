<?php 
require_once dirname(__FILE__) . '/../config/route.php';

// Get the current file name to determine the active page
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Optional Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>AFT Delhi</title>
    <style type="text/css">
      .my-bg-color {
        background-color: #2E3192;
      }

      .my-color {
        color: #2E3192;
      }

      table th {
        padding: 5px !important;
        white-space: nowrap;
      }

      table td {
        padding: 3px !important;
        white-space: nowrap;
      }

      table thead {
        background-color: #2E3192;
        color: #ffffff;
      }

      /* Active link styles */
      .nav-link.active {
        font-weight: bold;
        border-bottom: 2px solid #ffffff;
      }

      /* Hover dropdown */
      .nav-item.dropdown:hover .dropdown-menu {
        display: block;
      }
    </style>
  </head>
  <body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg my-bg-color navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="http://aftdelhi.nic.in">AFT Delhi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="<?php echo url; ?>">Judgements</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'registration-interim-judgements.php') ? 'active' : ''; ?>" href="<?php echo url . 'views/registration-interim-judgements.php'; ?>">Daily Orders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'diary_cases.php') ? 'active' : ''; ?>" href="<?php echo url . 'views/diary_cases.php'; ?>">Diary</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'calendar.php' || $current_page == 'tentative_list.php') ? 'active' : ''; ?>" href="<?php echo url . 'views/calendar.php'; ?>">Tentative List</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?php echo ($current_page == 'judgements_rb.php' || $current_page == 'rb_causelist.php') ? 'active' : ''; ?>" href="#" id="regionalBenchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Regional Bench
              </a>
              <div class="dropdown-menu" aria-labelledby="regionalBenchDropdown">
                <a class="dropdown-item <?php echo ($current_page == 'judgements_rb.php') ? 'active' : ''; ?>" href="<?php echo url . 'views/judgements_rb.php'; ?>">Judgements</a>
                <a class="dropdown-item <?php echo ($current_page == 'cause_list_rb.php') ? 'active' : ''; ?>" href="<?php echo url . 'views/rb_causelist.php'; ?>">Cause List</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
<main>
