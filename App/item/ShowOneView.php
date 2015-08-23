<?php namespace trcdr;
global $SO;
$item = $SO->get('item');

$linksToEdit = new LinksToEdit();
$linksToShowMany = new LinksToShowMany();
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head><title>Show Item <?php echo($item->id) ?></title></head>
<body>
アイテムID：<?php ph($item->id); ?><br>
アイテム名：<?php ph($item->name); ?><br>
<?php $linksToEdit->p("Edit", $item->id); ?><br>
<?php $linksToShowMany->p("Back"); ?><br>
</body>
</html>

