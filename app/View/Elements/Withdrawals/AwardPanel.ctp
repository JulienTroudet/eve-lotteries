<div class="col-md-4 col-sm-6">
	<div class="panel panel-default">
		<div class="media panel-heading">
			<p class="pull-left">
				<img class="media-object" src="<?php echo $unclaimed_award['Ticket']['Lottery']['EveItem']['EveCategory']['url_start'].$unclaimed_award['Ticket']['Lottery']['EveItem']['eve_id'].$unclaimed_award['Ticket']['Lottery']['EveItem']['EveCategory']['url_big_end']; ?>" alt="<?php echo $unclaimed_award['Ticket']['Lottery']['EveItem']['name']; ?>">
			</p>
			<div class="media-body">
				<h3 class="media-heading"><?php echo $unclaimed_award['Ticket']['Lottery']['name']; ?></h3>
				<p><?php echo number_format($unclaimed_award['Ticket']['Lottery']['value']); ?> <span class="badge">ISK</span></p>
			</div>
		</div>
		<div class="panel-body panel-body-won-lot">
			<?php switch ($unclaimed_award['Withdrawal']['status']) {
				case 'new':
				?>
				<button class="btn btn-block btn-lg btn-default btn-claim btn-claim-credits" data-toggle="tooltip" data-placement="top" title="5% bonus if you claim this awward as EVE-Lotteries Credits"
				data-award-id="<?php echo number_format($unclaimed_award['Withdrawal']['id']); ?>"
				data-claim-type="credit"
				>Claim <?php echo number_format($unclaimed_award['Ticket']['Lottery']['value']*1.05, 2); ?> <i class="fa fa-money"></i></button>

				<button class="btn btn-block btn-lg btn-default btn-claim btn-claim-isk"
				data-award-id="<?php echo number_format($unclaimed_award['Withdrawal']['id'], 2); ?>"
				data-claim-type="isk"
				>Claim <?php echo number_format($unclaimed_award['Ticket']['Lottery']['value'], 2); ?> <span class="badge">ISK</span></button>

				<button class="btn btn-block btn-lg btn-default btn-claim btn-claim-item"
				data-award-id="<?php echo number_format($unclaimed_award['Withdrawal']['id'], 2); ?>"
				data-claim-type="item"
				>Claim <?php echo preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$unclaimed_award['Ticket']['Lottery']['name']); ?></button>
				<?php
				break;
				case 'claimed':
				case 'reserved':
				switch ($unclaimed_award['Withdrawal']['type']) {
					case 'award_isk':
					?>
					<button class="btn btn-block btn-lg btn-success btn-claim-isk" disabled>Claimed <?php echo number_format($unclaimed_award['Ticket']['Lottery']['value'], 2); ?> <span class="badge">ISK</span></button>
					<p class="well well-sm">Our staff members will deliver your award as soon as possible.</p>
					<?php
					break;
					case 'award_item':
					?>
					<button class="btn btn-block btn-lg btn-success btn-claim-item" disabled>Claimed <?php echo preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$unclaimed_award['Ticket']['Lottery']['name']); ?></button>
					<p class="well well-sm">Our staff members will deliver your award as soon as possible. Dont forget to check your contracts.</p>
					<?php
				}
				break;
				case 'completed':
				switch ($unclaimed_award['Withdrawal']['type']) {
					case 'award_isk':
					?>
					<button class="btn btn-block btn-lg btn-default btn-claim-isk" disabled>Claimed <?php echo number_format($unclaimed_award['Ticket']['Lottery']['value'], 2); ?> <span class="badge">ISK</span></button>
					<p class="well well-sm">Our staff have delivered your award.</p>
					<?php
					break;
					case 'award_item':
					?>
					<button class="btn btn-block btn-lg btn-default btn-claim-item" disabled>Claimed <?php echo preg_replace('/(^| )a ([aeiouAEIOU])/', '$1an $2', 'a '.$unclaimed_award['Ticket']['Lottery']['name']); ?></button>
					<p class="well well-sm">Our staff have delivered your award. Please check your contracts.</p>
					<?php
					break;
					case 'award_credit':
					?>
					<button class="btn btn-block btn-lg btn-default btn-claim-isk" disabled>Claimed <?php echo number_format($unclaimed_award['Ticket']['Lottery']['value']*1.05, 2); ?> <i class="fa fa-money"></i></button>
					<p class="well well-sm">You have claimed this award as EVE-Lotteries credits.</p>
					<?php
					break;
				}
				break;
				default:
				break;
			}
			?>
			
		</div>
	</div>
</div>
<script>
	$('.btn-claim-credits').tooltip({
		container: 'body'
	})
</script>