<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="eveItems view">
				<h2><?php echo __('Eve Item'); ?></h2>
				<dl>
					<dt><?php echo __('Id'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['id']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Eve Id'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['eve_id']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Name'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Eve Category'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveCategory']['name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Eve Value'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['eve_value']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Status'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['status']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Nb Tickets Default'); ?></dt>
					<dd>
						<?php echo h($eveItem['EveItem']['nb_tickets_default']); ?>
						&nbsp;
					</dd>
				</dl>
			</div>
			<div class="actions">
				<h3><?php echo __('Actions'); ?></h3>
				<ul>
					<li><?php echo $this->Html->link(__('Edit Eve Item'), array('action' => 'edit', $eveItem['EveItem']['id'])); ?> </li>
					<li><?php echo $this->Form->postLink(__('Delete Eve Item'), array('action' => 'delete', $eveItem['EveItem']['id']), array(), __('Are you sure you want to delete # %s?', $eveItem['EveItem']['id'])); ?> </li>
					<li><?php echo $this->Html->link(__('Create Lottery for this item'), array('controller' => 'lotteries', 'action' => 'add', $eveItem['EveItem']['id'])); ?> </li>
				</ul>
			</div>
			<div class="related">
				<h3><?php echo __('Related Lotteries'); ?></h3>
				<?php if (!empty($eveItem['Lottery'])): ?>
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
						<?php foreach ($eveItem['Lottery'] as $lottery): ?>
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
			</div>
		</div>
	</div>
</div>

