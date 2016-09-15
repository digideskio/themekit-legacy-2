<?
function print_debug() {
  assert (DEBUG);
  if (DEBUG) { // <<-- Enormous compiler hint
    global $debug;
    $debug['datapress_ckan::print_debug::is_404()'] = is_404();
    global $datapress;
    $d = $datapress;
    $me = $d['me'];
    $pl = $d['payload'];
    unset($d['me']);
    unset($d['payload']);
    ?>
    <div class="container" style="background: none; padding: 0 0 0 0;">

      <div class="panel-group m-top">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a style="display:block;" data-toggle="collapse" href="#collapse4">Global $debug variable</a>
            </h4>
          </div>
          <pre id="collapse4" class="panel-collapse">
            <? print_r($debug) ?>
          </pre>
        </div>
      </div>

      <div class="panel-group m-top">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a style="display:block;" data-toggle="collapse" href="#collapse3">$datapress</a>
            </h4>
          </div>
          <div id="collapse3" class="panel-collapse">
            <pre class="panel-body">
              <? print_r($d) ?>
            </pre>
          </div>
        </div>
      </div>

      <div class="panel-group m-top">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a style="display:block;" data-toggle="collapse" href="#collapse1">$datapress['me']</a>
            </h4>
          </div>
          <div id="collapse1" class="panel-collapse collapse">
            <pre class="panel-body">
              <? print_r($me) ?>
            </pre>
          </div>
        </div>
      </div>

      <div class="panel-group m-top">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h4 class="panel-title">
              <a style="display:block;" data-toggle="collapse" href="#collapse2">$datapress['payload']</a>
            </h4>
          </div>
          <div id="collapse2" class="panel-collapse collapse">
            <pre class="panel-body">
              <? print_r($pl) ?>
            </pre>
          </div>
        </div>
      </div>

    <?
  }
}

if (DEBUG) {
  add_action( 'wp_footer', 'print_debug', 0, 10);
}
