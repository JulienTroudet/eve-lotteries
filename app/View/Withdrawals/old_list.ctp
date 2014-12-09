<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));} 
	else{echo $this->element('VisitorNavbar', array());}?>
</div>

<div class="awards index">
	<h2>My completed awards</h2>

	
	<div id="list-lotteries">
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
						<?php foreach ($completed_awards as $completed_award){?>
						<tr>
							<td>
								<?php echo $completed_award['Ticket']['Lottery']['name']; ?>
							</td>
							<td>
								<?php 
								switch ($completed_award['Withdrawal']['type']) {
									case 'award_credit':
									echo number_format($completed_award['Withdrawal']['value'], 2).' Credits';
									break;
									case 'award_isk':
									echo number_format($completed_award['Withdrawal']['value'], 2).' ISK';
									break;
									case 'award_item':
									echo 'Item';
									break;
								}
								?>
							</td>
							<td>
								<?php echo $completed_award['Withdrawal']['modified']; ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>		
	</div>

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




