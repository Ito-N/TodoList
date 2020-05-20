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
        <h3 class="text-center">画像編集</h3>
        <?php
          if ($user->image){
            echo $this->Html->image('../upload_img/'.$user->image, ['width' => '100', 'height' => '100', 'alt' => 'icon image']);
          }
          echo $this->Form->control('画像', ["type" => "file", 'name' => 'image']);
          echo $this->Form->control('名前', ['type' => 'hidden', 'name' => 'name', 'value' => $user->name]);
          echo $this->Form->control('メールアドレス', ['type' => 'hidden', 'name' => 'email', 'value' => $user->email]);
          echo $this->Form->control('パスワード', ['type' => 'hidden', 'name' => 'password', 'value' => $user->password]);
          if ($user->image){
            echo $this->Form->control("file_before",["type"=>"hidden","value"=>$user->image]);
            echo $this->Form->control("画像削除",["type"=>"submit","name"=>"file_delete","value"=>"delete"]);
          }
        ?>
        <?= $this->Form->button(__('登録')) ?>
    </fieldset>
    <?= $this->Form->end() ?>
  </div>
</div>
