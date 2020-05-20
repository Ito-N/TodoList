<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
?>
<div class="index large-6 large-offset-3 columns content">
  <h3 class="text-center">Todoリスト</h3>
    <?= $this->Form->create($task) ?>
      <?php echo $this->Form->control('finish_state', ["type" => "hidden", 'name' => 'finish_state', 'value' => 0]); ?>
      <?php echo $this->Form->control('user_id', ["type" => "hidden", 'name' => 'user_id', 'value' => $user_id]); ?>
      <div class="input-inline">
        <?php echo $this->Form->control(' ', ['type' => 'text', 'name' => 'content', 'label' => false, 'id' => 'input-width', 'placeholder' => 'Todo' ]); ?>
        <?php echo $this->Form->select( "priority", [ "高", "中", "低" ]); ?>
        <?= $this->Form->button('UP', ['id' => 'button-size']) ?>
      </div>
    <?= $this->Form->end() ?>

    <table class="top-margin">
      <?php foreach ($tasks as $task_index): ?>
        <tr>
          <?php if($task_index->finish_state === 1) {
            $checked = true;
          } else {
            $checked = false;
          } ?>

          <td><?php echo $this->Form->control("check", ["type" => "checkbox",
                                         "value" => "finish_state",
                                         "label" => false,
                                         "checked" => $checked,
                                         "hiddenField" => false ]); ?></td>
          <td class="todo-margin-right"><?php echo h($task_index->content); ?></td>
          <?php if($task_index->priority === 0): ?>
            <td>高</td>
          <?php elseif($task_index->priority === 1): ?>
            <td>中</td>
          <?php else: ?>
            <td>低</td>
          <?php endif; ?>
          <td><?= $this->Form->postLink(__('削除'),['action' => 'delete', $task_index->id],['confirm' => __('データを削除してもよろしいですか # {0}?', $task_index->id)]) ?></td>
        </tr>
      <?php endforeach; ?>
   </table>
</div>
