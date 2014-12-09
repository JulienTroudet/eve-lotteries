<?php 
$ticketsCount = count($lottery['Ticket']);
if ($ticketsCount == 8) {
?>
<div class="col-md-4 col-sm-6">
<?php
}?>

<?php if ($ticketsCount == 16) {
?>
<div class="col-md-8 col-sm-12">
<?php
}?>

	<div class="panel panel-default">
		<div class="media panel-heading">
			<p class="pull-left">
				<img class="media-object" src="https://image.eveonline.com/Render/<?php echo $lottery['EveItem']['eve_id']; ?>_128.png" alt="<?php echo $lottery['EveItem']['name']; ?>">
			</p>
			<div class="media-body">
				<h3 class="media-heading"><?php echo $lottery['EveItem']['name']; ?></h3>
				<p>Value : <?php echo number_format($lottery['EveItem']['eve_value']); ?> ISK</p>
				<p>Price/Ticket : <?php echo number_format($lottery['Ticket'][0]['value']); ?> ISK</p>					
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<?php foreach ($lottery['Ticket'] as $ticket){
					echo $this->element('TicketPanel', array(
						"ticket" => $ticket,
						"ticketsCount" => $ticketsCount
						));
					}?>
				</div>
			</div>
		</div>
	</div>