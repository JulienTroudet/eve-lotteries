<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mail'); ?></dt>
		<dd>
			<?php echo h($user['User']['mail']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wallet'); ?></dt>
		<dd>
			<?php echo h($user['User']['wallet']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Eve Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['eve_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array(), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Articles'), array('controller' => 'articles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Lotteries'), array('controller' => 'lotteries', 'action' => 'index')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Tickets'); ?></h3>
	<?php if (!empty($user['Ticket'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Lottery Id'); ?></th>
		<th><?php echo __('Position'); ?></th>
		<th><?php echo __('Buyer User Id'); ?></th>
		<th><?php echo __('Is Winner'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Ticket'] as $ticket): ?>
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
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Articles'); ?></h3>
	<?php if (!empty($user['Article'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Body'); ?></th>
		<th><?php echo __('Creator User Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Article'] as $article): ?>
		<tr>
			<td><?php echo $article['id']; ?></td>
			<td><?php echo $article['title']; ?></td>
			<td><?php echo $article['body']; ?></td>
			<td><?php echo $article['creator_user_id']; ?></td>
			<td><?php echo $article['created']; ?></td>
			<td><?php echo $article['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'articles', 'action' => 'view', $article['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'articles', 'action' => 'edit', $article['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'articles', 'action' => 'delete', $article['id']), array(), __('Are you sure you want to delete # %s?', $article['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Article'), array('controller' => 'articles', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Lotteries'); ?></h3>
	<?php if (!empty($user['Lottery'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Eve Item Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Creator User Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Nb Tickets'); ?></th>
		<th><?php echo __('Lottery Status Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Lottery'] as $lottery): ?>
		<tr>
			<td><?php echo $lottery['id']; ?></td>
			<td><?php echo $lottery['eve_item_id']; ?></td>
			<td><?php echo $lottery['name']; ?></td>
			<td><?php echo $lottery['creator_user_id']; ?></td>
			<td><?php echo $lottery['created']; ?></td>
			<td><?php echo $lottery['modified']; ?></td>
			<td><?php echo $lottery['nb_tickets']; ?></td>
			<td><?php echo $lottery['lottery_status_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'lotteries', 'action' => 'view', $lottery['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'lotteries', 'action' => 'edit', $lottery['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'lotteries', 'action' => 'delete', $lottery['id']), array(), __('Are you sure you want to delete # %s?', $lottery['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Lottery'), array('controller' => 'lotteries', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
