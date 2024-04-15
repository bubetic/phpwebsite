<?php require_once('../../../private/initialize.php'); ?>

<?php $pages = [
  ['id' => '1', 'position' => '1', 'visible' => '1', 'menu_name' => 'Home'],
  ['id' => '2', 'position' => '2', 'visible' => '1', 'menu_name' => 'News'],
  ['id' => '3', 'position' => '3', 'visible' => '1', 'menu_name' => 'Contact'],
  ['id' => '4', 'position' => '4', 'visible' => '1', 'menu_name' => 'About'],
  ['id' => '5', 'position' => '5', 'visible' => '1', 'menu_name' => 'Sign Up'],
  ['id' => '6', 'position' => '6', 'visible' => '1', 'menu_name' => 'Login']
  ];
?>

<?php $page_title = 'Pages'; ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<div id="content">
  <div class="pages listing">
    <h1>Pages</h1>

    <div class="actions">
      <a class="action" href="">Create New Page</a>
    </div>

    <table class="list">
      <tr>
        <th>ID</th>
        <th>Position</th>
        <th>Visible</th>
        <th>Name</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>        
      </tr>

      <?php foreach($pages as $page) { ?>
                                      <tr>
                                        <td><?php echo h($page['id']); ?></td>
                                        <td><?php echo h($page['position']); ?></td>
                                        <td><?php echo h($page['visible']); ?></td>
                                        <td><?php echo h($page['menu_name']); ?></td>
                                        <td><a class="action" href="<?php echo url_for('/staff/pages/show.php=' . h(u($page['id']))); ?>">View</a></td>
                                        <td><a class="action" href="">Edit</a></td>
                                        <td><a class="action" href="">Delete</a></td>
                                      </tr>
      <?php } ?>
    </table>

  </div>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
