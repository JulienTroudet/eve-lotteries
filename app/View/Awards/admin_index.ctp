<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="awards index">
				<h2><?php echo __('Awards'); ?></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('group'); ?></th>
							<th><?php echo $this->Paginator->sort('order'); ?></th>
							<th><?php echo $this->Paginator->sort('award_credits'); ?></th>
							<th><?php echo $this->Paginator->sort('status'); ?></th>
							<th><?php echo $this->Paginator->sort('modified'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($awards as $award): ?>
							<tr>
								<td><?php echo h($award['Award']['name']); ?>&nbsp;</td>
								<td><?php echo h($award['Award']['group']); ?>&nbsp;</td>
								<td><?php echo h($award['Award']['order']); ?>&nbsp;</td>
								<td><?php echo h($award['Award']['award_credits']); ?>&nbsp;</td>
								<td><?php echo h($award['Award']['status']); ?>&nbsp;</td>
								<td><?php echo h($award['Award']['modified']); ?>&nbsp;</td>
								<td class="actions">
									<?php echo $this->Html->link(__('View'), array('action' => 'view', 'admin' => true, $award['Award']['id'])); ?>
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', 'admin' => true, $award['Award']['id'])); ?>
									<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', 'admin' => true, $award['Award']['id']), array(), __('Are you sure you want to delete # %s?', $award['Award']['id'])); ?>
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
								'format' => __('Page {:page} of {:pages}, showing {:current} Awards out of {:count}, starting on award {:start}, ending on {:end}')
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
</div>
