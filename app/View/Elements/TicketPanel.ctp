<?php
if(isset($ticket['buyer_user_id']))
{
	?>
	<div class="col-md-6 col-sm-12 ticket-slot">
		<div class="media">
			<a class="pull-left" href="#">
				<img src="https://image.eveonline.com/Character/<?php echo $ticket['position']; ?>_32.jpg" />
			</a>
			<div class="media-body">
				<?php echo $ticket['position']; ?> <?php echo $ticket['position']; ?>
			</div>
		</div>
	</div>
	<?php
}
else
{

	if ($ticketsCount == 8) {
		?>
		<div class="col-md-6 col-sm-12 ticket-slot">
			<?php
		}?>

		<?php if ($ticketsCount == 16) {
			?>
			<div class="col-md-3 col-sm-6 ticket-slot">
				<?php
			}?>

			<?php
			echo $this->Html->link(
				($ticket['position']+1).'. Buy this ticket', 
				array('controller' => 'tickets', 'action' => 'buy', $ticket['id']),
				array('class' => 'btn btn-block btn-primary')
				);
				?>
			</div>
			<?php
		}
		?>