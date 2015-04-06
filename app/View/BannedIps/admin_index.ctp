<div class="bannedIps index">
	<h2><?php echo __('Banned Ips'); ?></h2>
	<table class="table table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('ip'); ?></th>
			<th><?php echo $this->Paginator->sort('nb_connection'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($bannedIps as $bannedIp): ?>
	<tr>
		<td><?php echo h($bannedIp['BannedIp']['id']); ?>&nbsp;</td>
		<td><?php echo h($bannedIp['BannedIp']['ip']); ?>&nbsp;</td>
		<td><?php echo h($bannedIp['BannedIp']['nb_connection']); ?>&nbsp;</td>
		<td><?php echo h($bannedIp['BannedIp']['status']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $bannedIp['BannedIp']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $bannedIp['BannedIp']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $bannedIp['BannedIp']['id']), array(), __('Are you sure you want to delete # %s?', $bannedIp['BannedIp']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Banned Ip'), array('action' => 'add')); ?></li>
	</ul>
</div>
