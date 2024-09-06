<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-md-6">
        <h5>Diaries List</h5>
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
        <input name="diary_no" type="text" id="diary_no" placeholder="Diary No." class="form-control-sm w-100" value="<?php echo $diary_no; ?>">
      </div>
      <div class="col-md-2 form-group">
        <input name="presented_by" type="text" id="presented_by" placeholder="Presented By" class="form-control-sm w-100" value="<?php echo $presented_by; ?>">
      </div>
      <div class="col-md-2 form-group">
        <input name="nature_of_doc" type="text" id="nature_of_doc" placeholder="Nature of Document" class="form-control-sm w-100" value="<?php echo $nature_of_doc; ?>">
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
          <th>Diary No.</th>
          <th>Date</th>
          <th>Presented By</th>
          <th>Nature of Document</th>
          <th>Reviewed By</th>
          <th>Subject</th>
          <th>Result</th>
          <th>Section Officer Remark</th>
          <th>Deputy Registrar Remark</th>
          <th>Registrar Remark</th>
          <th>Notification Date</th>
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
          <td><?php echo $key["diary_no"]; ?></td>   
          <td><?php echo $key["date"]; ?></td> 
          <td><?php echo $key["presented_by"]; ?></td> 
          <td><?php echo $key["nature_of_doc"]; ?></td> 
          <td><?php echo $key["reviewed_by"]; ?></td> 
          <td><?php echo $key["subject"]; ?></td> 
          <td><?php echo $key["result"]; ?></td> 
          <td><?php echo $key["section_officer_remark"]; ?></td> 
          <td><?php echo $key["deputy_registrar_remark"]; ?></td> 
          <td><?php echo $key["registrar_remark"]; ?></td> 
          <td><?php echo $key["notification_date"]; ?></td> 
          <td><a href="<?php echo url.'admins/controllers/DiaryController.php?action=view&id='.$key['id']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye mr-1"></i>View</a></td>
        </tr>
        <?php }} ?>
      </tbody>
    </table>
    <?php $this->model->pagination(url.'admins/controllers/DiaryController.php', $totalRecords, $record_per_page); ?>
  </div>
</div>

<script>
  function filter(){
    var record_per_page = $('#record_per_page').val();
    var diary_no = $('#diary_no').val();
    var presented_by = $('#presented_by').val();
    var nature_of_doc = $('#nature_of_doc').val();
    var subject = $('#subject').val();
    var search = $('#search').val();
    if(search.length != 0){
      search = "&search="+search;
    }
    else{
      search = "";
    }
    window.location.href="<?php echo url.'admins/controllers/DiaryController.php?action=index&'; ?>&diary_no="+diary_no+'&presented_by='+presented_by+'&nature_of_doc='+nature_of_doc+'&subject='+subject+'&record_per_page='+record_per_page+search;
  }
</script>
