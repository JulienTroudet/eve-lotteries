<div class="lotteries index">
	<h2><?php echo __('Lotteries'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('eve_item_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('creator_user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('nb_tickets'); ?></th>
			<th><?php echo $this->Paginator->sort('lottery_status_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($lotteries as $lottery): ?>
	<tr>
		<td><?php echo h($lottery['Lottery']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($lottery['EveItem']['name'], array('controller' => 'eve_items', 'action' => 'view', $lottery['EveItem']['id'])); ?>
		</td>
		<td><?php echo h($lottery['Lottery']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($lottery['User']['username'], array('controller' => 'users', 'action' => 'view', $lottery['User']['id'])); ?>
		</td>
		<td><?php echo h($lottery['Lottery']['created']); ?>&nbsp;</td>
		<td><?php echo h($lottery['Lottery']['modified']); ?>&nbsp;</td>
		<td><?php echo h($lottery['Lottery']['nb_tickets']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($lottery['LotteryStatus']['name'], array('controller' => 'lottery_statuses', 'action' => 'view', $lottery['LotteryStatus']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $lottery['Lottery']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $lottery['Lottery']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $lottery['Lottery']['id']), array(), __('Are you sure you want to delete # %s?', $lottery['Lottery']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Lottery'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Eve Items'), array('controller' => 'eve_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Item'), array('controller' => 'eve_items', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Lottery Statuses'), array('controller' => 'lottery_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lottery Status'), array('controller' => 'lottery_statuses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('controller' => 'tickets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
	</ul>
</div>
