<div class="flash-ticket">
<?php if(isset($flashTicket['Buyer']['id'])): ?>
	<img src="https://image.eveonline.com/Character/<?php echo $flashTicket['Buyer']['id']; ?>_32.jpg">
<?php else: ?>
	<i 
	style="height:32px; width:32px; text-align:center; vertical-align:text-top;" class="buy-flash fa fa-ticket fa-2x"
	data-id="<?php echo $flashTicket['id']; ?>"
	data-toggle="tooltip"
	data-placement="right"
	title = "1 point"
	></i>
<?php endif; ?>
</div>