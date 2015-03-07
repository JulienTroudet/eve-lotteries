<?php if(isset($flashLottery['FlashLottery'])):?>
	<div class="row flash-lot">
		<div class="col-md-10 col-sm-12 col-md-offset-1 well well-sm <?php if($flashLottery['FlashLottery']['status']=='unclaimed'){echo 'well-unclaimed';}else if($flashLottery['FlashLottery']['status']=='claimed'){echo 'well-claimed';}else{echo 'well-finished';}?>">
			<div class="row">
				<div class="col-md-1">
					<img src="<?php echo $flashLottery['EveItem']['EveCategory']['url_start'].$flashLottery['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $flashLottery['EveItem']['name']; ?>">
				</div>

				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							<h3>
								<?php echo $this->Html->link(
								$flashLottery['EveItem']['name'].' Flash Lottery ! <strong class="flash-countdown"></strong>', 
								array('controller' => 'flash_lotteries', 'action' => 'view', 'admin'=>false, 'plugin' => false, $flashLottery['FlashLottery']['id']),
								array('escape' => false)
								);?>
							</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5">
							<p>Prize : <strong><?php echo $flashLottery['EveItem']['name']; ?> X <?php echo $flashLottery['FlashLottery']['number_items']; ?></strong></p>
						</div>

						<div class="col-md-7">
							<p>Started : <?php echo CakeTime::niceShort(h($flashLottery['FlashLottery']['start_date'])); ?></p>
							<p>Ended : <?php echo CakeTime::niceShort(h($flashLottery['FlashLottery']['expiration_date'])); ?></p>
						</div>

					</div>
				</div>
				<div class="col-md-3">
					<?php if($flashLottery['FlashLottery']['status']=='unclaimed'): ?>
						<div class="form">
							<button class="btn btn-block btn-default btn-flash-claim" data-flash-lottery-id="<?php echo $flashLottery['FlashLottery']['id']; ?>">Claim this flash Lottery</button>
						</div>
					<?php elseif($flashLottery['FlashLottery']['status']=='claimed') : ?>
						<button class="btn btn-block btn-default btn-claim btn-claim-credits" disabled>Flash Lottery Claimed</button>
					<?php else: ?>
						<p>Flash Lottery Completed. The items have been contracted to you.</p>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>
<?php endif; ?>
