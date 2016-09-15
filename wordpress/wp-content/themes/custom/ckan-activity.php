  <aside class="sidebar" role="complementary">
    <? 
    if (search_is_publisher()) {
      get_template_part("snippets/sidebars/sidebar-publisher");
    }
    if (search_is_topic()) {
      get_template_part("snippets/sidebars/sidebar-topic");
    }
    if (search_is_dataset()) {
      get_template_part("snippets/sidebars/sidebar-dataset");
    }
    ?>
  </aside><!-- /.sidebar -->

  <main class="main" role="main">
    <?
    if (search_is_publisher()) {
      ?>
      <div class="pull-right follow-button-container">
        <? render_follow_button("publisher",$datapress['payload']['name']); ?>
      </div>
      <h1 class="publisher-header"><?= $datapress['payload']['title'] ?></h1>
      <?
      $endpoint = "/ajax/activity/organization";
    }
    if (search_is_topic()) {
      ?>
      <div class="pull-right follow-button-container">
        <? render_follow_button("topic",$datapress['payload']['name']); ?>
      </div>
      <h1 class="topic-header"><?= $datapress['payload']['title'] ?></h1>
      <?
      $endpoint = "/ajax/activity/group";
    }
    if (search_is_dataset()) {
      get_template_part("snippets/dataset-read-title");
      $endpoint = "/ajax/activity/package";
    }
    ?>
    <h2 class="subtitle"><? _e('Activity Stream', 'sage')?></h2>

    <ul class="activity">
      <? render_activity_stream($datapress['payload']['activity']); ?>
    </ul>
    <? if ( ! empty($endpoint) ): ?>
      <div class="text-center">
        <? render_ajax_button(array(
          'endpoint' => $endpoint,
          'selector' => ".activity",
          'id'       => $datapress['payload']['name'],
          'offset'   => count($datapress['payload']['activity']),
          'limit'    => 10,
        )); ?>
      </div>
    <? endif; ?>

  </main>
