<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Achievement $achievement
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Achievement'), ['action' => 'edit', $achievement->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Achievement'), ['action' => 'delete', $achievement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $achievement->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Achievements'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Achievement'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="achievements view large-9 medium-8 columns content">
    <h3><?= h($achievement->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $achievement->has('user') ? $this->Html->link($achievement->user->name, ['controller' => 'Users', 'action' => 'view', $achievement->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($achievement->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Degree Achievement') ?></th>
            <td><?= $this->Number->format($achievement->degree_achievement) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($achievement->date) ?></td>
        </tr>
    </table>
</div>
