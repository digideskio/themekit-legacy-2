<?

$resource_index = $datapress['payload']['resource_index'];
$resource = $datapress['payload']['resources'][$resource_index];

function show_preview($url) {
  if (stristr($url, 'ratings.food.gov.uk') !== false) {
    // Food standards agency has X-Frame-Options: False
    return false;
  }
  return true;
}

function strip_sparql_query($url) {
  $parts = parse_url($url);
  if ($parts['path']=="/sparql.json") {
    return $parts['scheme']."://".$parts['host']."/sparql.json?query=...";
  }
  return $url;
}

function get_sparql_query($url) {
  $url = parse_url($url);
  if ($url['path']=="/sparql.json") {
    parse_str($url['query'],$query);
    if ( isset($query['query']) ) {
      return $query['query'];
    }
    return $url['query'];
  }
}
?>
  <aside class="sidebar" role="complementary">
    <? include(locate_template("snippets/sidebars/sidebar-dataset.php")); ?>
  </aside><!-- /.sidebar -->

  <main class="main sidebar-primary" role="main">
    <? include(locate_template("snippets/dataset-read-title.php")); ?>
    <h1 class="subtitle m-top">
      <a href="<?=$resource['url']?>">
        <span class="hide" property="dc:format"><?= $resource['format']; ?></span><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/filetypes/<?= $resource['format']; ?>.png" class="format-icon" />
        <?= $resource['name'] ?>
        <span class="on-hover"> &nbsp;<i class="icon-external-link"></i></span>
      </a>
    </h1>
    <table class="dp-resource-download table borderless">
      <? 
        $metadata_table = $resource;
      ?>
      <tr>
        <th style="min-width: 20%;" class="text-right"><? _e('URL:', 'sage'); ?></th>
        <td>
          <a href="<?= $resource['url'] ?>"><?= strip_sparql_query($resource['url']) ?> <i class="icon-external-link"></i></a>
          <? $sparql_query = get_sparql_query($resource['url']); ?>
          <? if ( $sparql_query ): ?>
            <div class="panel panel-default m-top">
              <div class="panel-heading"><strong><? _e('SPARQL Query:', 'sage'); ?></strong></div>
              <pre class="panel-body"><?=$sparql_query?></pre>
            </div>
          <? endif; ?>
        </td>
      </tr>
      <? foreach ($metadata_table as $key=>$val): ?>
        <tr>
          <th style="padding-left:20px; padding-right: 10px;" class="text-right"><?= str_replace(" ","&nbsp;",$key) ?>:</th>
          <td><?= $val ?></td>
        </tr>
      <? endforeach; ?>
    </table>



    <? if ( ! empty($resource['description']) ): ?>
      <div class="dp-dataset-description dp-resource-description">
        <? $resource['description'] ?>
      </div>
    <? endif; ?>

<?
function get_format($resource) {
  $format = $resource['format'];
  if ( empty($format) ) {
    // Bad import? Old Database from before detection was improved?
    $format = pathinfo($resource['url'])['extension'];
  }
  return strtoupper($format);
}

function get_iframe_settings($resource) {
  switch( get_format($resource) ) {
  case "CSV":
    return [
      "url" => "/recline?type=csv&url=".$resource['url']."&id=".$resource['id'],
    ];
  case "XLS":
    if ($resource['size'] > 2*1024*1024 || $_GET['excel-mode']=="static") {
      return [
        "mode" => "google",
        "url" => "https://docs.google.com/gview?url=".$resource['url']."&embedded=true",
      ];
    }
    return [
      "mode" => "microsoft",
      "url" => "https://view.officeapps.live.com/op/view.aspx?src=".urlencode($resource['url']),
    ];
  case "DOC":
    if (strpos("vnd.oasis.opendocument.text",$resource['mimetype'])!==-1) {
      // Open Document format ironically requires MS viewer
      return [
        "mode" => "microsoft",
        "url" => "https://view.officeapps.live.com/op/view.aspx?src=".urlencode($resource['url']),
      ];
    }
    return [
      "mode" => "google",
      "url" => "https://docs.google.com/gview?url=".$resource['url']."&embedded=true",
    ];
  case "PPT":
  case "PDF":
  case "TXT":
  case "XML":
    return [
      "mode" => "google",
      "url" => "https://docs.google.com/gview?url=".$resource['url']."&embedded=true",
    ];
  case "IMG":
    return [
      "mode" => "img",
      "url" => "/preview_image?url=".$resource['url'],
    ];
  case "HTML":
  case "":
    return [
      "url" => $resource['url'],
    ];
  default:
    return null;
  }
}
?>

<? if ($resource['size'] > 10*1024*1024): ?>
  <div class="panel panel-info">
    <div class="panel-heading">
      <i class="icon-warning-sign"></i>&nbsp; <? _e('No Preview Available', 'sage'); ?>
    </div>
    <div class="panel-body">
      <? _e('This file is over 10MB and is too large to preview in the browser.', 'sage'); ?>
    </div>
  </div>

<? else: ?>
  <?
  $iframe_settings = get_iframe_settings($resource);
  if ($iframe_settings != null):
  ?>

    <? if (get_format($resource)=="XLS"): ?>
      <form id="excel-mode">
        <div class="pull-right form-inline form-group">
          <label for="excel-mode"><? _e('Preview Mode:', 'sage'); ?>&nbsp; </label>
          <select id="excel-mode" name="excel-mode" class="form-control" data-widget="SubmitOnChange">
            <? $disable_excel = $resource['size']>2*1024*1024; ?>
            <option value="excel" 
              <?= $disable_excel?'disabled="disabled"':''?>
              <?= $iframe_settings['mode']=="microsoft"?'selected="selected"':''?>
              ><?= $disable_excel?"[disabled]":""?> <? _e('Excel Online (up to 2MB)', 'sage'); ?></option>
            <option value="static" 
              <?= $iframe_settings['mode']=="google"?'selected="selected"':''?>
              ><? _e('Static Preview (up to 10MB)', 'sage'); ?></option>
          </select>
        </div>
      </form>
      <div class="clearfix"></div>
    <? endif; ?>

    <? if (show_preview($iframe_settings['url'])): ?>
      <div class="dp-datapreview" data-widget="MaximiseIframe" data-mode="<?=$iframe_settings['mode']?>">
        <iframe src="<?=$iframe_settings['url']?>" frameborder="0" width="100%" height="400">
          &lt;p&gt;<? _e('Your browser does not support iframes.', 'sage'); ?>&lt;/p&gt;
        </iframe>
      </div>
    <? else: ?>
      <div class="alert alert-info">
        <? _e('Preview is not supported for this resource.', 'sage'); ?>
      </div>
    <? endif; ?>
  <? endif; ?>
<? endif; ?>

  </main>
