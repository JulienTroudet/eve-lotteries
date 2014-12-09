<div id="user-navbar">
	<?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>
<div class="messages index">
	<h2><?php echo __('Messages'); ?></h2>
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('status'); ?></th>
				<th><?php echo $this->Paginator->sort('title'); ?></th>
				<th><?php echo $this->Paginator->sort('body'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($messages as $message): ?>
				<tr>
					
					<td><?php echo h($message['Message']['status']); ?>&nbsp;</td>
					<td><?php echo h($message['Message']['title']); ?>&nbsp;</td>
					<td><?php echo h($message['Message']['body']); ?>&nbsp;</td>
					
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div class="row">
		<div class="col-md-12">
			<ul class="pager">
				<li class="previous">
					<?php echo $this->Paginator->prev('Previous', array(), null, array('class' => 'prev disabled')); ?>
				</li>
				<li>
					<?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}'))); ?>	
				</li>
				<li class="next">
					<?php echo $this->Paginator->next('Next', array(), null, array('class' => 'next disabled')); ?>
				</li>
			</ul>
		</div>
	</div>
</div>
