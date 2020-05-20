<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="index large-4 large-offset-4 medium-offset-4 columns content">
  <div class="panel">
    <?= $this->Form->create($user, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <h3 class="text-center">ユーザー登録</h3>
        <?php
            echo $this->Form->control('名前', ['type' => 'text', 'name' => 'name']);
            echo $this->Form->control('メールアドレス', ['type' => 'email', 'name' => 'email']);
            echo $this->Form->control('パスワード', ['type' => 'password', 'name' => 'password']);
            echo $this->Form->control('画像', ["type" => "file", 'name' => 'image']);
        ?>
        <?= $this->Form->button(__('新規登録')) ?>
    </fieldset>
    <?= $this->Form->end() ?>
  </div>
</div>
