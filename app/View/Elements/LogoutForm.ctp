<div class="navbar-form navbar-right">

	<?php echo $this->Html->link(
		'Account', 
		array('controller' => 'users', 'action' => 'account', 'admin'=>false, 'plugin' => false),
		array('class' => 'btn btn-primary')
		); ?>

	<?php echo $this->Html->link(
		'Logout', 
		array('controller' => 'users', 'action' => 'logout', 'admin'=>false, 'plugin' => false),
		array('class' => 'btn btn-danger')
		);?>	

	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->Html->link(
			'Manager', 
			array('controller' => 'withdrawals', 'action' => 'index', 'admin' => true, 'plugin' => false),
			array('class' => 'btn btn-primary')
			);
	}
	?>
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->Html->link(
			'Admin', 
			array('controller' => 'statistics', 'action' => 'index', 'admin' => true, 'plugin' => false),
			array('class' => 'btn btn-primary')
			);
	}
	?>
</div>