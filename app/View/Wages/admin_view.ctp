<div id="wrapper">
    <?php
    echo $this->element('ManagerMenu', array());
    ?>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="wages view">
                <h2><?php echo __('Wage'); ?></h2>
                <dl>
                    <dt><?php echo __('Id'); ?></dt>
                    <dd>
                        <?php echo h($wage['Wage']['id']); ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Recipient'); ?></dt>
                    <dd>
                        <?php echo $this->Html->link($wage['Recipient']['eve_name'], array('controller' => 'users', 'action' => 'view', $wage['Recipient']['id'])); ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Amount'); ?></dt>
                    <dd>
                        <?php echo h($wage['Wage']['amount']); ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Admin'); ?></dt>
                    <dd>
                        <?php echo $this->Html->link($wage['Admin']['eve_name'], array('controller' => 'users', 'action' => 'view', $wage['Admin']['id'])); ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Created'); ?></dt>
                    <dd>
                        <?php echo h($wage['Wage']['created']); ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Modified'); ?></dt>
                    <dd>
                        <?php echo h($wage['Wage']['modified']); ?>
                        &nbsp;
                    </dd>
                    <dt><?php echo __('Withdrawals Array'); ?></dt>
                    <dd>
                        <?php echo h($wage['Wage']['withdrawals_array']); ?>
                        &nbsp;
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>