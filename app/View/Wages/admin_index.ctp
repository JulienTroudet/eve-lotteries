<div id="wrapper">
    <?php
    echo $this->element('ManagerMenu', array());
    ?>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="wages index">
                <h2><?php echo __('Wages'); ?></h2>
                <table class="table table-striped table-condensed">
                    <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('recipient_id'); ?></th>
                        <th><?php echo $this->Paginator->sort('amount'); ?></th>
                        <th><?php echo $this->Paginator->sort('admin_id'); ?></th>
                        <th><?php echo $this->Paginator->sort('created'); ?></th>
                        <th><?php echo $this->Paginator->sort('modified'); ?></th>
                        <th><?php echo $this->Paginator->sort('withdrawals_array'); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($wages as $wage): ?>
                        <tr>
                            <td>
                                <?php echo $this->Html->link($wage['Recipient']['eve_name'], array('controller' => 'users', 'action' => 'view', $wage['Recipient']['id'])); ?>
                            </td>
                            <td><?php echo h($wage['Wage']['amount']); ?>&nbsp;</td>
                            <td>
                                <?php echo $this->Html->link($wage['Admin']['eve_name'], array('controller' => 'users', 'action' => 'view', $wage['Admin']['id'])); ?>
                            </td>
                            <td><?php echo h($wage['Wage']['created']); ?>&nbsp;</td>
                            <td><?php echo h($wage['Wage']['modified']); ?>&nbsp;</td>
                            <td><?php echo h($wage['Wage']['withdrawals_array']); ?>&nbsp;</td>
                            <td class="actions">
                                <?php echo $this->Html->link(__('View'), array('action' => 'view', $wage['Wage']['id'])); ?>
                                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $wage['Wage']['id'])); ?>
                                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $wage['Wage']['id']), array(), __('Are you sure you want to delete # %s?', $wage['Wage']['id'])); ?>
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
        </div>
    </div>
</div>