<!-- Modal -->
<div class="modal fade" id="apiKeyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 style="display:inline;" class="modal-title" id="myModalLabel">API Key</h4> &nbsp;<span class="label label-danger dp-admin"><i class="icon-exclamation-sign"></i>&nbsp; <? _e('Secret', 'sage'); ?></span>
      </div>
      <div class="modal-body">
        <div class="well text-center">
          <strong><? _e('Your API Key:', 'sage'); ?></strong> <code class="user-api-key-value"><? echo $user['apikey']; ?></code>
        </div>
        <p><? _e('Your API key is like a password, so <strong>keep it safe</strong>. It is used to authenticate programs, scripts and scrapers, allowing access to the data catalogue via your personal profile.', 'sage'); ?></p>
        <p><? _e('For more information about the API, <a href="http://docs.ckan.org/en/ckan-2.2/api.html">see the CKAN documentation</a>.', 'sage'); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><? _e('Close', 'sage'); ?></button>
      </div>
    </div>
  </div>
</div>
