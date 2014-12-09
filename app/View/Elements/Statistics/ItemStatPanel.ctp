<div class="media well well-sm" >
	<span class="pull-left">
		<img src="https://image.eveonline.com/Render/<?php echo $popularItem['eve_items']['eve_id']; ?>_64.png" /> 
	</span>
	<span>
		<h4><?php echo $popularItem['eve_items']['name']; ?></h4>
		<h4><?php echo number_format($popularItem['stat']['totalItems'], 0).' Items';?></h4>
	</span>
</div>