<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css')  ?>
    <?= $this->Html->css('normalize.css') ?>
    <?= $this->Html->css('style.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <div class="top-bar-section">
        <?php if ($logedIn): ?>
          <ul class="left">
              <li><?= $this->Html->link(__('Todoリスト'), ['controller' => 'Tasks', 'action' => 'add']) ?></li>
              <li><?= $this->Html->link(__('達成度'), ['controller' => 'Achievements', 'action' => 'index']) ?></li>
          </ul>
          <ul class="right">
              <li><?= $this->Html->link('ユーザー編集', ['controller' => 'Users', 'action' => 'edit', $user_id]) ?> </li>
              <li><?= $this->Html->link('ログアウト', ['controller' => 'Users', 'action' => 'logout']) ?> </li>
          </ul>
        <?php else: ?>
          <ul class="left">
              <li><?= $this->Html->link(__('ログイン画面'), ['controller' => 'Users', 'action' => 'login']) ?></li>
          </ul>
          <ul class="right">
              <li><?= $this->Html->link(__('新規ユーザー登録'), ['controller' => 'Users', 'action' => 'add']) ?></li>
          </ul>
        <?php endif; ?>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
