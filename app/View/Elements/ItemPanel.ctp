

<div class="col-md-2 col-sm-3 item-panel" data-item-category="<?php echo $eveItem['EveItem']['eve_category_id']; ?>" data-item-name="<?php echo $eveItem['EveItem']['name']; ?>">
	<div class="well item-well">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-item">
				<img src="<?php echo $eveItem['EveCategory']['url_start'].$eveItem['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $eveItem['EveItem']['name']; ?>" data-toggle="tooltip" data-placement="top" title="In game value: <?php echo number_format($eveItem['EveItem']['eve_value'],0); ?> ISK">
			</div>
			<div class="col-md-6 col-sm-6 col-item">
				<button class="btn btn-xs btn-block btn-primary item-random-button" 
				data-item-id="<?php echo $eveItem['EveItem']['id']; ?>">Random</button>
				<button class="btn btn-xs btn-block btn-primary item-choice-button" 
				data-item-id="<?php echo $eveItem['EveItem']['id']; ?>"
				data-item-name="<?php echo $eveItem['EveItem']['name']; ?>"
				data-item-nbt="<?php echo $eveItem['EveItem']['nb_tickets_default']; ?>"
				data-ticket-price="<?php echo $eveItem['EveItem']['ticket_price']; ?>"
				data-item-price="<?php echo $eveItem['EveItem']['eve_value']; ?>">Choose</button>			
			</div>
		</div>
		<div class="row">

			<div class="col-md-8 col-sm-8 col-item">
				<?php echo number_format($eveItem['EveItem']['ticket_price'],0); ?> <i class="fa fa-money"></i>
			</div> 

			<div class="col-md-4 col-sm-4 col-item">
				<?php echo $eveItem['EveItem']['nb_tickets_default']; ?> <i class="fa fa-ticket"></i>
			</div>
		</div>
		<div>
			<h3 class="bg-default">
			<!-- font size change for large string-->
				<strong <?php if(strlen($eveItem['EveItem']['name'])>30){echo 'style="font-size: 0.75em;"';} ?>><?php echo $eveItem['EveItem']['name']; ?></strong>
			</h3>
		</div>
	</div>
</div>