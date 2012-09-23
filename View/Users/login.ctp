<?php echo $this->Form->create('User'); ?>
<?php echo $this->Form->inputs(array(
	'legend' => 'Login',
	'username',
	'password',
)); ?>
<?php echo $this->Form->submit(); ?>
<?php echo $this->Form->end(); ?>