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
        <h3 class="text-center">ユーザー情報編集</h3>
        <?php echo $this->Html->image('../upload_img/'.$user->image, ['width' => '100', 'height' => '100', 'alt' => 'icon image']); ?>
        <div class="link-block">
          <?php echo $this->Html->link('画像を変更', ['action' => 'editImage', $user->id]); ?>
        </div>
        <hr>
        <?php
        echo $this->Form->control('画像', ["type" => "hidden", 'name' => 'image', 'value' => $user->image]);
        echo $this->Form->control('名前', ['type' => 'text', 'name' => 'name', 'value' => $user->name]);
        echo $this->Form->control('メールアドレス', ['type' => 'email', 'name' => 'email', 'value' => $user->email]);
        echo $this->Form->control('パスワード', ['type' => 'password', 'name' => 'password', 'value' => $user->password]);
        ?>
        <?= $this->Form->button(__('登録')) ?>
    </fieldset>
    <?= $this->Form->end() ?>
  </div>
</div>
