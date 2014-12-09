<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="eveCategories view">
				<h2><?php echo __('Eve Category'); ?></h2>
				<dl>
					<dt><?php echo __('Id'); ?></dt>
					<dd>
						<?php echo h($eveCategory['EveCategory']['id']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Name'); ?></dt>
					<dd>
						<?php echo h($eveCategory['EveCategory']['name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Status'); ?></dt>
					<dd>
						<?php echo h($eveCategory['EveCategory']['status']); ?>
						&nbsp;
					</dd>
				</dl>
			</div>
			<div class="actions">
				<h3><?php echo __('Actions'); ?></h3>
				<ul>
					<li><?php echo $this->Html->link(__('Edit Eve Category'), array('action' => 'edit', $eveCategory['EveCategory']['id'])); ?> </li>
					<li><?php echo $this->Form->postLink(__('Delete Eve Category'), array('action' => 'delete', $eveCategory['EveCategory']['id']), array(), __('Are you sure you want to delete # %s?', $eveCategory['EveCategory']['id'])); ?> </li>
				</ul>
			</div>
			<div class="related">
				<h3><?php echo __('Related Eve Items'); ?></h3>
				<?php if (!empty($eveCategory['EveItem'])): ?>
					<table class="table table-striped table-condensed">
						<tr>
							<th><?php echo __('Eve Id'); ?></th>
							<th><?php echo __('Name'); ?></th>
							<th><?php echo __('Eve Value'); ?></th>
							<th><?php echo __('Status'); ?></th>
							<th><?php echo __('Nb Tickets Default'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
						<?php foreach ($eveCategory['EveItem'] as $eveItem): ?>
							<tr>
								<td><?php echo $eveItem['eve_id']; ?></td>
								<td><?php echo $eveItem['name']; ?></td>
								<td><?php echo $eveItem['eve_value']; ?></td>
								<td><?php echo $eveItem['status']; ?></td>
								<td><?php echo $eveItem['nb_tickets_default']; ?></td>
								<td class="actions">
									<?php echo $this->Html->link(__('View'), array('controller' => 'eve_items', 'action' => 'view', $eveItem['id'])); ?>
									<?php echo $this->Html->link(__('Edit'), array('controller' => 'eve_items', 'action' => 'edit', $eveItem['id'])); ?>
									<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'eve_items', 'action' => 'delete', $eveItem['id']), array(), __('Are you sure you want to delete # %s?', $eveItem['id'])); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
