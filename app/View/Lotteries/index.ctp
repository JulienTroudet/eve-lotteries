<div class="lotteries index">
	<h2><?php echo __('Lotteries'); ?></h2>

	<div class="row">
		<?php foreach ($lotteries as $lottery){
			echo $this->element('LotteryPanel', array(
				"lottery" => $lottery
				));}
				?>
			</div>

			
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
							'format' => __('Page {:page} of {:pages}, showing {:current} lotteries out of {:count}, starting on lottery {:start}, ending on {:end}')
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
