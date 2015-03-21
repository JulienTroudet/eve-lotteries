<div class="col-md-10 col-sm-12 col-md-offset-1 well award">
	<div class="row">
		<div class="col-md-1">
			<?php if(isset($userAwards[$award['id']])): ?>
				<?php if($userAwards[$award['id']]['UserAward']['status'] == 'completed'): ?>
					<i class="text-success fa fa-3x fa-trophy"></i>
				<?php elseif($userAwards[$award['id']]['UserAward']['status'] == 'unclaimed'): ?>
					<i class="text-primary fa fa-3x fa-check-circle-o"></i>
				<?php endif; ?>
			<?php else: ?>
				<i class="text-danger fa fa-3x fa-times-circle-o"></i>
			<?php endif; ?>
		</div>

		<div class="col-md-4">
			<h3 class="title-award"><?php echo $award['name'];?></h3>
			<?php if(array_key_exists($award['id'] , $userProgress )):?>
				<div class="progress">
					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="<?php echo $userProgress[$award['id']]['goal']; ?>" style="width: <?php echo number_format(($userProgress[$award['id']]['result']/$userProgress[$award['id']]['goal'])*100,0); ?>%;">
						<?php echo $userProgress[$award['id']]['result']; ?>/<?php echo $userProgress[$award['id']]['goal']; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<div class="col-md-4">
			<?php echo $award['description'];?>
		</div>

		<div class="col-md-3">
			<?php if(isset($userAwards[$award['id']])): ?>
				<?php if($userAwards[$award['id']]['UserAward']['status'] == 'completed'): ?>
					<button class="btn btn-block btn-success" disabled>Claimed <strong><?php echo  number_format($award['award_credits'], 2);?> <i class="fa fa-money"></i></strong></button>
				<?php elseif($userAwards[$award['id']]['UserAward']['status'] == 'unclaimed'): ?>
					<?php 
					$label = 'Create lottery';

					echo $this->Html->link(
						'Claim <strong>'.number_format($award['award_credits'], 2).' <i class="fa fa-money"></i></strong>', 
						array('controller' => 'UserAwards', 'action' => 'claim', $userAwards[$award['id']]['UserAward']['id'], $tab),
						array(
							'class' => 'btn btn-block btn-success',
							'escape' => false,
							)
						);

						?>
					<?php endif; ?>
				<?php else: ?>
					<p class="award-value">Award :
						<strong><?php echo  number_format($award['award_credits'], 2);?> <i class="fa fa-money"></i></strong>
					</p>
				<?php endif; ?>


			</div>
		</div>
	</div>