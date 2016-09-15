<? 
$user = $datapress['payload'];
?>

<aside class="sidebar" role="complementary">
  <? include(locate_template('/snippets/sidebars/sidebar-user.php')); ?>
</aside><!-- /.sidebar -->

<<<<<<< HEAD
<main class="main" role="main">
=======
<main class="main sidebar-primary" role="main">
>>>>>>> cf31e92fcc8724227494c0188467158c3ac919bb
  <? if (isset($user['is_my_profile'])): ?>
    <h1><? _e('My Dashboard', 'sage'); ?></h1>
  <? else: ?>
    <div class="pull-right follow-button-container">
      <? render_follow_button("user",$user['name']); ?>
    </div>
    <h1><? _e('Activity Stream', 'sage'); ?></h1>
  <? endif; ?>

  <div class="activity-stream">
    <div class="activity-stream-scrollbox">
    <? if (isset($user['is_my_profile'])): ?>
      <ul class="activity">
        <? render_activity_stream($user['dashboard']); ?>
      </ul>
      <div class="text-center">
        <? render_ajax_button(array(
          'endpoint' => '/ajax/activity/dashboard',
          'selector' => ".activity",
          'offset'   => count($user['dashboard']),
          'limit'    => 10,
        )); ?>
      </div>
    <? else: ?>
      <ul class="activity">
        <? render_activity_stream($user['activity']); ?>
      </ul>
      <div class="text-center">
        <? render_ajax_button(array(
          'endpoint' => '/ajax/activity/user',
          'selector' => ".activity",
          'id'       => $user['name'],
          'offset'   => count($user['activity']),
          'limit'    => 10,
        )); ?>
      </div>
    <? endif; ?>
    </div>
  </div>

</main>
