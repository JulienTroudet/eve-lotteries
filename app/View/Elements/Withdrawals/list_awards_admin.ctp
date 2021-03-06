<div class="row">
	<div class="col-md-12">
		<table class="table table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Date</th>
					<th>Claimed as</th>
					<th>Player</th>
					<th>Actions</th>
					<th>Complete</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($claimed_awards as $claimed_award){?>
				<tr>
					<td><img src="https://image.eveonline.com/Character/<?php echo $claimed_award['User']['id']; ?>_32.jpg"></td>
					<td>
						<?php echo $claimed_award['Withdrawal']['modified']; ?>
					</td>
					<td>
						<?php 
						switch ($claimed_award['Withdrawal']['type']) {
							case 'award_isk':
							echo $claimed_award['Withdrawal']['total_value'].' <br/>';
							echo number_format($claimed_award['Withdrawal']['total_value'], 2).' ISK';
							break;
							case 'award_item':
							echo $claimed_award['Ticket']['Lottery']['name'];
							break;
						}
						?>
					</td>
					<td>
						<?php echo $claimed_award['User']['eve_name']; ?>
						<!--<button type="button" onclick="window.prompt('Copy to clipboard: Ctrl+C, Enter', '<?php echo $claimed_award['User']['eve_name']; ?>');"><?php echo $claimed_award['User']['eve_name']; ?></button>-->
						
					</td>
					<td >
						<?php 
						switch ($claimed_award['Withdrawal']['type']) {
							case 'award_isk':
							?>
							<button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.showInfo(1377, <?php echo $claimed_award['User']['id']; ?>)"><?php echo $claimed_award['User']['eve_name']; ?></button>
							<?php
							break;
							case 'award_item':
							?>
							<button class="btn btn-block btn-xs btn-warning" type="button" onclick="CCPEVE.buyType(<?php echo $claimed_award['Ticket']['Lottery']['EveItem']['eve_id']; ?>)">Buy <?php echo $claimed_award['Ticket']['Lottery']['name']; ?></button>
							<button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.createContract(1, 60003760, <?php echo $claimed_award['Ticket']['Lottery']['EveItem']['eve_id']; ?>)">Create Exchange Contract</button>
							<?php
							break;
							
						}
						?>

						
						
					</td>
					<td>


						<?php if((isset($claimed_award['Withdrawal']['admin_id']) && $claimed_award['Withdrawal']['admin_id'] == $userGlobal['id']) || empty($claimed_award['Withdrawal']['admin_id'])):?>
							<button class="btn btn-block btn-warning btn-xs btn-reserve" type="button" data-award-id-group="<?php echo $claimed_award['Withdrawal']['group_id']; ?>" <?php if(isset($claimed_award['Withdrawal']['admin_id'])){echo'disabled';}?>>Reserve this</button>
						<button class="btn btn-block btn-danger btn-xs btn-complete" type="button" data-award-id-group="<?php echo $claimed_award['Withdrawal']['group_id']; ?>" <?php if(!isset($claimed_award['Withdrawal']['admin_id'])){echo'disabled';}?>>Complete this</button>
						<?php else:?>
							Reserved by another admin <br/>
							(id : <?php echo $claimed_award['Withdrawal']['admin_id']; ?>)
						<?php endif;?>
						
					</td>
					
				</tr>
				<?php } ?>
			</tbody>
		</table>
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