<?php require_once('../../../private/initialize.php'); ?>

<?php $pages = [
  ['id' => '1', 'position' => '1', 'visible' => '1', 'menu_name' => 'Home'],
  ['id' => '2', 'position' => '2', 'visible' => '1', 'menu_name' => 'News'],
  ['id' => '3', 'position' => '3', 'visible' => '1', 'menu_name' => 'Consumer'],
  ['id' => '4', 'position' => '4', 'visible' => '1', 'menu_name' => 'About'],
  ['id' => '5', 'position' => '5', 'visible' => '1', 'menu_name' => 'Small Business'],
  ['id' => '6', 'position' => '6', 'visible' => '1', 'menu_name' => 'Commercial']
  ];
?>

<?php $page_title = 'Subjects'; ?>

<?php include(SHARED_PATH . '/header.php'); ?>

<div id="content">
  <div class="subjects listing">
    <h1>Subjects</h1>

    <div class="actions">
      <a class="action" href="">Create New Subject</a>
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

      <?php foreach($subjects as $subject) { ?>
                                      <tr>
                                        <td><?php echo h($subject['id']); ?></td>
                                        <td><?php echo h($subject['position']); ?></td>
                                        <td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
                                        <td><?php echo h($subject['menu_name']); ?></td>
                                        <td><a class="action" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($subject['id']))); ?>">View</a></td>
                                        <td><a class="action" href="">Edit</a></td>
                                        <td><a class="action" href="">Delete</a></td>
                                      </tr>
      <?php } ?>
    </table>

  </div>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
