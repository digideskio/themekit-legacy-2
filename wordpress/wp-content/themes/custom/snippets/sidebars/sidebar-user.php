<section class="user-name">
  <h2><?echo $user['display_name']?></h2>
  <ul>
    <li class="p-top p-bottom user-gravatar text-center">
      <? 
      $user_email_hash = $user['email_hash'];
      $name = $user['display_name'];
      $url = "https://gravatar.com/avatar/$user_email_hash.png?s=180&d=mm";
      ?>
      <img class="gravatar gravatar-180" src="<?=$url?>" alt="<? printf( __('%s\'s avatar', 'sage'), $name); ?>" />
    </li>
  </ul>
</section>
<section class="user-profile-misc">
  <? if (in_array('apikey',$user) && strlen($user['apikey'])): ?>

    <h2><? _e('Developer Tools', 'sage'); ?></h2>
    <div class="p-top p-bottom text-center user-api-button">

      <? /* Button trigger modal */ ?>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#apiKeyModal">
        <i class="icon-unlock-alt"></i>&nbsp; <? _e('Get API Key', 'sage'); ?>
      </button>
    </div>

    <? /* Includes pop up for API key */ ?>
    <? include(locate_template('/snippets/modal-api-key.php')); ?>

  <? endif; ?>
</section>
