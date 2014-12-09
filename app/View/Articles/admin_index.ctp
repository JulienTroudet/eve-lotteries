<div id="wrapper">
	<?php 
	if ($userGlobal['group_id'] == 3) {
		echo $this->element('ModeratorMenu', array());
	}
	?>
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="articles index">
				<h2><?php echo __('Articles'); ?></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('title'); ?></th>
							<th><?php echo $this->Paginator->sort('body'); ?></th>
							<th><?php echo $this->Paginator->sort('creator_user_id'); ?></th>
							<th><?php echo $this->Paginator->sort('created'); ?></th>
							<th><?php echo $this->Paginator->sort('modified'); ?></th>
							<th class="actions"><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($articles as $article): ?>
							<tr>
								<td><?php echo h($article['Article']['title']); ?>&nbsp;</td>
								<td><?php echo h($article['Article']['body']); ?>&nbsp;</td>
								<td>
									<?php echo $this->Html->link($article['User']['eve_name'], array('controller' => 'users', 'action' => 'view', $article['User']['id'])); ?>
								</td>
								<td><?php echo h($article['Article']['created']); ?>&nbsp;</td>
								<td><?php echo h($article['Article']['modified']); ?>&nbsp;</td>
								<td class="actions">
									<?php echo $this->Html->link(__('View'), array('action' => 'view', 'admin' => true, $article['Article']['id'])); ?>
									<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', 'admin' => true, $article['Article']['id'])); ?>
									<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', 'admin' => true, $article['Article']['id']), array(), __('Are you sure you want to delete # %s?', $article['Article']['id'])); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="row">
					<ul class="pager">
						<li class="previous">
							<?php
							echo $this->Paginator->prev('< ' . __('Previous'), array(), null, array('class' => 'prev disabled'));
							?>
						</li>
						<li>
							<?php
							echo $this->Paginator->counter(array(
								'format' => __('Page {:page} of {:pages}, showing {:current} Articles out of {:count}, starting on article {:start}, ending on {:end}')
								));
								?>	
							</li>
							<li class="next">
								<?php
								echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
								?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
