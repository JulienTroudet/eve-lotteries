<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));} 
	else{echo '<h2>Want to play ? Log in with your EVE account !</h2>';}?>
</div>
<div class="superLotteries index">
	<h2><?php echo __('Super Lotteries'); ?></h2>
	
	<?php foreach ($superLotteries as $superLottery): ?>
		<?php if (isset($superLottery)){ echo $this->element('SuperLotteries/SuperLotteryPanel', array("superLottery" => $superLottery ));} ?>
	<?php endforeach; ?>
	
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
