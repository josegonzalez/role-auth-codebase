<?php echo $this->Form->create('User'); ?>
<?php echo $this->Form->inputs(array('username','password', 'first_name', 'last_name')); ?>
<?php echo $this->Form->submit(); ?>
<?php echo $this->Form->end(); ?>