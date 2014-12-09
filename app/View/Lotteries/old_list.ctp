<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>

<div class="lotteries index">
	<h2>Won Lotteries</h2>

	
	<div id="list-lotteries">
		<div class="row">
			<?php foreach ($old_lotteries as $lottery){ echo $this->element('Lotteries/LotteryPanel', array(
			"lottery" => $lottery ));} ?>
		</div>		
	</div>

	<div class="row">
		<ul class="pager">
			<li class="previous">
				<?php echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled')); ?>
			</li>
			<li>
				<?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} of {:pages}, showing {:current} lotteries out of {:count}, starting on lottery {:start}, ending on {:end}') )); ?>	
			</li>
			<li class="next">
				<?php
				echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
				?>
			</li>
		</ul>
	</div>
</div>




