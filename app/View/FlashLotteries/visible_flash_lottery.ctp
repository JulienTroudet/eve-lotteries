<div class="col-md-10 col-sm-10 col-md-offset-1 well well-sm <?php if($flashLottery['FlashLottery']['status']=='ongoing'){echo 'well-ongoing';}else{echo 'well-finished';}?>">
	<div class="row">
		<div class="col-md-1">
			<img src="<?php echo $flashLottery['EveItem']['EveCategory']['url_start'].$flashLottery['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $flashLottery['EveItem']['name']; ?>"
			data-toggle="tooltip"
			data-placement="right"
			title = "Prize: <?php echo $flashLottery['EveItem']['name'];?> x <?php echo $flashLottery['FlashLottery']['number_items']; ?>"
			>
		</div>
		<div class="col-md-9" id="flash-tickets-container">
			
			<?php foreach ($flashLottery['FlashTicket'] as $key => $ticket) :?>
			
			<?php echo $this->element('FlashLotteries/FlashTicketIcon', array("flashTicket" => $ticket )); ?>
			<?php endforeach; ?>
			
		</div>
		<div class="col-md-2">
			<?php if($flashLottery['FlashLottery']['status']=='ongoing'): ?>
			<div>
				<h3>Flash Lottery</h3>
				<p>End :</p>
			</div>
			<?php else: ?>
			<div class="media" >
				<span class="pull-right">
					<img src="https://image.eveonline.com/Character/<?php echo $flashLottery['Winner']['id']; ?>_64.jpg" />
				</span>
				<span>
					<p>Winner :</p>
					<p class="pull-right"><strong><?php echo $flashLottery['Winner']['eve_name']; ?></strong></p>
				</span>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>