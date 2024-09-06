<?php require_once dirname(__FILE__).'/header.php';
      require_once dirname(__FILE__).'/../models/JudgementModel.php';
      $model = new JudgementModel();
      
      $id = $_GET['id'];
      $result = $model->getById('aft_judgement', 'id', $id);
	  
	  $disposed_off = $model->getById('aft_disposedof', 'regno', $result['regno']);
	  
	  $interiem_judgement = $model->getById('aft_interim_judgements', 'regid', $disposed_off['regid']);
	

      $regid = $interiem_judgement['regid'];

	      $interim_judgements = $model->getQuery("SELECT * from aft_interim_judgements where regid='$regid' order by str_to_date(dol, '%d, %m, %Y')");

      $corunIds = $result['corum'];
      $aft_corums = null;
      if(!empty($corunIds)){
        $sql = 'select * from aft_corum where id in ('.$corunIds.')';
        $aft_corums = $model->getQuery('select * from aft_corum where id in ('.$corunIds.')');
      }
?>

<style type="text/css">
  .td-label {
    width: 200px;
    font-weight: bold;
    text-transform: capitalize;
  }
</style>


<section class="container my-3">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h4>Judgement Details</h4>
          </div>
          <div class="col-md-6">
            <div class="float-sm-right d-flex justify-content-right">
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table width="100%" class="table table-bordered table-striped table-hover">
          <tr>
            <td width="276" class="td-label">regno</td>
            <td width="861"><?php echo $result['regno']; ?></td>
          </tr>

          <tr>
            <td class="td-label">case type</td>
            <td><?php echo $result['case_type']; ?></td>
          </tr>

          <tr>
            <td class="td-label">file no.</td>
            <td><?php echo $result['file_no']; ?></td>
          </tr>

          <tr>
            <td class="td-label">year</td>
            <td><?php echo $result['year']; ?></td>
          </tr>

          <tr>
            <td class="td-label">associated</td>
            <td><?php echo $result['associated']; ?></td>
          </tr>

          <tr>
            <td class="td-label">date of Registration</td>
            <td><?php echo $result['dor']; ?></td>
          </tr>
          <tr>
            <td class="td-label">deptt</td>
            <td><?php echo $result['deptt']; ?></td>
          </tr>

          <tr>
            <td class="td-label">deptt_code</td>
            <td><?php echo $result['deptt_code']; ?></td>
          </tr>

          <tr>
            <td class="td-label">subject</td>
            <td><?php echo $result['subject']; ?></td>
          </tr><tr>
            <td class="td-label">subject_code</td>
            <td><?php echo $result['subject_code']; ?></td>
          </tr>

          <tr>
            <td class="td-label">petitioner</td>
            <td><?php echo $result['petitioner']; ?></td>
          </tr>
          
          <tr>
            <td class="td-label">petitioner advocate</td>
            <td><?php echo $result['padvocate']; ?></td>
          </tr>
             <tr>
            <td class="td-label">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
             <tr>
               <td class="td-label">respondent</td>
               <td style="white-space: normal;"><?php echo $result['respondent']; ?></td>
             </tr>

          <tr>
            <td class="td-label">respondent advocate</td>
            <td><?php echo $result['radvocate']; ?></td>
          </tr>

          <tr>
            <td class="td-label">corum</td>
            <td><?php echo $result['corum']; ?></td>
          </tr>

          <tr>
            <td class="td-label">court_no</td>
            <td><?php echo $result['court_no']; ?></td>
          </tr>

          <tr>
            <td class="td-label">gno</td>
            <td><?php echo $result['gno']; ?></td>
          </tr>

          <tr>
            <td class="td-label">appeal</td>
            <td><?php echo $result['appeal']; ?></td>
          </tr>

          <tr>
            <td class="td-label">jro</td>
            <td><?php echo $result['jro']; ?></td>
          </tr>

          <tr>
            <td class="td-label">d of disposal</td>
            <td><?php echo $result['dod']; ?></td>
          </tr>

          <tr>
            <td class="td-label">mod</td>
            <td><?php echo $result['mod']; ?></td>
          </tr>

          <tr>
            <td class="td-label">Judgement Pdf filename</td>
                    <td>
					
					 <?php 
						$dod = $result['dod'];
						$dodArray = explode("-",$dod);
						$dateObj   = DateTime::createFromFormat('!m', $dodArray[1]);
						$monthName = $dateObj->format('F');
						$year = $dodArray[2];
						
						$url = "https://aftdelhi.nic.in/assets/judgement/$year/".$result["case_type"].'/'.$result["dpdf"];
						echo '<a href="'.$url.'" target="_blank">'.'Click to Open'.'</a>';
					?>
					
					
					
				</td>
          </tr>

          <tr>
            <td class="td-label">remarks</td>
            <td><?php echo $result['remarks']; ?></td>
          </tr>

          <tr>
            <td class="td-label">headnotes</td>
            <td><?php echo $result['headnotes']; ?></td>
          </tr>

          <tr>
            <td class="td-label">citation</td>
            <td><?php echo $result['citation']; ?></td>
          </tr>

          <tr>
            <td class="td-label">location</td>
            <td><?php echo $result['location']; ?></td>
          </tr>
        </table>

        <?php if($aft_corums != null){ ?>
        <h5>Courm Name :</h5><hr>
        <table width="100%" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>SNo.</th>
              <th>name</th>
              <th>designation</th>
              <th>published</th>
              <th>ordering</th>
            </tr>
          </thead>
          <tbody>
            <?php $sno = 0; foreach ($aft_corums as $key) { $sno++; ?>
              <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo $key['name']; ?></td>
                <td><?php echo $key['designation']; ?></td>
                <td><?php echo $key['published']; ?></td>
                <td><?php echo $key['ordering']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>

        <?php if($interim_judgements != null){ ?>
                <h5>Interim Orders :</h5><hr>
        <table width="100%" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>SNo.</th>
              <th>DOL</th>
  
              <th class="w-100">PDF File Name</th>
                         <th class="w-100">Pdf Link</th>
            </tr>
          </thead>
          <tbody>
            <?php $sno = 0; foreach ($interim_judgements as $key) { $sno++; ?>
              <tr>
                <td><?php echo $sno; ?></td>
                <td><?php echo $key['dol']; ?></td>


                <td><?php echo $key['pdfname']; ?></td>
           		<td>      <?php 
                    $dol = $result['dod'];
                    $dolArray = explode("-",$dol);
                    $dateObj   = DateTime::createFromFormat('!m', $dolArray[1]);
                    $monthName = $dateObj->format('F');
                    $year = $dolArray[2];
                    
                    $url = "https://aftdelhi.nic.in/assets/disposed_cases/$year/$monthName/".$result['case_type'].'/'.$key["pdfname"];
                    echo '<a href="'.$url.'" target="_blank">'.'Click to Open'.'</a>';
                ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
      </div>
    </div>
      

</section>
<?php require_once dirname(__FILE__).'/footer.php'; ?>