<div class="lotteries index">
	<h2><?php echo __('Lotteries'); ?></h2>

<div class="row">
	<?php foreach ($lotteries as $lottery){
		echo $this->element('LotteryPanel', array(
			"lottery" => $lottery
			));

		}?>
</div>
	

		
		<p>
			<?php
			echo $this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}, showing {:current} lotteries out of {:count}, starting on lottery {:start}, ending on {:end}')
				));
				?>	
			</p>
			<div class="paging">
				<?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
				?>
			</div>
		</div>
