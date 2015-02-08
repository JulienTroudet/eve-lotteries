<?php
$this->Js->JqueryEngine->jQueryObject = 'jQuery';
$this->Paginator->options(array('update' => '#in-game-pane', 'evalScripts' => true, ));?>

<table class="table table-striped table-condensed">
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('amount', __('Amount'), array('url'=>array('action'=>'list_transactions'))); ?></th>
			<th><?php echo $this->Paginator->sort('eve_date', __('EVE Date'), array('url'=>array('action'=>'list_transactions'))); ?></th>
			<th><?php echo $this->Paginator->sort('created', __('Date'), array('url'=>array('action'=>'list_transactions'))); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($transactions as $transaction): ?>
			<tr>
				<td><?php echo h($transaction['Transaction']['amount']); ?>&nbsp;</td>
				<td><?php echo h($transaction['Transaction']['eve_date']); ?>&nbsp;</td>
				<td><?php echo h($transaction['Transaction']['created']); ?>&nbsp;</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<div class="row">
	<div class="col-md-12">
		<ul class="pager">
			<li class="previous">
				<?php echo $this->Paginator->prev('Previous', array('url'=>array('action'=>'list_transactions')), null, array('class' => 'prev disabled')); ?>
			</li>
			<li>
				<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>	
			</li>
			<li class="next">
				<?php echo $this->Paginator->next('Next', array('url'=>array('action'=>'list_transactions')), null, array('class' => 'next disabled')); ?>
			</li>
		</ul>
	</div>
</div>

<?php echo $this->Js->writeBuffer();?>