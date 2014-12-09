<div class="superLotteries view">
<h2><?php echo __('Super Lottery'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($superLottery['SuperLottery']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Eve Item'); ?></dt>
		<dd>
			<?php echo $this->Html->link($superLottery['EveItem']['name'], array('controller' => 'eve_items', 'action' => 'view', $superLottery['EveItem']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Number Items'); ?></dt>
		<dd>
			<?php echo h($superLottery['SuperLottery']['number_items']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($superLottery['SuperLottery']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($superLottery['User']['eve_name'], array('controller' => 'users', 'action' => 'view', $superLottery['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($superLottery['SuperLottery']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($superLottery['SuperLottery']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nb Tickets'); ?></dt>
		<dd>
			<?php echo h($superLottery['SuperLottery']['nb_tickets']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ticket Value'); ?></dt>
		<dd>
			<?php echo h($superLottery['SuperLottery']['ticket_value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lottery Status'); ?></dt>
		<dd>
			<?php echo $this->Html->link($superLottery['LotteryStatus']['name'], array('controller' => 'lottery_statuses', 'action' => 'view', $superLottery['LotteryStatus']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Super Lottery'), array('action' => 'edit', $superLottery['SuperLottery']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Super Lottery'), array('action' => 'delete', $superLottery['SuperLottery']['id']), array(), __('Are you sure you want to delete # %s?', $superLottery['SuperLottery']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Super Lotteries'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Super Lottery'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Eve Items'), array('controller' => 'eve_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Eve Item'), array('controller' => 'eve_items', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Lottery Statuses'), array('controller' => 'lottery_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lottery Status'), array('controller' => 'lottery_statuses', 'action' => 'add')); ?> </li>
	</ul>
</div>
