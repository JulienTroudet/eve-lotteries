<div id="wrapper">
	<?php 
		echo $this->element('ManagerMenu', array());
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="transactions index">
				<h2><?php echo __('API Waiting Transactions'); ?></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('amount'); ?></th>
							<th><?php echo $this->Paginator->sort('user_id'); ?></th>
							<th><?php echo $this->Paginator->sort('created'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($transactions as $transaction): ?>
							<tr>
								<td><?php echo number_format($transaction['Transaction']['amount'], 2); ?>&nbsp;</td>
								<td>
									<?php echo $this->Html->link($transaction['User']['eve_name'], array('controller' => 'users', 'action' => 'view', $transaction['User']['id'])); ?>
								</td>
								<td><?php echo h($transaction['Transaction']['created']); ?>&nbsp;</td>
								<td class="actions">
									<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', 'admin' => true, $transaction['Transaction']['id']), array(), __('Are you sure you want to delete # %s? This will remove ISK from the player.', $transaction['Transaction']['id'])); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12">
						<ul class="pager">
							<li class="previous">
								<?php echo $this->Paginator->prev('Previous', array(), null, array('class' => 'prev disabled')); ?>
							</li>
							<li>
								<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>	
							</li>
							<li class="next">
								<?php echo $this->Paginator->next('Next', array(), null, array('class' => 'next disabled')); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
