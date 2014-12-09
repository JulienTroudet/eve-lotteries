<?php if ($ticketsCount == 8) { ?>
<div  class="col-md-6 col-sm-12 ticket-slot" id="ticket-<?php echo $ticket['id'];?>">
	<?php } ?>

	<?php if ($ticketsCount == 16) { ?>
	<div class="col-md-3 col-sm-6 ticket-slot" id="ticket-<?php echo $ticket['id'];?>">
		<?php }?>
		<?php if ($ticket['buyer_user_id'] == null){?>
		<button data-ticket-id="<?php echo $ticket['id'];?>" data-item-name="<?php echo $eveItem['name'];?>" class="btn btn-block btn-primary buy-ticket"><?php echo $ticket['position']+1;?>. Buy this ticket</button>
		<?php } ?>	
		<?php if ($ticket['buyer_user_id'] != null){?>
		<div class="media well well-sm" >
			<span class="pull-left">
				<img src="https://image.eveonline.com/Character/<?php echo $ticket['User']['eve_id']; ?>_64.jpg" /> 
			</span>
			<span>
				<?php echo $ticket['User']['username']; ?>
			</span>
		</div>
		<?php  }?>		
	</div>
