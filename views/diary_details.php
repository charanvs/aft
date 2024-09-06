<?php 
require_once dirname(__FILE__).'/header.php';
require_once dirname(__FILE__).'/../models/DiaryModel.php';

$model = new DiaryModel();

$id = $_GET['id'];
$result = $model->getById('aft_scrutiny', 'id', $id);

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
                    <h4>Diary Entry Details</h4>
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
                    <td class="td-label">Diary No.</td>
                    <td><?php echo $result['diary_no']; ?></td>
                </tr>

                <tr>
                    <td class="td-label">Date</td>
                    <td><?php echo $result['date']; ?></td>
                </tr>

                <tr>
                    <td class="td-label">Presented By</td>
                    <td><?php echo $result['presented_by']; ?></td>
                </tr>

                <tr>
                    <td class="td-label">Nature of Document</td>
                    <td><?php echo $result['nature_of_doc']; ?></td>
                </tr>

                <tr>
                    <td class="td-label">Reviewed By</td>
                    <td><?php echo $result['reviewed_by']; ?></td>
                </tr>

                <tr>
                    <td class="td-label">Subject</td>
                    <td><?php echo $result['subject']; ?></td>
                </tr>

                <tr>
                    <td class="td-label">Result</td>
                    <td><?php echo $result['result']; ?></td>
                </tr>

                <tr>
                    <td class="td-label">Section Officer Remark</td>
                    <td><?php echo nl2br($result['section_officer_remark']); ?></td>
                </tr>

                <tr>
                    <td class="td-label">Deputy Registrar Remark</td>
                    <td><?php echo nl2br($result['deputy_registrar_remark']); ?></td>
                </tr>

                <tr>
                    <td class="td-label">Registrar Remark</td>
                    <td><?php echo nl2br($result['registrar_remark']); ?></td>
                </tr>

                <tr>
                    <td class="td-label">Notification Date</td>
                    <td><?php echo $result['notification_date']; ?></td>
                </tr>

                <tr>
                    <td class="td-label">Remarks</td>
                    <td><?php echo nl2br($result['remark']); ?></td>
                </tr>

                <tr>
                    <td class="td-label">CA Remark</td>
                    <td><?php echo nl2br($result['ca_remark']); ?></td>
                </tr>

                <tr>
                    <td class="td-label">Notification Remark</td>
                    <td><?php echo nl2br($result['notification_remark']); ?></td>
                </tr>
            </table>
        </div>
    </div>
</section>

<?php require_once dirname(__FILE__).'/footer.php'; ?>
