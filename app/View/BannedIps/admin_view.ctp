<div class="bannedIps view">
<h2><?php echo __('Banned Ip'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($bannedIp['BannedIp']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ip'); ?></dt>
		<dd>
			<?php echo h($bannedIp['BannedIp']['ip']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nb Connection'); ?></dt>
		<dd>
			<?php echo h($bannedIp['BannedIp']['nb_connection']); ?>
			&nbsp;
		</dd>
		<dd>
			<?php echo h($bannedIp['BannedIp']['status']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Banned Ip'), array('action' => 'edit', $bannedIp['BannedIp']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Banned Ip'), array('action' => 'delete', $bannedIp['BannedIp']['id']), array(), __('Are you sure you want to delete # %s?', $bannedIp['BannedIp']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Banned Ips'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Banned Ip'), array('action' => 'add')); ?> </li>
	</ul>
</div>
