<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));} 
	else{echo $this->element('VisitorNavbar', array());}?>
</div>

<div class="lotteries index">
	<h2>Won Lotteries</h2>

	
	<div id="list-lotteries">
		<div class="row">
			<?php foreach ($claimed_awards as $claimed_award){ echo $this->element('OldAwardPanel', array("claimed_award" => $claimed_award ));} ?>
		</div>		
	</div>

	<div class="row">
		<ul class="pager">
			<li class="previous">
				<?php echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled')); ?>
			</li>
			<li>
				<?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} of {:pages}, showing {:current} awards out of {:count}, starting on award {:start}, ending on {:end}') )); ?>	
			</li>
			<li class="next">
				<?php
				echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
				?>
			</li>
		</ul>
	</div>
</div>




