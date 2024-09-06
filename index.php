<?php
      require_once dirname(__FILE__).'/views/header.php';
      require_once dirname(__FILE__).'/models/JudgementModel.php';
      $model = new JudgementModel();

      $year = '';
      if(isset($_GET['year'])){
        $year = $_GET['year'];
        $_SESSION['year'] = $year;
      }
      elseif(isset($_SESSION['year'])){
        $year = $_SESSION['year'];
      }

      $case_type = '';
      if(isset($_GET['case_type'])){
        $case_type = $_GET['case_type'];
        $_SESSION['case_type'] = $case_type;
      }
      elseif(isset($_SESSION['case_type'])){
        $case_type = $_SESSION['case_type'];
      }

      $file_no = '';
      if(isset($_GET['file_no'])){
        $file_no = $_GET['file_no'];
        $_SESSION['file_no'] = $file_no;
      }
      elseif(isset($_SESSION['file_no'])){
        $file_no = $_SESSION['file_no'];
      }

      $regno = '';
      if(isset($_GET['regno'])){
        $regno = $_GET['regno'];
        $_SESSION['regno'] = $regno;
      }
      elseif(isset($_SESSION['regno'])){
        $regno = $_SESSION['regno'];
      }

      $subject = '';
      if(isset($_GET['subject'])){
        $subject = $_GET['subject'];
        $_SESSION['subject'] = $subject;
      }
      elseif(isset($_SESSION['subject'])){
        $subject = $_SESSION['subject'];
      }

      $filterData['year'] = $year;
      $filterData['case_type'] = $case_type;
      $filterData['file_no'] = $file_no;
      $filterData['regno'] = $regno;
      $filterData['subject'] = $subject;

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
        $searchData['file_no'] = $search;
        $searchData['subject'] = $search;
        $searchData['petitioner'] = $search;
        $searchData['respondent'] = $search;
        $searchData['padvocate'] = $search;
        $searchData['radvocate'] = $search;
        $searchData['corum'] = $search;
        $results = $model->search('aft_judgement',$searchData ," limit $startPage, $record_per_page");
        if($results != null){
          $totalRecords = count($model->search('aft_judgement',$searchData));
        }
      }
      else{
        $results = $model->getFilter('aft_judgement',$filterData, " limit $startPage, $record_per_page");
        if($results != null){
          $totalRecords = count($model->getFilter('aft_judgement',$filterData));
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
            <h4>Judgements List</h4>
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
            <select id="year" name="year" class="form-control-sm w-100">
                <option value="">Year</option>
                <?php for($y = date('Y'); $y >= 2009; $y--) { ?>
                  <option value="<?php echo $y; ?>" <?php echo $y == $year ? 'selected' : ''; ?>><?php echo $y; ?></option>
                <?php } ?>
              </select>
          </div>
          <div class="col-md-2 form-group">
            <select id="case_type" name="case_type" class="form-control-sm w-100">
                <option value="">Case Type</option>
                <option value="OA" <?php echo $case_type == 'OA' ? 'selected' : ''; ?>>OA</option>
                <option value="TA" <?php echo $case_type == 'TA' ? 'selected' : ''; ?>>TA</option>
                <option value="AT" <?php echo $case_type == 'AT' ? 'selected' : ''; ?>>AT</option>
                <option value="CA" <?php echo $case_type == 'CA' ? 'selected' : ''; ?>>CA</option>
                <option value="RA" <?php echo $case_type == 'RA' ? 'selected' : ''; ?>>RA</option>
                <option value="MA" <?php echo $case_type == 'MA' ? 'selected' : ''; ?>>MA</option>
                <option value="WP(C)" <?php echo $case_type == 'WP(C)' ? 'selected' : ''; ?>>WP(C)</option>
                <option value="MA (Ex)" <?php echo $case_type == 'MA (Ex)' ? 'selected' : ''; ?>>MA (Ex)</option>
              </select>
          </div>
          <div class="col-md-2 form-group">
            <input name="file_no" type="text" id="file_no" size="6" maxlength="6" placeholder="File No." class="form-control-sm w-100" value="<?php echo $file_no; ?>">
          </div>
          <div class="col-md-2 form-group">
            <input name="regno" type="text" id="regno" placeholder="Registration No."  class="form-control-sm w-100" value="<?php echo $regno; ?>">
          </div>
          <div class="col-md-2 form-group">
            <input name="subject" type="text" id="subject" placeholder="Subject" class="form-control-sm w-100" value="<?php echo $subject; ?>">
          </div>
          <div class="col-md-2 form-group">
            <button type="button" onclick="filter()" class="btn btn-sm btn-block btn-primary"><i class="fa fa-search mr-1"></i>Search</button>
          </div>
        </div>
        <table width="100%" class="table table-bordered table-striped table-hover table-responsive">
          <thead>
            <tr>
              <th align="center">Sl.</th>
              <th>Details</th>
              <th>RegNo.</th>
              <th>Judgement Pdf </th>
              <th align="center">Case Type</th>
              <th align="center">File</th>
              <th align="center">Year</th>
              <th>Subject</th>
              <th>Petitioner</th>
              <th>Respondent</th>
              <th>Associated</th>
              <th>Deptt</th>
              <th>Padvocate</th>
             
           		<?php /*?>  
		   		<th>Radvocate</th>
              	<th>Corum</th>
			  	<th>Id</th>
			  	<?php */?>
             
              <th>Court No.</th>
              <th>GNO</th>
              <th>DOD</th>
              <th>MOD</th>
              
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
              <td align="center"><?php echo $sno; ?></td>

              <td><a href="<?php echo url.'views/judgement-details.php?id='.$key['id']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye mr-1"></i>View</a></td>
              <td><?php echo $key["regno"]; ?></td>
              <td align="center"><a href="<?php echo "https://aftdelhi.nic.in/assets/judgement/".$key["year"].'/'.$key["case_type"].'/'.$key["dpdf"] ?>" target="_blank">
                <?php 
                    $dod = $key['dod'];
                    $dodArray = explode("-",$dod);
                    $dateObj   = DateTime::createFromFormat('!m', $dodArray[1]);
                    $monthName = $dateObj->format('F');
                    $year = $dodArray[2];
                    
                    $url = "https://aftdelhi.nic.in/assets/judgement/$year/".$key["case_type"].'/'.$key["dpdf"];
                    echo '<a class="fa fa-eye mr-1" href="'.$url.'" target="_blank">'.'Click to Open'.'</a>';
                ?>
              </a></td>
              <td align="center"><?php echo $key["case_type"]; ?></td> 
              <td align="center"><?php echo $key["file_no"]; ?></td> 
              
               <td align="center"><?php echo $key["year"]; ?></td> 
               <td><?php echo $key["subject"]; ?></td> 
                    
               <td><?php echo $key["petitioner"]; ?></td> 
               <td><?php echo $key["respondent"]; ?></td>
               <td><?php echo $key["associated"]; ?></td>
               <td><?php echo $key["deptt"]; ?></td>
               <td><?php echo $key["padvocate"]; ?></td> 
               
            	<?php /*?>   
				<td><?php echo $key["radvocate"]; ?></td>
             	<td><?php echo $key["corum"]; ?></td> 
			 	<td><?php echo $key["id"]; ?></td>
				<?php */?>
 
               <td><?php echo $key["court_no"]; ?></td> 
               <td><?php echo $key["gno"]; ?></td> 
               <td><?php echo $key["dod"]; ?></td> 
               <td><?php echo $key["mod"]; ?></td>
           
            </tr>
            <?php }} ?>
          </tbody>
        </table>
        <?php $model->pagination(url, $totalRecords, $record_per_page); ?>
      </div>
    </div>
      

</section>

<script>
  function filter(){
    var record_per_page = $('#record_per_page').val();
    var year = $('#year').val();
    var case_type = $('#case_type').val();
    var file_no = $('#file_no').val();
    var regno = $('#regno').val();
    var subject = $('#subject').val();
    var search = $('#search').val();
    if(search.length != 0){
      search = "&search="+search;
    }
    else{
      search = "";
    }
    window.location.href="<?php echo url.'?'; ?>&year="+year+'&file_no='+file_no+'&case_type='+case_type+'&regno='+regno+'&subject='+subject+'&record_per_page='+record_per_page+search;
  }
</script>
<?php require_once dirname(__FILE__).'/views/footer.php'; ?>