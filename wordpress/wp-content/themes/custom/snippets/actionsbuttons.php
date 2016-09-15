<? use DataPress\User; ?>

<?  if ( ! is_user_logged_in() ): ?>
  <div class="action-buttons hidden-xs">
    <a class="text-muted menu-register" href="/wp-login.php?action=register">Register an Account</a>
    <a href="/wp-login.php" class="menu-login m-left btn btn-default">&nbsp;Login &nbsp;<i class="icon-user"></i></a>
  </div><!-- /dp-action-buttons -->
<? else: ?>
  <? global $current_user; ?>

  <div class="action-buttons hidden-xs">
    <span class="text-muted menu-logged-in">
      Logged in as <a href="/user"><?= $current_user->display_name ?></a>
    </span>
    <div class="m-left dropdown btn-group">
      <button class="dropdown-toggle btn btn-primary" type="button" id="dropdownActions" data-toggle="dropdown" aria-haspopup="true">
        <i class="icon-user"></i>&nbsp; Actions <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownActions">

        <? if ( ! empty(User\link_edit_this_page()) ): ?>
          <? $link = User\link_edit_this_page(); ?>
          <li class="menu-edit-this">
            <a href="<?= $link['url'] ?>">
              <div class="dashicons dashicons-welcome-write-blog"></div>&nbsp; <?= $link['text'] ?>
            </a>
          </li>
        <? endif; ?>

        <? if (current_user_can('manage_options')): ?>
          <li class="dropdown-header">WordPress Admin</li>
          <li class="menu-wp-admin"><a href="/wp-admin/index.php"><div class="dashicons dashicons-admin-site"></div>&nbsp; Manage Site</a></li>
          <li class="menu-wp-users"><a href="/wp-admin/users.php"><div class="dashicons dashicons-admin-users"></div>&nbsp; Manage Users</a></li>
        <? endif; ?>

        <? if ( current_user_can('edit_posts') || current_user_can('edit_pages') ): ?>
          <li class="dropdown-header">Content Management</li>

          <? if ( ! current_user_can('manage_options') ): ?>
            <? /* Editors didn't get this option in the above category, so here it is. */ ?>
            <li class="menu-wp-admin"><a href="/wp-admin/index.php"><div class="dashicons dashicons-admin-site"></div>&nbsp; Manage Site</a></li>
          <? endif; ?>
          <? foreach (User\create_new_links() as $link): ?>
            <li class="menu-wp-post-new">
              <a href="/wp-admin/post-new.php?post_type=<?= $link['name'] ?>">
                <div class="dashicons <?= $link['icon'] ?>"></div>&nbsp; <?= $link['text'] ?>
              </a>
            </li>
          <? endforeach ?>

        <? endif; ?>

        <? if ( User\can_add_dataset() || User\can_add_publisher() ): ?>
          <li class="dropdown-header">Data Catalogue</li>
          <? if (User\can_add_dataset()): ?>
            <li class="menu-ckan-dataset-new"><a href="<?= site_url('dataset/new') ?>"><div class="dashicons dashicons-networking"></div>&nbsp; Add a Dataset</a></li>
          <? endif; ?>
          <? if (User\can_add_publisher()): ?>
            <li class="menu-ckan-publisher-new"><a href="<?= site_url('publisher/new') ?>"><div class="dashicons dashicons-groups"></div>&nbsp; Add a Publisher</a></li>
          <? endif; ?>
        <? endif; ?>

        <li class="dropdown-header">My Account</li>
        <li class="menu-dashboard"><a href="<?= site_url('/user') ?>"><div class="dashicons dashicons-dashboard"></div>&nbsp; My Dashboard</a></li>
        <!-- <li class="menu&#45;wp&#45;profile"><a href="<? // site_url('/wp&#45;admin/profile.php') ?>"><div class="dashicons dashicons&#45;id&#45;alt"></div>&#38;nbsp; Edit My Profile</a></li> -->
        <li class="menu-logout"><a href=<?= wp_logout_url() ?>><div class="dashicons dashicons-download"></div>&nbsp; Logout</a></li>

      </ul>
    </div>

    <? if (User\no_backend_available()): ?>
      <button class="btn btn-default disabled" disabled="disabled"><i class="icon-unlink"></i> Bookmarks <span class="caret"></span></button>

    <? else: ?>
      <div class="dropdown btn-group">
        <button class="dropdown-toggle btn btn-default" type="button" id="dropdownBookmarks" data-toggle="dropdown" aria-haspopup="true">
          <i class="icon-bookmark"></i>&nbsp; Bookmarks (<?= User\count_bookmarks() ?>) <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownBookmarks">
          <li class="menu-all-publishers"><a href="/publisher"><div class="dashicons dashicons-groups"></div>&nbsp; View All Publishers</a></li>
          <li class="menu-all-topics"><a href="/topic"><div class="dashicons dashicons-portfolio"></div>&nbsp; View All Topics</a></li>
          <li class="menu-all-datasets"><a href="/dataset"><div class="dashicons dashicons-networking"></div>&nbsp; View All Datasets</a></li>

          <? if ( ! empty(User\bookmarked_publishers())): ?>
            <li class="dropdown-header">Publishers (<?= count(User\bookmarked_publishers()) ?>)</li>
            <? foreach (User\bookmarked_publishers() as $fu): ?>
              <li class="menu-bookmark menu-bookmark-publisher">
                <a href="<?= site_url('publisher/' . $fu['name']) ?>">
                  <div class="dashicons dashicons-groups"></div>&nbsp; <?= $fu['title'] ?>
                  <? if ( isset($fu['capacity']) ): ?>
                    <small class="text-muted">(<?= $fu['capacity'] ?>)</small>
                  <? endif; ?>
                </a>
              </li>
            <? endforeach; ?>
          <? endif; ?>

          <? if ( ! empty(User\bookmarked_users())): ?>
            <li class="dropdown-header">Users (<?= count(User\bookmarked_users()) ?>)</li>
          <? endif; ?>
          <? foreach (User\bookmarked_users() as $fu): ?>
            <li class="menu-bookmark menu-bookmark-user"><a href="<?= site_url('user/' . $fu['name']) ?>"><div class="dashicons dashicons-admin-users"></div>&nbsp; <?= $fu['fullname'] ?></a></li>
          <? endforeach; ?>

          <? if ( ! empty(User\bookmarked_topics())): ?>
            <li class="dropdown-header">Topics (<?= count(User\bookmarked_topics()) ?>)</li>
          <? endif; ?>
          <? foreach (User\bookmarked_topics() as $fu): ?>
            <li class="menu-bookmark menu-bookmark-topic"><a href="<?= site_url('topic/' . $fu['name']) ?>"><div class="dashicons dashicons-portfolio"></div>&nbsp; <?= $fu['title'] ?></a></li>
          <? endforeach; ?>

          <? if ( ! empty(User\bookmarked_datasets())): ?>
            <li class="dropdown-header">Datasets (<?= count(User\bookmarked_datasets()) ?>)</li>
          <? endif; ?>
          <? foreach (User\bookmarked_datasets() as $fu): ?>
            <li class="menu-bookmark menu-bookmark-dataset"><a href="<?= site_url('dataset/' . $fu['name']) ?>"><div class="dashicons dashicons-networking"></div>&nbsp; <?= $fu['title'] ?></a></li>
          <? endforeach; ?>

          <? if (User\count_bookmarks() === 0): ?>
            <li class="dropdown-header">
              <em style="font-weight: normal;">Click the "Bookmark" button on a dataset,<br/>topic, publisher or user to save it here.</em>
            </li>
          <? endif; ?>

        </ul>
      </div>

    <? endif; ?>
  </div><!-- /dp-action-buttons -->

<? endif; ?>
