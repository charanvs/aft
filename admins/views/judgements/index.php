<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-md-6">
        <h5>Judgements List</h5>
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
            <?php for($y = date('Y'); $y >= 2000; $y--) { ?>
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
    <table class="table table-bordered table-striped table-hover table-responsive">
      <thead>
        <tr>
          <th>SNo.</th>
          <th>Id</th>
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
          <th>Location</th>
          <th>PDF Link</th>
          <th>Action</th>
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

          <td><?php echo $key["id"]; ?></td> 
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
           <td><?php echo $key["location"]; ?></td> 
           <td><a href="<?php echo "https://aftdelhi.nic.in/assets/judgement/".$key["year"].'/'.$key["case_type"].'/'.$key["dpdf"] ?>" target="_blank">PDF Link</a>
            </td>
            <td><a href="<?php echo url.'admins/controllers/JudgementController.php?action=view&id='.$key['id']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye mr-1"></i>View</a></td>
        </tr>
        <?php }} ?>
      </tbody>
    </table>
    <?php $this->model->pagination(url.'admins/controllers/JudgementController.php', $totalRecords, $record_per_page); ?>
  </div>
</div>

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
    window.location.href="<?php echo url.'admins/controllers/JudgementController.php?action=index&'; ?>&year="+year+'&file_no='+file_no+'&case_type='+case_type+'&regno='+regno+'&subject='+subject+'&record_per_page='+record_per_page+search;
  }
</script>