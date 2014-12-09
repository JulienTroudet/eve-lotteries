<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="eveCategories index">
				<h2><?php echo __('Eve Categories'); ?></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('id'); ?></th>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('profit'); ?></th>
							<th><?php echo $this->Paginator->sort('status'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($eveCategories as $eveCategory): ?>
							<tr>
								<td><?php echo h($eveCategory['EveCategory']['id']); ?>&nbsp;</td>
								<td><?php echo h($eveCategory['EveCategory']['name']); ?>&nbsp;</td>
								<td><?php echo h($eveCategory['EveCategory']['profit']); ?>&nbsp;%</td>
								<td><?php echo h($eveCategory['EveCategory']['status']); ?>&nbsp;</td>
								<td class="actions">
									<?php echo $this->Html->link(__('View'), array('action' => 'view', 'admin' => true, $eveCategory['EveCategory']['id'])); ?>
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', 'admin' => true, $eveCategory['EveCategory']['id'])); ?>
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
								'format' => __('Page {:page} of {:pages}, showing {:current} categories out of {:count}, starting on category {:start}, ending on {:end}')
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