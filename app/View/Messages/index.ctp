<div id="user-navbar">
	<?php echo $this->element('UserNavbar', array("userGlobal" => $userGlobal)); ?>
</div>
<div class="messages index">
	<h2><?php echo __('Messages'); ?></h2>
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('status'); ?></th>
				<th><?php echo $this->Paginator->sort('title'); ?></th>
				<th><?php echo $this->Paginator->sort('body', 'Message'); ?></th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($messages as $message): ?>
				<tr>
					
					<td width="5%" align="center"><?php
						if ($message['Message']['status'] == "unread") {
							echo '<i class="fa fa-envelope"></i>'; 
						} 
						else{
							echo '<i class="fa fa-envelope-o"></i>'; 
						}
						?>
					</td>
					<td width="20%" ><?php echo h($message['Message']['title']); ?>&nbsp;</td>
					<td width="65%" ><?php echo h($message['Message']['body']); ?>&nbsp;</td>
					<td width="10%" >
						<?php echo $this->Html->link(__('View'), array(
							'controller' => $message['Message']['controller_name'], 'action' => $message['Message']['action_name'], 'admin' => false, $message['Message']['model_id'], '#' => $message['Message']['anchor_name']),
						array('class' => 'btn btn-xs btn-primary')
						); ?>
						<?php echo $this->Html->link(__('Delete'), array(
							'action' => 'delete', 'admin' => false, $message['Message']['id']),
						array('class' => 'btn btn-xs btn-danger')
						); ?>
					</td>

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
