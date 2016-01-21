<div id="sidebar-wrapper">
	<ul class="sidebar-nav">
		<li class="sidebar-brand">Admin Menu</li>
		<li><?php echo $this->Html->link(__('Statistics'), array('controller' => 'statistics', 'action' => 'index', 'admin' => true)); ?> </li>
        <li><?php echo $this->Html->link(__('Employees'), array('controller' => 'users', 'action' => 'drh', 'admin' => true)); ?> </li>
		<li class="divider"></li>
		<li><?php echo $this->Html->link(__('List Lotteries'), array('controller' => 'lotteries', 'action' => 'index', 'admin' => true)); ?> </li>
		<li class="divider"></li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles','action' => 'index', 'admin' => true)); ?></li>
		<li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles','action' => 'add', 'admin' => true)); ?></li>
		<li class="divider"></li>
		<li><?php echo $this->Html->link(__('List Eve Items'), array('controller' => 'eve_items', 'action' => 'index', 'admin' => true)); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Item'), array('controller' => 'eve_items', 'action' => 'add', 'admin' => true)); ?> </li>
		<li class="divider"></li>
		<li><?php echo $this->Html->link(__('List Eve Categories'), array('controller' => 'eve_categories', 'action' => 'index', 'admin' => true)); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Category'), array('controller' => 'eve_categories', 'action' => 'add', 'admin' => true)); ?> </li>
		<li class="divider"></li>
		<li><?php echo $this->Html->link(__('List Awards'), array('controller' => 'awards','action' => 'index', 'admin' => true)); ?></li>
		<li><?php echo $this->Html->link(__('New Award'), array('controller' => 'awards','action' => 'add', 'admin' => true)); ?></li>
		<li class="divider"></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index', 'admin' => true)); ?> </li>
		<li class="divider"></li>
		<li><?php echo $this->Html->link(__('See Banned Ip\'s'), array('controller' => 'banned_ips', 'action' => 'index', 'admin' => true)); ?> </li>
		<li class="divider"></li>
		<li><?php echo $this->Html->link(__('See Logs'), array('controller' => 'database_logger', 'action' => 'logs', 'admin' => true)); ?> </li>

	</ul>
</div>


