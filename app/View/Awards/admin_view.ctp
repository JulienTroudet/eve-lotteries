<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="award view">
				<h2><?php echo __('Award'); ?></h2>
				<dl>
					<dt><?php echo __('Title'); ?></dt>
					<dd>
						<?php echo h($award['Award']['id']); ?>
						&nbsp;
					</dd>
					<dd>
						<?php echo h($award['Award']['name']); ?>
						&nbsp;
					</dd>
					<dd>
						<?php echo h($award['Award']['description']); ?>
						&nbsp;
					</dd>
					<dd>
						<?php echo h($award['Award']['group']); ?>
						&nbsp;
					</dd>
					<dd>
						<?php echo h($award['Award']['order']); ?>
						&nbsp;
					</dd>
					<dd>
						<?php echo h($award['Award']['request']); ?>
						&nbsp;
					</dd>
					<dd>
						<?php echo h($award['Award']['award_credits']); ?>
						&nbsp;
					</dd>
					<dd>
						<?php echo h($award['Award']['status']); ?>
						&nbsp;
					</dd>
					
					
				</dl>
			</div>
			<div class="actions">
				<h3><?php echo __('Actions'); ?></h3>
				<ul>
					<li><?php echo $this->Html->link(__('Edit Award'), array('action' => 'edit', 'admin' => true, $award['Award']['id'])); ?> </li>
					<li><?php echo $this->Form->postLink(__('Delete Award'), array('action' => 'delete', 'admin' => true, $award['Award']['id']), array(), __('Are you sure you want to delete # %s?', $award['Award']['id'])); ?> </li>
				</ul>
			</div>
		</div>
	</div>
</div>
