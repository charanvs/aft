<?php require_once dirname(__FILE__).'/views/header.php'; ?>
<div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

  <div class="error-content">
    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

    <p>
      We could not find the page you were looking for.
      Meanwhile, you may <a href="<?php echo url.'admins/controllers/Dashboard.php?action=dashboard'; ?>">return to dashboard</a>.
    </p>

    <!-- <form class="search-form">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search">

        <div class="input-group-append">
          <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->
  </div>
  <!-- /.error-content -->
</div>

<?php require_once dirname(__FILE__).'/views/footer.php'; ?>