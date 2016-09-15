<? 
global $datapress; 
?>
<? if (defined("MODE_DATASET_READ") && MODE_DATASET_READ===true): ?>
  <div class="pull-right follow-button-container">
    <? render_follow_button("dataset",$datapress['payload']['name']); ?>
  </div>
<? endif; ?>
<h1><?= $datapress['payload']['title']; ?></h1>
<? if (defined("MODE_DATASET_READ") && MODE_DATASET_READ===true): ?>
  <div class="dp-dataset-created-modified">
  <small><i class="icon-time"></i> &nbsp;<? echo created_and_modified( $datapress['payload']['metadata_created'], $datapress['payload']['metadata_modified'] ); ?></small>
  </div>
<? endif; ?>
<? if ($datapress['payload']['private']): ?>
<div class="alert alert-danger dataset-header-private">
<table><tr>
<td><i class="icon-group"></i></td>
<td>This dataset is visible only to <strong>members&nbsp;of&nbsp;the&nbsp;publisher</strong>.</td>
</tr></table>
</div>
<? endif; ?>
<? if ($datapress['payload']['state']=="deleted"): ?>
  <div class="alert alert-danger"><i class="icon-trash"></i>&nbsp; This dataset is marked as <strong>deleted</strong> and will not appear in the public catalogue.</div>
<? endif; ?>
