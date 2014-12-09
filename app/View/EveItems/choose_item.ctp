<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('AdminMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="eveItems index">
				<h2><?php echo __('Eve Items'); ?></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th></th>
							<th><?php echo $this->Paginator->sort('eve_id'); ?></th>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('eve_category_id'); ?></th>
							<th><?php echo $this->Paginator->sort('eve_value'); ?></th>
							<th><?php echo $this->Paginator->sort('status'); ?></th>
							<th><?php echo $this->Paginator->sort('nb_tickets_default'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($eveItems as $eveItem): ?>
							<tr>
								<td><img src="https://image.eveonline.com/Render/<?php echo $eveItem['EveItem']['eve_id']?>_64.png"></td>
								<td><?php echo h($eveItem['EveItem']['eve_id']); ?>&nbsp;</td>
								<td><?php echo h($eveItem['EveItem']['name']); ?>&nbsp;</td>
								<td><?php echo h($eveItem['EveCategory']['name']); ?>&nbsp;</td>
								<td><?php echo h($eveItem['EveItem']['eve_value']); ?>&nbsp;</td>
								<td><?php echo h($eveItem['EveItem']['status']); ?>&nbsp;</td>
								<td><?php echo h($eveItem['EveItem']['nb_tickets_default']); ?>&nbsp;</td>
								<td class="actions">
									<?php echo $this->Html->link(__('Create Lottery'), array('controller' => 'lotteries', 'action' => 'add', $EveItem['id'])); ?>
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
