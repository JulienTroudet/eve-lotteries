<div class="flash-lot">
	<div class="well well-sm <?php if($flashLottery['FlashLottery']['status']=='ongoing'){echo 'well-ongoing';}else{echo 'well-finished';}?>">
		<div class="row">
			<div class="col-md-2 col-sm-3">
				<img src="<?php echo $flashLottery['EveItem']['EveCategory']['url_start'].$flashLottery['EveItem']['eve_id'].$flashLottery['EveItem']['EveCategory']['url_big_end']; ?>" alt="<?php echo $flashLottery['EveItem']['name']; ?>">
			</div>
			<div class="col-md-10 col-sm-9">
				<h1>
					<?php echo $flashLottery['EveItem']['name'].' Flash Lottery !'?>
				</h1>
				<p>
					<?php echo $flashLottery['FlashLottery']['number_items']?>x <?php echo $flashLottery['EveItem']['name']; ?> to win !
				</p>
				<h3>
					<strong class="flash-countdown"></strong> , <?php echo $flashLottery['FlashLottery']['nb_bought']?> out of <?php echo $flashLottery['FlashLottery']['nb_tickets']?> tickets bought.
				</h3>
			</div>
		</div>
	</div>
</div>
<br/>
<br/>
<div id="flash-tickets-container">
	<?php foreach ($flashLottery['FlashTicket'] as $key => $flashTicket): ?>
		<?php echo $this->element('FlashLotteries/FlashTicketIcon', array("flashTicket" => $flashTicket)); ?>
	<?php endforeach; ?>
</div>

<div class="row">
	<div class="col-md-3 pull-right">
		<?php echo $this->Html->link('See all Flash lotteries', array('controller' => 'flash_lotteries', 'action' => 'index'), array('class' => 'btn btn-lg btn-block btn-primary') ); ?>
	</div>
</div>