<div class="superLotteries index">
	<h2><?php echo __('Super Lotteries'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('eve_item_id'); ?></th>
			<th><?php echo $this->Paginator->sort('number_items'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('creator_user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('nb_tickets'); ?></th>
			<th><?php echo $this->Paginator->sort('ticket_value'); ?></th>
			<th><?php echo $this->Paginator->sort('lottery_status_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($superLotteries as $superLottery): ?>
	<tr>
		<td><?php echo h($superLottery['SuperLottery']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($superLottery['EveItem']['name'], array('controller' => 'eve_items', 'action' => 'view', $superLottery['EveItem']['id'])); ?>
		</td>
		<td><?php echo h($superLottery['SuperLottery']['number_items']); ?>&nbsp;</td>
		<td><?php echo h($superLottery['SuperLottery']['name']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($superLottery['User']['eve_name'], array('controller' => 'users', 'action' => 'view', $superLottery['User']['id'])); ?>
		</td>
		<td><?php echo h($superLottery['SuperLottery']['created']); ?>&nbsp;</td>
		<td><?php echo h($superLottery['SuperLottery']['modified']); ?>&nbsp;</td>
		<td><?php echo h($superLottery['SuperLottery']['nb_tickets']); ?>&nbsp;</td>
		<td><?php echo h($superLottery['SuperLottery']['ticket_value']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($superLottery['LotteryStatus']['name'], array('controller' => 'lottery_statuses', 'action' => 'view', $superLottery['LotteryStatus']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $superLottery['SuperLottery']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $superLottery['SuperLottery']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $superLottery['SuperLottery']['id']), array(), __('Are you sure you want to delete # %s?', $superLottery['SuperLottery']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Super Lottery'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Eve Items'), array('controller' => 'eve_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Item'), array('controller' => 'eve_items', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Lottery Statuses'), array('controller' => 'lottery_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lottery Status'), array('controller' => 'lottery_statuses', 'action' => 'add')); ?> </li>
	</ul>
</div>
