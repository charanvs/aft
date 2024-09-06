<?php 
require_once dirname(__FILE__).'/header.php';
require_once dirname(__FILE__).'/../models/DiaryModel.php';

$model = new DiaryModel();

// Define the base URL for the current page
$url = 'diary.php'; // Adjust this based on your actual file structure


$diary_no = '';
$diary_no = $_GET['diary_no'] ?? $_SESSION['diary_no'] ?? '';

$presented_by = '';
$presented_by = $_GET['presented_by'] ?? $_SESSION['presented_by'] ?? '';

$nature_of_doc = '';
$nature_of_doc = $_GET['nature_of_doc'] ?? $_SESSION['nature_of_doc'] ?? '';

$date_of_presentation = '';

// Convert the date to string format for query (d-m-Y)
$date_of_presentation = isset($_GET['date_of_presentation']) && $_GET['date_of_presentation'] != '' 
    ? date('d-m-Y', strtotime($_GET['date_of_presentation'])) 
    : (isset($_SESSION['date_of_presentation']) && $_SESSION['date_of_presentation'] != ''
        ? date('Y-m-d', strtotime($_SESSION['date_of_presentation']))
        : '');
// Store session variables
$_SESSION['diary_no'] = $diary_no;
$_SESSION['presented_by'] = $presented_by;
$_SESSION['nature_of_doc'] = $nature_of_doc;
$_SESSION['date_of_presentation'] = $date_of_presentation;

$filterData = [
    'diary_no' => $diary_no,
    'presented_by' => $presented_by,
    'nature_of_doc' => $nature_of_doc,
    'date_of_presentation' => $date_of_presentation,
];
$record_per_page = 10;
if(isset($_GET['record_per_page'])){
  $record_per_page = $_GET['record_per_page'];
}
$startPage = $model->page($record_per_page);


$record_per_page = $_GET['record_per_page'] ?? 10;
$startPage = $model->page($record_per_page);

$search = '';
$totalRecords = 0;

if(isset($_GET['search'])){
    $search = $_GET['search'];
    $searchData['date_of_presentation'] = $search;
    $searchData['nature_of_doc'] = $search;
    $searchData['diary_no'] = $search;
    $searchData['presented_by'] = $search;
    $results = $model->search('aft_scrutiny',$searchData ," limit $startPage, $record_per_page");
    if($results != null){
      $totalRecords = count($model->search('aft_scrutiny',$searchData));
    }
  }
  else{
    $results = $model->getFilter('aft_scrutiny',$filterData, " limit $startPage, $record_per_page");
    if($results != null){
      $totalRecords = count($model->getFilter('aft_scrutiny',$filterData));
    }
  }

// Calculate total pages
$totalPages = ceil($totalRecords / $record_per_page);
$current_page = $_GET['page'] ?? 1;
?>

<section class="container mt-3">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5>Diary Entries</h5>
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
                            <input type="text" id="search" class="form-control border-secondary" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2" value="<?php echo htmlspecialchars($search); ?>" style="height: 32px;">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btn-sm" type="button" onclick="filter()"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" id="table-content">
            <div class="row">
                <div class="col-md-2 form-group">
                    <input type="date" id="date_of_presentation" name="date_of_presentation" placeholder="Date of Presentation (dd-mm-yyyy)" class="form-control-sm w-100" value="<?php echo htmlspecialchars($date_of_presentation); ?>">
                </div>
                <div class="col-md-2 form-group">
                    <input name="diary_no" type="text" id="diary_no" placeholder="Diary No." class="form-control-sm w-100" value="<?php echo htmlspecialchars($diary_no); ?>">
                </div>
                <div class="col-md-2 form-group">
                    <input name="presented_by" type="text" id="presented_by" placeholder="Presented By" class="form-control-sm w-100" value="<?php echo htmlspecialchars($presented_by); ?>">
                </div>
                <div class="col-md-2 form-group">
                    <input name="nature_of_doc" type="text" id="nature_of_doc" placeholder="Nature of Document" class="form-control-sm w-100" value="<?php echo htmlspecialchars($nature_of_doc); ?>">
                </div>
                <div class="col-md-2 form-group">
                    <button type="button" onclick="filter()" class="btn btn-sm btn-block btn-primary"><i class="fa fa-search mr-1"></i>Search</button>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>SNo.</th>
                        <th>Diary No.</th>
                        <th>Nature of Document</th>
                        <th>Reviewed By</th>
                        <th>Associated With</th>
                        <th>Date Of Presentation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($results != null){ 
                      $sno = 0; 
                      if(isset($_GET['page'])){
                        $sno = ($_GET['page'] - 1) * $record_per_page;
                      }
                      foreach ($results as $key) {  
                          $sno++; ?>
                    <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo htmlspecialchars($key["diary_no"]); ?></td>   
                        <td><?php echo htmlspecialchars($key["nature_of_doc"]); ?></td> 
                        <td><?php echo htmlspecialchars($key["reviewed_by"]); ?></td> 
                        <td><?php echo htmlspecialchars($key["associated_with"]); ?></td> 
                        <td><?php echo htmlspecialchars($key["date_of_presentation"]); ?></td> 
                        <td><a href="<?php echo url.'views/diary_details.php?id='.htmlspecialchars($key['id']); ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye mr-1"></i>View</a></td>
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
    var date_of_presentation = $('#date_of_presentation').val();
    var diary_no = $('#diary_no').val();
    var presented_by = $('#presented_by').val();
    var nature_of_doc = $('#nature_of_doc').val();
    var record_per_page = $('#record_per_page').val();
    var search = $('#search').val();
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>'; // Ensure the page parameter is preserved

    var queryString = '?diary_no=' + encodeURIComponent(diary_no) + 
                      '&presented_by=' + encodeURIComponent(presented_by) + 
                      '&nature_of_doc=' + encodeURIComponent(nature_of_doc) + 
                      '&date_of_presentation=' + encodeURIComponent(date_of_presentation) + 
                      '&record_per_page=' + encodeURIComponent(record_per_page) + 
                      '&page=' + encodeURIComponent(page);

    if(search.length != 0){
        queryString += '&search=' + encodeURIComponent(search);
    }
    
    window.location.href = "<?php echo url.'views/diary.php'; ?>" + queryString;
}
</script>
<script>
$(document).ready(function() {
   
    // Use event delegation for pagination links
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault(); // Prevent the default link behavior
  
        var page = $(this).attr('data-page'); // Get the page number from the clicked link
        var url = "<?php echo $url; ?>"; // Base URL of your page
        var queryString = '<?php echo http_build_query($_GET); ?>'; // Current query string parameters

        // Update the page parameter in the query string
        var newQueryString = queryString.replace(/page=\d+/, 'page=' + page);
        
        if (!/page=\d+/.test(newQueryString)) {
            newQueryString += '&page=' + page;
        }

        // Make an AJAX request to fetch the data for the selected page
        $.ajax({
            url: url + '?' + newQueryString,
            type: 'GET',
            success: function(response) {
                // Replace the content of the table with the new data
                $('#table-content').html($(response).find('#table-content').html());
                
                // Update the pagination links
                $('#pagination-content').html($(response).find('#pagination-content').html());
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    });
});
</script>
<?php require_once dirname(__FILE__).'/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.2/js/bootstrap.min.js"></script>
</body>
</html>


