<?php if ($ticketsCount == 8) : ?>
	<div  class="col-md-6 col-sm-12 ticket-slot" id="ticket-<?php echo $ticket['id'];?>">
	<?php endif; ?>

	<?php if ($ticketsCount == 16) : ?>
		<div class="col-md-3 col-sm-6 ticket-slot" id="ticket-<?php echo $ticket['id'];?>">
		<?php endif; ?>

		<?php if ($ticketsCount == 48) : ?>
			<div class="col-md-1 col-sm-3 ticket-slot" id="ticket-<?php echo $ticket['id'];?>">
			<?php endif; ?>


			<?php if ($ticket['buyer_user_id'] == null):?>

				<button 
				data-ticket-id="<?php echo $ticket['id'];?>" 
				data-item-name="<?php echo $eveItem['name'];?>" 
				class="btn btn-block btn-primary buy-ticket"
				data-toggle="tooltip" 
				data-placement="top" 
				title="<?php echo number_format($ticket['value']); ?> Credits">
				<?php echo $ticket['position']+1;?>. Buy this ticket
			</button>

		<?php endif; ?>	


		<?php if ($ticket['buyer_user_id'] != null):?>
			<div class="media well well-sm <?php if ($ticket['is_winner']){echo 'winner-ticket';}?>" >
				<span <?php if ($ticketsCount != 48) : ?>class="pull-left"<?php endif; ?>>
					<img 
					class="ticket-img" 
					src="https://image.eveonline.com/Character/<?php echo $ticket['User']['id']; ?>_64.jpg" 
					<?php if ($ticketsCount == 48) : ?>data-toggle="tooltip" 
						data-placement="top" 
						title="<?php echo $ticket['User']['eve_name']; ?>"><?php endif; ?>
						/> 
					</span>
					<span <?php if(strlen($ticket['User']['eve_name'])>25){echo 'style="font-size: 8px;"';} ?>>
						<?php echo $ticket['User']['eve_name']; ?>
					</span>
				</div>
			<?php endif; ?>		
		</div>
