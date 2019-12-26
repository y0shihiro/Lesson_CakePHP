<h2>「<?=$biditem->name ?>」の情報</h2>
<?= $this->Form->create($bidrequest) ?>
<fieldset>
  <legend><?= __('※入札を行う') ?></legend>
  <?= $this->Form->hidden('biditem_id', ['value' => $biditem->id]) ?>
  <?= $this->Form->hidden('user_id', ['value' => $authuser['id']]) ?>
  <?= $this->Form->control('price') ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>