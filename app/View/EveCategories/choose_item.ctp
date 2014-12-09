<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="eveCategories index">
				<h2><?php echo __('Choose Item'); ?></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('EveCategory.name', 'Category Name'); ?></th>
							<th><?php echo $this->Paginator->sort('EveCategory.EveItem.name', 'Item Name'); ?></th>
							<th><?php echo $this->Paginator->sort('EveCategory.EveItem.eve_value', 'Item Value'); ?></th>
							<th><?php echo $this->Paginator->sort('EveCategory.status', 'Status'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($eveCategories as $eveCategory): ?>
							<?php foreach ($eveCategory['EveItem'] as $EveItem): ?>
								<tr>
									<td><?php echo h($eveCategory['EveCategory']['name']); ?>&nbsp;</td>
									<td><?php echo h($EveItem['name']); ?>&nbsp;</td>
									<td><?php echo h($EveItem['eve_value']); ?>&nbsp;</td>
									<td><?php echo h($eveCategory['EveCategory']['status']); ?>&nbsp;</td>
									<td class="actions">
										<?php echo $this->Html->link(__('Create Lottery'), array('controller' => 'lotteries', 'action' => 'add', $EveItem['id'])); ?>
									</td>
								</tr>
							<?php endforeach; ?>
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
								'format' => __('Page {:page} of {:pages}, showing {:current} items out of {:count}, starting on item {:start}, ending on {:end}')
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