<div id="sidebar-wrapper">
	<ul class="sidebar-nav">
		<li class="sidebar-brand">Admin Menu</li>
		<li><?php echo $this->Html->link(__('List Lotteries'), array('controller' => 'lotteries', 'action' => 'adminIndex')); ?> </li>
		<li>___________________</li>
		<li><?php echo $this->Html->link(__('List Eve Items'), array('controller' => 'eve_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Item'), array('controller' => 'eve_items', 'action' => 'add')); ?> </li>
		<li>___________________</li>
		<li><?php echo $this->Html->link(__('List Eve Categories'), array('controller' => 'eve_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Category'), array('controller' => 'eve_categories', 'action' => 'add')); ?> </li>
		<li>___________________</li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles','action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles','action' => 'add')); ?></li>
		<li>___________________</li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>

	</ul>
</div>
<div id="page-content-wrapper">
	<div class="page-content">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- content of page -->
				</div>
			</div>
		</div>
	</div>
</div>

