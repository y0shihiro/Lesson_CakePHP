<table>
<?= $this->Html->tableHeaders(['title', 'name', 'mail'],
['style' => ['background:#006;color:white']]) ?>
<?= $this->Html->tableCells([
  ['this is sample', 'taro', 'taro@'],
  ['Hello!', 'hanako', 'hanako@'],
  ['test', 'sachiko', 'sachi@'],
  ['last!', 'jiro', 'jiro@'],
],
['style' => ['background:#ccf']],
['style' => ['background:#dff']]) ?>
</table>
<ul>
<?= $this->Html->nestedList(
  ['first line', 'second line', 'third line' => ['one', 'two', 'three']]) ?>
</ul>

<?=$this->Url->build(['controller' => 'hello', 'action' => 'show', '_ext' => 'png', 'sample']) ?>

<?=$this->Text->autoLinkUrls('https://google.com') ?>
<?=$this->Text->autoParagraph("one\n two\n three") ?>

<?=$this->Number->currency(1234567, 'JPY') ?>

<?=$this->Number->precision(12.34567, 2) ?>

<?=$this->Number->toPercentage(0.98765, 3, ['multiply' => true]) ?>