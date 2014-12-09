<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
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
						<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', 'admin' => true, $user['Group']['id'])); ?>
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
					<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', 'admin' => true, $user['User']['id'])); ?> </li>
				</ul>
			</div>
			<div class="related">
				<h3><?php echo __('Related Tickets'); ?></h3>
				<?php if (!empty($user['Ticket'])): ?>
					<table class="table table-striped table-condensed">
						<tr>
							<th><?php echo __('Id'); ?></th>
							<th><?php echo __('Lottery Id'); ?></th>
							<th><?php echo __('Position'); ?></th>
							<th><?php echo __('Buyer User Id'); ?></th>
							<th><?php echo __('Is Winner'); ?></th>
							<th><?php echo __('Value'); ?></th>
						</tr>
						<?php foreach ($user['Ticket'] as $ticket): ?>
							<tr>
								<td><?php echo $ticket['id']; ?></td>
								<td><?php echo $ticket['lottery_id']; ?></td>
								<td><?php echo $ticket['position']; ?></td>
								<td><?php echo $ticket['buyer_user_id']; ?></td>
								<td><?php echo $ticket['is_winner']; ?></td>
								<td><?php echo $ticket['value']; ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php endif; ?>
			</div>
	</div>
</div>