<div id="wrapper">
	<?php  echo $this->element('ManagerMenu', array());?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="row">
				<h2><?php echo __('Flash Lotteries'); ?></h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('eve_item_id'); ?></th>
							<th><?php echo $this->Paginator->sort('number_items'); ?></th>
							<th>Winner</th>
							<th><?php echo $this->Paginator->sort('nb_tickets'); ?></th>
							<th><?php echo $this->Paginator->sort('lottery_status'); ?></th>
							<th><?php echo $this->Paginator->sort('start_date'); ?></th>
							<th><?php echo $this->Paginator->sort('expiration_date'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($flashLotteries as $flashLottery): ?>
							<tr>
								<td>
									

									<?php if($flashLottery['FlashLottery']['status'] == 'claimed_isk'): ?> 
										<p><?php echo $flashLottery['EveItem']['name']; ?></p>
										<p><?php echo $flashLottery['EveItem']['eve_value']*$flashLottery['FlashLottery']['number_items'];?></p>

										<p><?php echo number_format($flashLottery['EveItem']['eve_value']*$flashLottery['FlashLottery']['number_items'], 0);?></p>

									<?php elseif($flashLottery['FlashLottery']['status'] == 'claimed_item'): ?>
										<button class="btn btn-block btn-xs btn-warning" type="button" onclick="CCPEVE.buyType(<?php echo $flashLottery['EveItem']['eve_id']; ?>)">Buy <?php echo $flashLottery['EveItem']['name']; ?></button>
										<button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.createContract(1, 60003760, [<?php echo $flashLottery['EveItem']['eve_id']; ?>])">Create Exchange Contract</button>
									<?php endif;?>
								</td>
								<td><?php echo h($flashLottery['FlashLottery']['number_items']); ?></td>
								<td>
									<?php if(isset($flashLottery['Winner']['id'])): ?>
										<div>
											<img src="https://image.eveonline.com/Character/<?php echo $flashLottery['Winner']['id']; ?>_32.jpg">
										</div>
										<div>
											<button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.showInfo(1377, <?php echo $flashLottery['Winner']['id']; ?>)"><?php echo $flashLottery['Winner']['eve_name']; ?></button>
										</div>
									<?php endif; ?>
								</td>
								<td><?php echo h($flashLottery['FlashLottery']['nb_tickets']); ?></td>
								<td><?php echo h($flashLottery['FlashLottery']['status']); ?></td>
								<td><?php echo CakeTime::niceShort(h($flashLottery['FlashLottery']['start_date'])); ?></td>
								<td><?php echo CakeTime::niceShort(h($flashLottery['FlashLottery']['expiration_date'])); ?></td>
								<td class="actions">
									<?php if($flashLottery['FlashLottery']['status'] == 'waiting'):?>
										<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', 'admin' => true, $flashLottery['FlashLottery']['id']), array(), __('Are you sure you want to delete # %s?', $flashLottery['FlashLottery']['id'])); ?>
									<?php elseif($flashLottery['FlashLottery']['status'] != 'waiting' && $flashLottery['FlashLottery']['status'] != 'ongoing'):?>
										<?php echo $this->Html->link(
											'Complete this',
											array('controller' => 'flash_lotteries', 'action' => 'complete', 'admin'=>true, 'plugin' => false, $flashLottery['FlashLottery']['id']),
											array('class' => 'btn btn-block btn-danger btn-xs btn-complete') );?>
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
									'format' => __('Page {:page} of {:pages}, showing {:current} flash lotteries out of {:count}, starting on flash lottery {:start}, ending on {:end}')
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