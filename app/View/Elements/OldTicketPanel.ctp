<?php if ($ticketsCount == 8) { ?>
<div  class="col-md-12 col-sm-12" id="ticket-<?php echo $ticket['id'];?>">
	<?php } ?>

	<?php if ($ticketsCount == 16) { ?>
	<div class="col-md-6 col-sm-12" id="ticket-<?php echo $ticket['id'];?>">
		<?php }?>

		<div class="ticket-old <?php if ($ticket['is_winner']){echo 'bg-primary';}else{echo 'bg-danger';}?>" >
				<span><?php echo $ticket['position']+1; ?>. <?php echo $ticket['User']['eve_name']; ?></span>
		</div>
	</div>
