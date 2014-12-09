<div class="navbar-form navbar-right">

	<?php echo $this->Html->link(
		'Logout', 
		array('controller' => 'users', 'action' => 'logout'),
		array('class' => 'btn btn-danger')
		); ?>

		

	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->Html->link(
			'Admin Panel', 
			array('controller' => 'withdrawals', 'action' => 'index', 'admin' => true),
			array('class' => 'btn btn-primary')
			);
	}
	?>
</div>