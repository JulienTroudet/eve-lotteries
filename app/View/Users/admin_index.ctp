<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="users index">
				<h2><?php echo __('Users'); ?></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('username'); ?></th>
							<th><?php echo $this->Paginator->sort('mail'); ?></th>
							<th><?php echo $this->Paginator->sort('group_id'); ?></th>
							<th><?php echo $this->Paginator->sort('created'); ?></th>
							<th><?php echo $this->Paginator->sort('modified'); ?></th>
							<th><?php echo $this->Paginator->sort('wallet'); ?></th>
							<th><?php echo $this->Paginator->sort('tokens'); ?></th>
							<th><?php echo $this->Paginator->sort('eve_id'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($users as $user): ?>
							<tr>
								<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
								<td><?php echo h($user['User']['mail']); ?>&nbsp;</td>
								<td>
									<?php echo $this->Html->link($user['Group']['name'], array('controller' => 'groups', 'action' => 'view', $user['Group']['id'])); ?>
								</td>
								<td><?php echo h($user['User']['created']); ?>&nbsp;</td>
								<td><?php echo h($user['User']['modified']); ?>&nbsp;</td>
								<td><?php echo h($user['User']['wallet']); ?>&nbsp;</td>
								<td><?php echo h($user['User']['tokens']); ?>&nbsp;</td>
								<td><?php echo h($user['User']['eve_id']); ?>&nbsp;</td>
								<td class="actions">
									<?php echo $this->Html->link(__('View'), array('action' => 'view', 'admin' => true, $user['User']['id'])); ?>
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', 'admin' => true, $user['User']['id'])); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="row">
					<ul class="pager">
						<li class="previous">
							<?php
							echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
							?>
						</li>
						<li>
							<?php
							echo $this->Paginator->counter(array(
								'format' => __('Page {:page} of {:pages}, showing {:current} Users out of {:count}, starting on user {:start}, ending on {:end}')
								));
								?>	
							</li>
							<li class="next">
								<?php
								echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
								?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>