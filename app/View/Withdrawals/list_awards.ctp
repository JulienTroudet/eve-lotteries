<h2>Unclaimed Awards</h2>
<div class="row">
	<?php foreach ($unclaimed_awards as $unclaimed_award){ echo $this->element('AwardPanel', array("unclaimed_award" => $unclaimed_award ));} ?>
</div>
<div class="row">
	<ul class="pager">
		<li class="previous">
			<?php echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled')); ?>
		</li>
		<li>
			<?php echo $this->Paginator->counter(array( 'format' => __('Page {:page} of {:pages}, showing {:current} waiting awards out of {:count}, starting on award {:start}, ending on {:end}') )); ?>	
		</li>
		<li class="next">
			<?php
			echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</li>
	</ul>
</div>
<h2>Last Claimed Awards</h2>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Lottery Item</th>
					<th>Claimed as</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($claimed_awards as $claimed_award){?>
				<tr>
					<td>
						<?php echo $claimed_award['Ticket']['Lottery']['name']; ?>
					</td>
					<td>
						<?php 
						switch ($claimed_award['Withdrawal']['type']) {
							case 'award_credit':
							echo number_format($claimed_award['Withdrawal']['value'], 2).' Credits';
							break;
							case 'award_isk':
							echo number_format($claimed_award['Withdrawal']['value'], 2).' ISK';
							break;
							case 'award_item':
							echo 'Item';
							break;
						}
						?>
					</td>
					<td>
						<?php echo $claimed_award['Withdrawal']['modified']; ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	
</div>
<div class="pull-right">
	<?php echo $this->Html->link('See all my claimed awards', array('controller' => 'withdrawals', 'action' => 'old_list'), array('class' => 'btn btn-lg btn-primary') ); ?>
</div>