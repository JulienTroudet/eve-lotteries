<div class="col-md-3 col-sm-12 ticket-old-col" id="ticket-<?php echo $ticket['id'];?>">
	<div class="ticket-old <?php if ($ticket['is_winner']){echo 'bg-success';}else{echo 'bg-danger';}?>" >
		<span><?php echo $ticket['position']+1; ?>. <span <?php if(strlen($ticket['User']['eve_name'])>25){echo 'style="font-size: 8px;"';} ?>><?php echo $ticket['User']['eve_name']; ?></span></span>
	</div>
</div>
