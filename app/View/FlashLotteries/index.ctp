<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));} 
	else{echo '<h2>Want to play? Log in with your EVE account!</h2>';}?>
</div>
<div class="flashLotteries index">
	<h2><?php echo __('Flash Lotteries'); ?></h2>
	
	<?php foreach ($flashLotteries as $flashLottery): ?>
		<?php if (isset($flashLottery)){ echo $this->element('FlashLotteries/FlashLotteryPanel', array("flashLottery" => $flashLottery ));} ?>
	<?php endforeach; ?>
	
	<div class="row">
		<div class="col-md-12">
			<ul class="pager">
				<li class="previous">
					<?php echo $this->Paginator->prev('Previous', array(), null, array('class' => 'prev disabled')); ?>
				</li>
				<li>
					<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>	
				</li>
				<li class="next">
					<?php echo $this->Paginator->next('Next', array(), null, array('class' => 'next disabled')); ?>
				</li>
			</ul>
		</div>
	</div>
</div>