<div class="index large-4 large-offset-4 medium-offset-4 columns content">
  <div class="panel">
    <?= $this->Form->create() ?>
    <fieldset>
        <h3 class="text-center">ログイン画面</h3>
        <?= $this->Form->control('メールアドレス', ['type' => 'email', 'name' => 'email']) ?>
        <?= $this->Form->control('パスワード', ['type' => 'password', 'name' => 'password']) ?>
        <?= $this->Form->button('ログイン', ['class' => 'login-button'] ) ?>
        <?= $this->Form->end() ?>
    </fieldset>
  </div>
</div>
