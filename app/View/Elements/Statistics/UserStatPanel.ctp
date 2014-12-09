<div class="media well well-sm" >
	<span class="pull-left">
		<img src="https://image.eveonline.com/Character/<?php echo $user['users']['id']; ?>_64.jpg" /> 
	</span>
	<span>
		<h4><?php echo $user['users']['eve_name']; ?></h4>
		<h4><?php 
		if(isset($user['stat']['totalIskAmount'])){
			echo number_format($user['stat']['totalIskAmount'], 2).' ISK'; 
		}
		else if(isset($user['stat']['totalWon'])){
			echo number_format($user['stat']['totalWon'], 0).' Lotteries'; 
		}
		else if(isset($user['stat']['totalItems'])){
			echo number_format($user['stat']['totalItems'], 0).' Items'; 
		}

		?></h4>
	</span>
</div>