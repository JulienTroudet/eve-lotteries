<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="lotteries index">
				<h2><?php echo __('Lotteries'); ?></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('eve_item_id'); ?></th>
							<th><?php echo $this->Paginator->sort('EveItem.eve_value', 'Eve Value'); ?></th>
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
								<td>
									<?php echo $this->Html->link($lottery['EveItem']['name'], array('controller' => 'eve_items', 'action' => 'view', 'admin' => true, $lottery['EveItem']['id'])); ?>
								</td>
								<td>
									<?php echo h($lottery['EveItem']['eve_value']); ?>
								</td>
								<td><?php echo h($lottery['Lottery']['name']); ?>&nbsp;</td>
								<td>
									<?php echo $this->Html->link($lottery['User']['username'], array('controller' => 'users', 'action' => 'view', 'admin' => true, $lottery['User']['id'])); ?>
								</td>
								<td><?php echo h($lottery['Lottery']['created']); ?>&nbsp;</td>
								<td><?php echo h($lottery['Lottery']['modified']); ?>&nbsp;</td>
								<td><?php echo h($lottery['Lottery']['nb_tickets']); ?>&nbsp;</td>
								<td>
									<?php echo h($lottery['LotteryStatus']['name']); ?>
								</td>
								<td class="actions">
									<?php echo $this->Html->link(__('View'), array('action' => 'adminView', 'admin' => true, $lottery['Lottery']['id'])); ?>
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', 'admin' => true, $lottery['Lottery']['id'])); ?>
									<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', 'admin' => true, $lottery['Lottery']['id']), array(), __('Are you sure you want to delete # %s?', $lottery['Lottery']['id'])); ?>
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
								'format' => __('Page {:page} of {:pages}, showing {:current} lotteries out of {:count}, starting on lottery {:start}, ending on {:end}')
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
	</div>