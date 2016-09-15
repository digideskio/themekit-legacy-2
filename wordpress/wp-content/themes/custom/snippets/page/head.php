<?
global $datapress;
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="alternate" type="application/rss+xml" title="<?= get_bloginfo('name'); ?> News Feed" href="<?= esc_url(get_feed_link()); ?>" />

  <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/style.css" />

  <? get_template_part("snippets/favicon"); ?>

  <? wp_head(); ?>

  <!-- DP_PRODUCTION=<?php echo (DP_PRODUCTION===true) ? 'true':'false'; ?>; -->

  <? /* ==== Pingdom Integration ==== */ ?>
  <?php if (DP_PRODUCTION===true): ?>
    <script>
    var _prum = [['id', '548b23a5abe53d9608b209f4'],
                 ['mark', 'firstbyte', (new Date()).getTime()]];
    (function() {
        var s = document.getElementsByTagName('script')[0]
          , p = document.createElement('script');
        p.async = 'async';
        p.src = '//rum-static.pingdom.net/prum.min.js';
        s.parentNode.insertBefore(p, s);
    })();
    </script>
  <?php endif; ?>


  <? /* ==== Core DataPress functional variable ==== */ ?>
  <script>
    var DataPress = DataPress || {};
    <?
      global $datapress;
      if ( isset($datapress) && isset($datapress['me']) && isset($datapress['me']['apikey'])) {
        $api_key = $datapress['me']['apikey'];
      }
      else {
        $api_key = '';
      }
      try {
        $json_config = json_encode($datapress['config']);
      }
      catch (Exception $e) {
        $json_config = '{}';
      }
      echo "DataPress.api_key = '$api_key';";
      echo "DataPress.config = $json_config;";
      echo "DataPress.widget = {};";
    ?>
  </script>

</head>
