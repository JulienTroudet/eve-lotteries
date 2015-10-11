<div id="wrapper">
    <?php
    echo $this->element('ManagerMenu', array());
    ?>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="wages index">
                <h2><?php echo __('Wages'); ?></h2>
                <div id="list-awards">
                    <div class="well">
                        <div class="row">
                            <div class="col-md-2 col-xs-12">
                                <div class="btn-group-vertical btn-block" role="group" aria-label="...">
                                    <?php echo $this->Html->link(
                                        'Reserve',
                                        array('controller' => 'Wages', 'action' => 'reserve_one', 'admin'=>true, 'plugin' => false),
                                        array('class' => 'btn btn-group btn-lg btn-primary')
                                    );?>
                                    <?php echo $this->Html->link(
                                        'Cancel booking',
                                        array('controller' => 'Wages', 'action' => 'cancel_reservation', 'admin'=>true, 'plugin' => false),
                                        array('class' => 'btn btn-group btn-xs btn-danger ')
                                    );?>
                                </div>
                            </div>
                            <div class="col-md-10 col-xs-12">
                                <div>
                                    <?php
                                    echo $this->Form->create(
                                        'Wage',
                                        array(
                                            'url' => array(
                                                'controller' => 'Wages',
                                                'action' => 'complete'
                                            ),
                                            'class' => 'row',
                                            'role' => 'form'
                                        ));
                                    ?>
                                    <div class="col-md-10 col-xs-12">
                                        <?php
                                        echo $this->Form->input(
                                            'ingame_confirmation',
                                            array(
                                                'div' => array(
                                                    'class' => 'form-group'
                                                ),
                                                'placeholder' => false,
                                                'label' => false,
                                                'class' => 'form-control',
                                                'autocomplete' => "off"
                                            )
                                        );
                                        if(!empty($reserved_wage)){
                                            echo $this->Form->input(
                                                'withdrawal_id',
                                                array(
                                                    'div' => false,
                                                    'placeholder' => false,
                                                    'label' => false,
                                                    'class' => 'form-control',
                                                    'type' => 'hidden',
                                                    'value'=> $reserved_wage['Wage']['id']
                                                )
                                            );
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-2 col-xs-12">
                                        <?php
                                        $optionsFormLogin = array(
                                            'label' => 'Complete',
                                            'div' => false,
                                            'class' => 'btn btn-success'
                                        );
                                        echo $this->Form->end($optionsFormLogin);
                                        ?>

                                    </div>
                                </div>
                                <div>
                                    <?php if(!empty($reserved_wage)): ?>
                                    <div class="row">
                                        <div class="col-md-1 col-xs-12">
                                            <img src="https://image.eveonline.com/Character/<?php echo $reserved_wage['Recipient']['id']; ?>_32.jpg">
                                        </div>
                                        <div class="col-md-3 col-xs-12">
                                            <?php echo $reserved_wage['Recipient']['eve_name']; ?>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <?php

                                                    echo number_format($reserved_wage['Wage']['amount'], 2).' ISK <br/>';
                                                    echo $reserved_wage['Wage']['amount'];

                                            ?>
                                        </div>
                                        <div class="col-md-2 col-xs-12">

                                            <button class="btn btn-block btn-xs btn-success" type="button" onclick="CCPEVE.showInfo(1377, <?php echo $reserved_wage['Recipient']['id']; ?>)">
                                                In game profile
                                            </button>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <table class="table table-striped table-condensed">
                        <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('recipient_id'); ?></th>
                            <th><?php echo $this->Paginator->sort('amount'); ?></th>
                            <th><?php echo $this->Paginator->sort('admin_id'); ?></th>
                            <th><?php echo $this->Paginator->sort('created'); ?></th>
                            <th><?php echo $this->Paginator->sort('status'); ?></th>
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
                                <td><?php echo h($wage['Wage']['status']); ?>&nbsp;</td>
                                <td class="actions">
                                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $wage['Wage']['id'])); ?>
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