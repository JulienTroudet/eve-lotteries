<?php print_r($choosenTicket);?>
<div class="lotteries view">
<h2>Buy a ticket</h2>
	<dl>
		<dt><?php echo __('Eve Item'); ?></dt>
		<dd>
			<?php echo $this->Html->link($lottery['EveItem']['name'], array('controller' => 'eve_items', 'action' => 'view', $lottery['EveItem']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($lottery['Lottery']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($lottery['User']['username'], array('controller' => 'users', 'action' => 'view', $lottery['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($lottery['Lottery']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($lottery['Lottery']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nb Tickets'); ?></dt>
		<dd>
			<?php echo h($lottery['Lottery']['nb_tickets']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lottery Status'); ?></dt>
		<dd>
			<?php echo h($lottery['LotteryStatus']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Lottery'), array('action' => 'edit', $lottery['Lottery']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Lottery'), array('action' => 'delete', $lottery['Lottery']['id']), array(), __('Are you sure you want to delete # %s?', $lottery['Lottery']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Lotteries'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lottery'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Eve Items'), array('controller' => 'eve_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Item'), array('controller' => 'eve_items', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Tickets'); ?></h3>
	<?php if (!empty($lottery['Ticket'])): ?>
	<table class="table table-striped table-condensed">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Lottery Id'); ?></th>
		<th><?php echo __('Position'); ?></th>
		<th><?php echo __('Buyer User Id'); ?></th>
		<th><?php echo __('Is Winner'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($lottery['Ticket'] as $ticket): ?>
		<tr>
			<td><?php echo $ticket['id']; ?></td>
			<td><?php echo $ticket['lottery_id']; ?></td>
			<td><?php echo $ticket['position']; ?></td>
			<td><?php echo $ticket['buyer_user_id']; ?></td>
			<td><?php echo $ticket['is_winner']; ?></td>
			<td><?php echo $ticket['value']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'tickets', 'action' => 'view', $ticket['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'tickets', 'action' => 'edit', $ticket['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'tickets', 'action' => 'delete', $ticket['id']), array(), __('Are you sure you want to delete # %s?', $ticket['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ticket'), array('controller' => 'tickets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
