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
						<?php foreach ($flashLotteries as $superLottery): ?>
						<tr>
							<td>
								<button class="btn btn-block btn-xs btn-warning" type="button" onclick="CCPEVE.buyType(<?php echo $superLottery['EveItem']['eve_id']; ?>)">Buy <?php echo $superLottery['EveItem']['name']; ?></button>
								<button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.createContract(1, 60003760, <?php echo $superLottery['EveItem']['eve_id']; ?>)">Create Exchange Contract</button>
							</td>
							<td><?php echo h($superLottery['FlashLottery']['number_items']); ?>&nbsp;</td>
							<td>
								
							</td>
							<td><?php echo h($superLottery['FlashLottery']['nb_tickets']); ?>&nbsp;</td>
							<td><?php echo h($superLottery['FlashLottery']['status']); ?>&nbsp;</td>
							<td><?php echo CakeTime::niceShort(h($superLottery['FlashLottery']['start_date'])); ?>&nbsp;</td>
							<td><?php echo CakeTime::niceShort(h($superLottery['FlashLottery']['expiration_date'])); ?>&nbsp;</td>
							<td class="actions">
								<?php if($superLottery['FlashLottery']['status'] == 'waiting'):?>
									<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', 'admin' => true, $superLottery['FlashLottery']['id']), array(), __('Are you sure you want to delete # %s?', $superLottery['FlashLottery']['id'])); ?>
								<?php elseif($superLottery['FlashLottery']['status'] == 'claimed'):?>
								<?php echo $this->Html->link(
									'Complete this',
									array('controller' => 'super_lotteries', 'action' => 'complete', 'admin'=>true, 'plugin' => false, $superLottery['FlashLottery']['id']),
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