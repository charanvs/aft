<?php require_once dirname(__FILE__).'/header.php';
      require_once dirname(__FILE__).'/../models/DailyOrdersModel.php';
      $model = new DailyOrdersModel();

      $courtno = '';
      if(isset($_GET['courtno'])){
        $courtno = $_GET['courtno'];
        $_SESSION['courtno'] = $courtno;
      }

      $registration_no = '';
      if(isset($_GET['registration_no'])){
        $registration_no = $_GET['registration_no'];
        $_SESSION['registration_no'] = $registration_no;
      }

      $applicant = '';
      if(isset($_GET['applicant'])){
        $applicant = $_GET['applicant'];
        $_SESSION['applicant'] = $applicant;
      }

      $filterData['courtno'] = $courtno;
      $filterData['registration_no'] = $registration_no;
      $filterData['applicant'] = $applicant;

      $record_per_page = 10;
      if(isset($_GET['record_per_page'])){
        $record_per_page = $_GET['record_per_page'];
      }
      $startPage = $model->page($record_per_page);

      $search = '';
      $totalRecords = 0;
      if(isset($_GET['search'])){
        $search = $_GET['search'];
        $searchData['registration_no'] = $search;
        $searchData['courtno'] = $search;
        $searchData['applicant'] = $search;
        $results = $model->search('aft_hkt_dailyorders',$searchData ," limit $startPage, $record_per_page");
        if($results != null){
          $totalRecords = count($model->search('aft_hkt_dailyorders',$searchData));
        }
      }
      else{
        $results = $model->getFilter('aft_hkt_dailyorders',$filterData, " limit $startPage, $record_per_page");
        if($results != null){
          $totalRecords = count($model->getFilter('aft_hkt_dailyorders',$filterData));
        }
      }
?>

<style type="text/css">

</style>


<section class="container mt-3">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h5>Daily Order List</h5>
          </div>
          <div class="col-md-6">
            <div class="float-sm-right d-flex justify-content-right">
              <select id="record_per_page" class="form-control-sm mr-1" onchange="filter()">
                <option value="10" <?php echo $record_per_page == 10 ? 'selected' : ''; ?>>10</option>
                <option value="25" <?php echo $record_per_page == 25 ? 'selected' : ''; ?>>25</option>
                <option value="50" <?php echo $record_per_page == 50 ? 'selected' : ''; ?>>50</option>
                <option value="100" <?php echo $record_per_page == 100 ? 'selected' : ''; ?>>100</option>
                <option value="250" <?php echo $record_per_page == 250 ? 'selected' : ''; ?>>250</option>
                <option value="500" <?php echo $record_per_page == 500 ? 'selected' : ''; ?>>500</option>
              </select>
              <div class="input-group">
                <input type="text" id="search" class="form-control border-secondary" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" value="<?php echo !empty($search) ? $search : ''; ?>" style="height: 32px;">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary btn-sm" type="button" onclick="filter()"><i class="fa fa-search"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 form-group">
            <!--<input name="courtno" type="text" id="courtno" placeholder="Court No." class="form-control-sm w-100" value="<?php echo $courtno; ?>">-->
            <select name="courtno" type="text" id="courtno" class="form-control-sm w-100">
              <option value="">All Courts</option>
              <option value="1" <?php echo $courtno == 1 ? "selected" : ""; ?>>1</option>
              <option value="2" <?php echo $courtno == 2 ? "selected" : ""; ?>>2</option>
              <option value="3" <?php echo $courtno == 3 ? "selected" : ""; ?>>3</option>
              <option value="4" <?php echo $courtno == 4 ? "selected" : ""; ?>>4</option>
            </select>
          </div>
          <div class="col-md-3 form-group">
            <input name="registration_no" type="text" id="registration_no" placeholder="Registration No."  class="form-control-sm w-100" value="<?php echo $registration_no; ?>">
          </div>
          <div class="col-md-4 form-group">
            <input name="applicant" type="text" id="applicant" placeholder="Applicant's Name" class="form-control-sm w-100" value="<?php echo $applicant; ?>">
          </div>
          <div class="col-md-2 form-group">
            <button type="button" onclick="filter()" class="btn btn-sm btn-block btn-primary"><i class="fa fa-search mr-1"></i>Search</button>
          </div>
        </div>
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>SNo.</th>
              <th>Registration No.</th>
              <th>Applicant</th>
              <th>Court No.</th>
              <th>PDF Link</th>
              <!--<th>DOL</th>-->
              <!--<th>DOL-2</th>-->
              <!--<th>DOL-3</th>-->
            </tr>
          </thead>
          <tbody>
            <?php if($results != null){ 
              $sno = 0; 
              if(isset($_GET['page'])){
                $sno = ($_GET['page'] - 1)  * $record_per_page;
              }
              foreach ($results as $key) {  $sno++; ?>
            <tr>
              <td><?php echo $sno; ?></td>

              <td><?php echo $key["registration_no"]; ?></td>  
              <td><?php echo $key["applicant"]; ?></td> 
              <td><?php echo $key["courtno"]; ?></td> 
              <!--<td><?php echo $key["dol"]; ?></td> -->
              <!--<td><?php echo $key["dol2"]; ?></td> -->
              <!--<td><?php echo $key["dol3"]; ?></td> -->
              <td><a href="<?php echo "https://aftdelhi.nic.in/".$key["path"] ?>" target="_blank">PDF Link</a>
                </td>
            </tr>
            <?php }} ?>
          </tbody>
        </table>
        <?php $model->pagination(url.'views/daily-orders.php', $totalRecords, $record_per_page); ?>
      </div>
    </div>
      

</section>

<script>
  function filter(){
    var record_per_page = $('#record_per_page').val();
    var courtno = $('#courtno').val();
    var registration_no = $('#registration_no').val();
    var applicant = $('#applicant').val();
    var search = $('#search').val();
    if(search.length != 0){
      search = "&search="+search;
    }
    else{
      search = "";
    }
    window.location.href="<?php echo url.'views/daily-orders.php?'; ?>&courtno="+courtno+'&registration_no='+registration_no+'&applicant='+applicant+'&record_per_page='+record_per_page+search;
  }
</script>
<?php require_once dirname(__FILE__).'/footer.php'; ?>