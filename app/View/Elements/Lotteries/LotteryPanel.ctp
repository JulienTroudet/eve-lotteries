<?php if ($lottery['Lottery']['nb_tickets'] == 8) :?>
	<div class="col-md-4 col-sm-6">
	<?php endif; ?>

	<?php if ($lottery['Lottery']['nb_tickets'] == 16) :?>
		<div class="col-md-8 col-sm-12">
		<?php endif; ?>

		<?php if ($lottery['Lottery']['nb_tickets'] == 48) :?>
			<div class="col-md-12 col-sm-12">
			<?php endif; ?>

			<div class="panel panel-default">
				<div class="media panel-heading panel-heading-lottery">
					<p class="pull-left">
						<img 
						class="media-object" 
						src="<?php echo $lottery['EveItem']['EveCategory']['url_start'].$lottery['EveItem']['eve_id'].$lottery['EveItem']['EveCategory']['url_big_end']; ?>" 
						alt="<?php echo $lottery['EveItem']['name']; ?>">
					</p>
					<div class="media-body">
						<h3 class="media-heading"><?php echo $lottery['EveItem']['name']; ?></h3>
						<p><?php echo number_format($lottery['Lottery']['value']); ?> <span class="badge">ISK</span></p>
						<p><?php echo number_format($lottery['Ticket'][0]['value']); ?> <i class="fa fa-money"></i> / <i class="fa fa-ticket"></i></p>
						<?php 
						$user_tz = 'Europe/Paris';
						$schedule_date = new DateTime($lottery['Lottery']['created'], new DateTimeZone($user_tz) );
						$schedule_date->setTimeZone(new DateTimeZone('UTC'));
						$triggerOn =  $schedule_date->format('c');

						?>
						<p class="lot-timer" data-start="<?php echo $triggerOn; ?>"></p>
					</div>
				</div>
				<div class="panel-body panel-lot">
					<div class="row">
						<?php foreach ($lottery['Ticket'] as $ticket){
							echo $this->element('Lotteries/TicketPanel', array(
								"ticket" => $ticket,
								"eveItem" => $lottery['EveItem'],
								"ticketsCount" => $lottery['Lottery']['nb_tickets']
								));
							}?>
						</div>
					</div>
				</div>
			</div>