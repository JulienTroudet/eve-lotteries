<?php 
$ticketsCount = $lottery['Lottery']['nb_tickets'];
if ($ticketsCount == 8) {
?>
<div class="col-md-2 col-sm-3">
<?php
}?>

<?php if ($ticketsCount == 16) {
?>
<div class="col-md-4 col-sm-6">
<?php
}?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="media-body">
				<h4 class="media-heading"><?php echo $lottery['EveItem']['name']; ?></h4>
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<?php foreach ($lottery['Ticket'] as $ticket){
					echo $this->element('TicketPanel', array(
						"ticket" => $ticket,
						"eveItem" => $lottery['EveItem'],
						"ticketsCount" => $ticketsCount
						));
					}?>
				</div>
			</div>
		</div>
	</div>