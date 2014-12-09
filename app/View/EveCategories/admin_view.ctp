<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="eveCategories view">
				<h2><?php echo __('Eve Category'); ?></h2>
				<dl>
					<dt><?php echo __('Id'); ?></dt>
					<dd>
						<?php echo h($eveCategory['EveCategory']['id']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Name'); ?></dt>
					<dd>
						<?php echo h($eveCategory['EveCategory']['name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Type'); ?></dt>
					<dd>
						<?php echo h($eveCategory['EveCategory']['type']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Profit'); ?></dt>
					<dd>
						<?php echo h($eveCategory['EveCategory']['profit']); ?>%
						&nbsp;
					</dd>
					<dt><?php echo __('Status'); ?></dt>
					<dd>
						<?php echo h($eveCategory['EveCategory']['status']); ?>
						&nbsp;
					</dd>
				</dl>
			</div>
			<div class="actions">
				<h3><?php echo __('Actions'); ?></h3>
				<ul>
					<li><?php echo $this->Html->link(__('Edit Eve Category'), array('action' => 'edit', 'admin' => true, $eveCategory['EveCategory']['id'])); ?> </li>
					<li><?php echo $this->Form->postLink(__('Delete Eve Category'), array('action' => 'delete', 'admin' => true, $eveCategory['EveCategory']['id']), array(), __('Are you sure you want to delete # %s?', $eveCategory['EveCategory']['id'])); ?> </li>
				</ul>
			</div>
		</div>
	</div>
</div>
