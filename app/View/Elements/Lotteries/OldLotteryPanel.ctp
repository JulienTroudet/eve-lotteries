<div class="col-md-12 col-sm-12">
	<div class="panel panel-default">
		<div class="row row-old-lot">
			<div class="col-md-4 col-sm-12">
				<div class="media">
					<a class="pull-left" href="#">
						<img class="media-object" src="https://image.eveonline.com/Render/<?php echo $lottery['EveItem']['eve_id']; ?>_64.png" alt="<?php echo $lottery['EveItem']['name']; ?>">
					</a>
					<div class="media-body">
						<h3 class="media-heading"><?php echo $lottery['EveItem']['name']; ?></h3>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-sm-12">
				<div class="row">
					<?php foreach ($lottery['Ticket'] as $ticket){echo $this->element('Lotteries/OldTicketPanel', array("ticket" => $ticket,));}?>
				</div>
			</div>
		</div>
	</div>
</div>



