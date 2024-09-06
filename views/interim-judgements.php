<?php require_once dirname(__FILE__).'/header.php';
      require_once dirname(__FILE__).'/../models/DailyOrdersModel.php';
      $model = new DailyOrdersModel();

      $court_no = '';
      if(isset($_GET['court_no'])){
        $court_no = $_GET['court_no'];
        $_SESSION['court_no'] = $court_no;
      }
      elseif(isset($_SESSION['court_no'])){
        $court_no = $_SESSION['court_no'];
      }

      $registration_no = '';
      if(isset($_GET['registration_no'])){
        $registration_no = $_GET['registration_no'];
        $_SESSION['registration_no'] = $registration_no;
      }
      elseif(isset($_SESSION['registration_no'])){
        $registration_no = $_SESSION['registration_no'];
      }

      $applicant = '';
      if(isset($_GET['applicant'])){
        $applicant = $_GET['applicant'];
        $_SESSION['applicant'] = $applicant;
      }
      elseif(isset($_SESSION['applicant'])){
        $applicant = $_SESSION['applicant'];
      }

      if(isset($_GET['from_date']) && $_GET['from_date'] != ''){
        $from_date = date('Y-m-d', strtotime($_GET['from_date']));
      }
      else{
        $from_date = '';
      }

      if(isset($_GET['to_date']) && $_GET['to_date'] != ''){
        $to_date = date('Y-m-d', strtotime($_GET['to_date']));
      }
      else{
        $to_date = '';
      }


      $filterData['court_no'] = $court_no;
      $filterData['regno'] = $registration_no;
      $filterData['applicant'] = $applicant;

      $condition = '';
      if(!empty($from_date) && !empty($to_date)){
        $condition = " STR_TO_DATE(dol, '%d-%m-%Y') >= '$from_date' and STR_TO_DATE(dol, '%d-%m-%Y') <= '$to_date'";
      }
      elseif(!empty($from_date)){
        $condition = " STR_TO_DATE(dol, '%d-%m-%Y') >= '$from_date'";
      }

      $record_per_page = 10;
      if(isset($_GET['record_per_page'])){
        $record_per_page = $_GET['record_per_page'];
      }
      $startPage = $model->page($record_per_page);

      $search = '';
      $totalRecords = 0;
      if(isset($_GET['search'])){
        $search = $_GET['search'];
        $searchData['regno'] = $search;
        $searchData['court_no'] = $search;
        $searchData['file_no'] = $search;
        $searchData['subject'] = $search;
        $searchData['petitioner'] = $search;
        $searchData['respondent'] = $search;
        $searchData['padvocate'] = $search;
        $searchData['radvocate'] = $search;
        $searchData['corum'] = $search;
        $results = $model->getOrderFilter($searchData ,"$condition limit $startPage, $record_per_page", 'search');
        if($results != null){
          $totalRecords = count($model->getOrderFilter($searchData, $condition, 'search'));
        }
      }
      else{
        $results = $model->getOrderFilter($filterData, "$condition limit $startPage, $record_per_page");
        if($results != null){
          $totalRecords = $model->getTotalWhere('aft_interim_judgements', $condition);
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
            <h5>Interim Judgements</h5>
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
          <div class="col-md-2 form-group">
            <input type="date" id="from_date" name="from_date" placeholder="From Date (dd-mm-yyyy)" class="form-control-sm w-100" value="<?php echo $from_date; ?>">
          </div>
          <div class="col-md-2 form-group">
            <input type="date" id="to_date" name="to_date" placeholder="To Date (dd-mm-yyyy)" class="form-control-sm w-100" value="<?php echo $to_date; ?>">
          </div>
          <div class="col-md-2 form-group">
            <select name="court_no" type="text" id="court_no" class="form-control-sm w-100">
              <option value="">All</option>
              <option value="1" <?php echo $court_no == 1 ? "selected" : ""; ?>>1</option>
              <option value="2" <?php echo $court_no == 2 ? "selected" : ""; ?>>2</option>
              <option value="3" <?php echo $court_no == 3 ? "selected" : ""; ?>>3</option>
              <option value="4" <?php echo $court_no == 4 ? "selected" : ""; ?>>4</option>
            </select>
          </div>
          <div class="col-md-3 form-group">
            <input name="registration_no" type="text" id="registration_no" placeholder="Registration No."  class="form-control-sm w-100" value="<?php echo $registration_no; ?>">
          </div>
          <!-- <div class="col-md-3 form-group">
            <input name="applicant" type="text" id="applicant" placeholder="Applicant's Name" class="form-control-sm w-100" value="<?php echo $applicant; ?>">
          </div> -->
          <div class="col-md-2 form-group">
            <button type="button" onclick="filter()" class="btn btn-sm btn-block btn-primary"><i class="fa fa-search mr-1"></i>Search</button>
          </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-responsive">
          <thead>
            <tr>
              <th>SNo.</th>
              <th>RegNo.</th>
              <th>Case Type</th>
              <th>File No.</th>
              <th>Year</th>
              <th>Associated</th>
              <th>Deptt</th>
              <th>Subject</th>
              <th>Petitioner</th>
              <th>Respondent</th>
              <th>Padvocate</th>
              <th>Radvocate</th>
              <th>Court No.</th>
              <th>GNO</th>
              <th>DOD</th>
              <th>MOD</th>
              <th>DOL</th>
              <th>Interim judgements PDF</th>
              <th>Judgement PDF</th>
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
              <td><?php echo $key["regno"]; ?></td>   
              <td><?php echo $key["case_type"]; ?></td> 
              <td><?php echo $key["file_no"]; ?></td> 
              
               <td><?php echo $key["year"]; ?></td> 
               <td><?php echo $key["associated"]; ?></td> 
               <td><?php echo $key["deptt"]; ?></td> 
               <td><?php echo $key["subject"]; ?></td> 
                    
               <td><?php echo $key["petitioner"]; ?></td> 
               <td><?php echo $key["respondent"]; ?></td> 
               <td><?php echo $key["padvocate"]; ?></td> 
               <td><?php echo $key["radvocate"]; ?></td>
                    
               <td><?php echo $key["court_no"]; ?></td> 
               <td><?php echo $key["gno"]; ?></td> 
               <td><?php echo $key["dod"]; ?></td> 
               <td><?php echo $key["mod"]; ?></td> 
               <td><?php echo $key["dol"]; ?></td> 
               <td><?php echo $key["pdfname"]; ?></td> 
              <td><a href="<?php echo "https://aftdelhi.nic.in/assets/pending_cases/".$key["year"].'/'.$key["case_type"].'/'.$key["pdfname"] ?>" target="_blank">PDF Link</a>
            </tr>
            <?php }} ?>
          </tbody>
        </table>
        <?php $model->pagination(url.'views/interim-judgements.php', $totalRecords, $record_per_page); ?>
      </div>
    </div>
      

</section>

<script>
  function filter(){
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var court_no = $('#court_no').val();
    var registration_no = $('#registration_no').val();
    // var applicant = $('#applicant').val();
    var record_per_page = $('#record_per_page').val();
    var search = $('#search').val();
    if(search.length != 0){
      search = "&search="+search;
    }
    else{
      search = "";
    }
    window.location.href="<?php echo url.'views/interim-judgements.php?'; ?>&court_no="+court_no+'&registration_no='+registration_no+'&from_date='+from_date+'&to_date='+to_date+'&record_per_page='+record_per_page+search;
  }
</script>
<?php require_once dirname(__FILE__).'/footer.php'; ?>