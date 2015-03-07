<div id="wrapper">
	<?php  echo $this->element('ManagerMenu', array());?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<h2><?php echo __('Super Lotteries'); ?></h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('eve_item_id'); ?></th>
							<th><?php echo $this->Paginator->sort('number_items'); ?></th>
							<th><?php echo $this->Paginator->sort('name'); ?></th>
							<th><?php echo $this->Paginator->sort('winner_user_id'); ?></th>
							<th><?php echo $this->Paginator->sort('nb_tickets'); ?></th>
							<th><?php echo $this->Paginator->sort('ticket_value'); ?></th>
							<th><?php echo $this->Paginator->sort('lottery_status_id'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($superLotteries as $superLottery): ?>
							<tr>
								<td>
									<button class="btn btn-block btn-xs btn-warning" type="button" onclick="CCPEVE.buyType(<?php echo $superLottery['EveItem']['eve_id']; ?>)">Buy <?php echo $superLottery['EveItem']['name']; ?></button>
									<button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.createContract(1, 60003760, <?php echo $superLottery['EveItem']['eve_id']; ?>)">Create Exchange Contract</button>
								</td>
								<td><?php echo h($superLottery['SuperLottery']['number_items']); ?>&nbsp;</td>
								<td><?php echo $this->Html->link($superLottery['SuperLottery']['name'], array('action' => 'view', $superLottery['SuperLottery']['id']));?>&nbsp;</td>
								<td>
									<?php if(isset($superLottery['Winner']['id'])): ?>
										<div>
											<img src="https://image.eveonline.com/Character/<?php echo $superLottery['Winner']['id']; ?>_32.jpg">
										</div>
										<div>
											<button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.showInfo(1377, <?php echo $superLottery['Winner']['id']; ?>)"><?php echo $superLottery['Winner']['eve_name']; ?></button>
										</div>
									<?php endif; ?>
								</td>
								<td><?php echo h($superLottery['SuperLottery']['nb_tickets']); ?>&nbsp;</td>
								<td><?php echo h($superLottery['SuperLottery']['ticket_value']); ?>&nbsp;</td>
								<td><?php echo h($superLottery['SuperLottery']['status']); ?>&nbsp;</td>
								<td class="actions">
									<?php if($superLottery['SuperLottery']['status'] == 'waiting'):?>
										<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', 'admin' => true, $superLottery['SuperLottery']['id']), array(), __('Are you sure you want to delete # %s?', $superLottery['SuperLottery']['id'])); ?>
									<?php elseif($superLottery['SuperLottery']['status'] == 'claimed'):?>
										<?php echo $this->Html->link(
											'Complete this',
											array('controller' => 'super_lotteries', 'action' => 'complete', 'admin'=>true, 'plugin' => false, $superLottery['SuperLottery']['id']),
											array('class' => 'btn btn-block btn-danger btn-xs btn-complete')
											);?>
											

										<?php endif;?>
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
									'format' => __('Page {:page} of {:pages}, showing {:current} super lotteries out of {:count}, starting on super lottery {:start}, ending on {:end}')
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