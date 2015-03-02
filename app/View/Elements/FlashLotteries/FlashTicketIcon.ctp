<div class="flash-ticket flash-isotope">
<?php if(isset($flashTicket['Buyer']['id'])): ?>
	<img src="https://image.eveonline.com/Character/<?php echo $flashTicket['Buyer']['id']; ?>_64.jpg"
	data-toggle="tooltip"
	data-placement="right"
	title = "Ticket <?php echo $flashTicket['position']; ?>: <?php echo $flashTicket['Buyer']['eve_name']; ?>"
	<?php if ($flashTicket['Buyer']['id'] == $userGlobal['id']) {
		echo 'class="flash-ticket-user"';
	}?>
	>
<?php else: ?>
	<span class="fa-stack fa-2x">
	<i 
	class="buy-flash fa fa-ticket fa-stack-2x"
	data-id="<?php echo $flashTicket['id']; ?>"
	data-toggle="tooltip"
	data-placement="right"
	title = "1 point"
	></i>
	<strong class="fa fa-stack-1x flash-number"><?php echo $flashTicket['position']; ?></strong>
	</span>
<?php endif; ?>
</div>