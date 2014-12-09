

<div class="col-md-2 col-sm-3 item-panel" data-item-category="<?php echo $eveItem['EveItem']['eve_category_id']; ?>" data-item-name="<?php echo $eveItem['EveItem']['name']; ?>">
	<button class="btn btn-default btn-block item-button" data-item-id="<?php echo $eveItem['EveItem']['id']; ?>">
		<p>
				<img src="https://image.eveonline.com/Render/<?php echo $eveItem['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $eveItem['EveItem']['name']; ?>">
			<?php echo $eveItem['EveItem']['nb_tickets_default']; ?> <span class="badge">Tickets</span>
			
		</p>
		<p>
			<?php echo number_format($eveItem['EveItem']['ticket_price'],0); ?> <span class="badge">ISK</span>
		</p>
		<h3 class="bg-success">
		<?php echo $eveItem['EveItem']['name']; ?>
		</h3>
	</button>
</div>