<?php 
$ticketsCount = $lottery['Lottery']['nb_tickets'];
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
		<div class="media panel-heading panel-heading-lottery">
			<p class="pull-left">
				<img class="media-object" src="<?php echo $lottery['EveItem']['EveCategory']['url_start'].$lottery['EveItem']['eve_id'].$lottery['EveItem']['EveCategory']['url_big_end']; ?>" alt="<?php echo $lottery['EveItem']['name']; ?>">
			</p>
			<div class="media-body">
				<h3 class="media-heading"><?php echo $lottery['EveItem']['name']; ?></h3>
				<p><?php echo number_format($lottery['Lottery']['value']); ?> <span class="badge">ISK</span></p>
				<p><?php echo number_format($lottery['Ticket'][0]['value']); ?> <i class="fa fa-money"></i> / <i class="fa fa-ticket"></i></p>					
			</div>
		</div>
		<div class="panel-body panel-lot">
			<div class="row">
				<?php foreach ($lottery['Ticket'] as $ticket){
					echo $this->element('Lotteries/TicketPanel', array(
						"ticket" => $ticket,
						"eveItem" => $lottery['EveItem'],
						"ticketsCount" => $ticketsCount
						));
					}?>
				</div>
			</div>
		</div>
	</div>