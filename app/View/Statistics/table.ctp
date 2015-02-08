<?php
$this->Js->JqueryEngine->jQueryObject = 'jQuery';
$this->Paginator->options(array('update' => '#el-tansaction-pane', 'evalScripts' => true, ));?>

<table class="table table-striped table-condensed">
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('isk_value', __('Value'), array('url'=>array('controller'=>'statistics', 'action'=>'list_stats'))); ?></th>
			<th><?php echo $this->Paginator->sort('type', __('Type'), array('url'=>array('controller'=>'statistics', 'action'=>'list_stats'))); ?></th>
			<th><?php echo $this->Paginator->sort('created', __('Date'), array('url'=>array('controller'=>'statistics', 'action'=>'list_stats'))); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($player_stats as $player_stat): ?>
			<tr>
				<?php
				switch ($player_stat['Statistic']['type']) {
					case 'withdrawal_credits':
					$player_stat['Statistic']['type'] = 'Lottery Credits Prize';
					break;
					case 'buy_ticket':
					$player_stat['Statistic']['type'] = 'Ticket Bought';
					$player_stat['Statistic']['isk_value'] = $player_stat['Statistic']['isk_value']*-1;
					break;
					case 'sponsor_isk':
					$player_stat['Statistic']['type'] = 'Sponsoring Bonus';
					break;
				}

				
				?>
				<td><?php echo h($player_stat['Statistic']['isk_value']); ?>&nbsp;</td>
				<td><?php echo h($player_stat['Statistic']['type']); ?>&nbsp;</td>
				<td><?php echo h($player_stat['Statistic']['created']); ?>&nbsp;</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<div class="row">
	<div class="col-md-12">
		<ul class="pager">
			<li class="previous">
				<?php echo $this->Paginator->prev('Previous', array('url'=>array('controller'=>'statistics', 'action'=>'list_stats')), null, array('class' => 'prev disabled')); ?>
			</li>
			<li>
				<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>	
			</li>
			<li class="next">
				<?php echo $this->Paginator->next('Next', array('url'=>array('controller'=>'statistics', 'action'=>'list_stats')), null, array('class' => 'next disabled')); ?>
			</li>
		</ul>
	</div>
</div>

<?php echo $this->Js->writeBuffer();?>