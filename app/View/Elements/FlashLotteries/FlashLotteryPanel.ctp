<?php if(isset($flashLottery['FlashLottery'])):?>
	<div class="row flash-lot">
		<div class="col-md-10 col-sm-12 col-md-offset-1 well well-sm <?php if($flashLottery['FlashLottery']['status']=='ongoing'){echo 'well-ongoing';}else{echo 'well-finished';}?>">
			<div class="row">
				<div class="col-md-1 col-sm-2">
					<img src="<?php echo $flashLottery['EveItem']['EveCategory']['url_start'].$flashLottery['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $flashLottery['EveItem']['name']; ?>">
				</div>

				<div class="col-md-8 col-sm-6">
					<div class="row">
						<div class="col-md-12  col-flash-panel">
							<h3><?php echo $this->Html->link(
								' Flash Lottery ! <strong class="flash-countdown"></strong>', 
								array('controller' => 'flash_lotteries', 'action' => 'view', 'admin'=>false, 'plugin' => false, $flashLottery['FlashLottery']['id']),
								array('escape' => false)
								);?>
							</h3>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-flash-panel">
							
							<p>Prize : <strong><?php echo $flashLottery['EveItem']['name']; ?> X <?php echo $flashLottery['FlashLottery']['number_items']; ?></strong></p>
						</div>

						<div class="col-md-4 col-flash-panel">
							
							<p><?php echo $flashLottery['FlashLottery']['nb_bought']?> out of <?php echo $flashLottery['FlashLottery']['nb_tickets']?> tickets bought.</p>
						</div>

						<div class="col-md-4 col-flash-panel">
							<p><?php echo CakeTime::niceShort(h($flashLottery['FlashLottery']['start_date'])); ?> - <?php echo CakeTime::niceShort(h($flashLottery['FlashLottery']['expiration_date'])); ?></p>
						</div>

					</div>
				</div>
				<div class="col-md-3 col-sm-4">
					<?php if($flashLottery['FlashLottery']['status']=='ongoing'): ?>
						<div>
							<?php 
								$flashLabel = 'Buy my Ticket';
								foreach ($flashLottery['FlashTicket'] as $key => $ticket) {

									if(isset($ticket['Buyer']['id']) && $ticket['Buyer']['id'] == $userGlobal['id']){
										$flashLabel = 'Ticket Bought <i class="fa fa-thumbs-up"></i>';
										break;
									}
								}
								?>

							<?php echo $this->Html->link(
								$flashLabel,
								array('controller' => 'flash_lotteries', 'action' => 'view', 'admin'=>false, 'plugin' => false, $flashLottery['FlashLottery']['id']),
								array(
									'class' => 'btn btn-primary btn-block',
									'escape'=> false,
									)
								);?>

						</div>
					<?php else: ?>
						<div class="media" >
							<?php if(isset($flashLottery['Winner']['id'])): ?>
							<span class="pull-right">
								<img src="https://image.eveonline.com/Character/<?php echo $flashLottery['Winner']['id']; ?>_64.jpg" /> 
							</span>
							<span>
								<h3>Winner :</h3>
								<p class="pull-right"><strong><?php echo $flashLottery['Winner']['eve_name']; ?></strong></p>
							</span>
						<?php else: ?>
							<span>
								<h3>No Winner for this Flash Lottery</h3>
							</span>
						<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>
	</div>
	<?php if(isset($timestamp_flash_lotteries)) :?>
	<input type="hidden" id="timestamp-flash-lotteries" value="<?php echo $timestamp_flash_lotteries; ?>"/>
	<?php endif; ?>
<?php endif; ?>