<div id="user-navbar">
    <?php if ($userGlobal != null) { echo $this->element('UserNavbar', array("userGlobal" => $userGlobal));}?>
</div>
<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="wages index">
            <h2><?php echo __('Wages'); ?></h2>
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('amount'); ?></th>
                    <th><?php echo $this->Paginator->sort('created', 'Date'); ?></th>
                    <th><?php echo $this->Paginator->sort('status'); ?></th>
                    <th class="actions"><?php echo __('Actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($wages as $wage): ?>
                    <tr>

                        <td><?php echo h(number_format($wage['Wage']['amount'], 2).' ISK'); ?>&nbsp;</td>

                        <td><?php echo h($wage['Wage']['created']); ?>&nbsp;</td>
                        <td><?php echo h($wage['Wage']['status']); ?>&nbsp;</td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('View'), array('action' => 'view', $wage['Wage']['id'])); ?>
                            <?php if($wage['Wage']['status'] == 'unclaimed'){echo $this->Html->link(__('Claim'), array('action' => 'claim', $wage['Wage']['id']));} ?>
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
