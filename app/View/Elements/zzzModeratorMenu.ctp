<div id="sidebar-wrapper">
	<ul class="sidebar-nav">
		<li class="sidebar-brand">Moderator Menu</li>
		<li><?php echo $this->Html->link(__('Give Won Lotteries'), array('controller' => 'withdrawals', 'action' => 'index', 'admin' => true)); ?> </li>
		<li><?php echo $this->Html->link(__('New Super Lottery'), array('controller' => 'super_lotteries', 'action' => 'add', 'admin' => true)); ?> </li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles','action' => 'index', 'admin' => true)); ?></li>
		<li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles','action' => 'add', 'admin' => true)); ?></li>
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

