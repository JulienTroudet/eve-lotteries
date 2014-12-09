<div class="tickets view">
<h2><?php echo __('Ticket'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lottery'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ticket['Lottery']['name'], array('controller' => 'lotteries', 'action' => 'view', $ticket['Lottery']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Position'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['position']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($ticket['User']['username'], array('controller' => 'users', 'action' => 'view', $ticket['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Winner'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['is_winner']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($ticket['Ticket']['value']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Ticket'), array('action' => 'edit', $ticket['Ticket']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Ticket'), array('action' => 'delete', $ticket['Ticket']['id']), array(), __('Are you sure you want to delete # %s?', $ticket['Ticket']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tickets'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ticket'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Lotteries'), array('controller' => 'lotteries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lottery'), array('controller' => 'lotteries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
