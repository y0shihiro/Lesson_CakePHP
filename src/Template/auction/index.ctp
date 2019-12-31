<h2>ミニオークション！</h2>
<h3>※出品されている商品</h3>
<p><?= $this->Paginator->counter(['format' => '全{{pages}}ページ中{{page}}ページ目を表示しています']) ?></p>
<table cellpadding="0" cellspacing="0">
<thead>
<tr>
<th scope="col"></th>
<th class="main" scope="col"><?= $this->Paginator->sort('name') ?></th>
<th scope="col"><?= $this->Paginator->sort('finished') ?></th>
<th scope="col"><?= $this->Paginator->sort('endtime') ?></th>
<th scope="col" class="actions"><?= __('Actions') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($auction as $biditem) : ?>
<tr>
<td><?= $this->Html->image('../upimg/' . $biditem->file_name, array('width' => 200)) ?></td>
<td><?= h($biditem->name) ?></td>
<td><?= h($biditem->finished ? 'Finished':'') ?></td>
<td><?= h($biditem->endtime) ?></td>
<td class="actions">
    <?= $this->Html->link(__('View'), ['action' => 'view', $biditem->id]) ?>
    <?php if ($authuser['id'] === $biditem->user_id): ?>
    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $biditem->id], ['confirm' => '削除します。よろしいですか？']) ?>
    <?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->first('<< ' . __('first')) ?>
<?= $this->Paginator->prev('< ' . __('previous')) ?>
<?= $this->Paginator->next(__('next') . ' >') ?>
<?= $this->Paginator->last(__('last') . ' >>') ?>
</ul>
</div>