<h2>Hello, <?php echo $this->Session->read('Auth.User.first_name') ?> <?php echo $this->Session->read('Auth.User.last_name') ?></h2>

<h3>Test Actions</h3>
<ul>
<?php foreach ($actions as $action): ?>
	<li><?php echo $this->Html->link('Posts::' . $action, array(
		'controller' => 'posts',
		'action' => $action
	)); ?></li>
<?php endforeach; ?>
</ul>