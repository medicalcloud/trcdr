<?php
require_once("ItemController.php");
#$controller = new ItemController;
#$items = $controller->showMany();
global $ITEMS;
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head><title>Item List</title></head>
<body>
<?php 
$linksToShowOne = new LinksToShowOne();
$linksToEdit = new LinksToEdit();
$buttonsToRemove = new ButtonsToRemove();

$table = new Table();
foreach ($ITEMS as $item) {
    $table->tr();
    $table->td();
    ph($item->id);
    $table->tdEnd();
    $table->td();
    $linksToShowOne->p(h($item->name), $item->id);
    $table->tdEnd();
    $table->td();
    $linksToEdit->p("Edit", $item->id);
    $table->tdEnd();
    $table->td();
    $buttonsToRemove->p("Remove", $item->id);
    $table->tdEnd();
    $table->trEnd();
}
$table->tableEnd();
$linksToNew = new LinksToNew();
$linksToNew->p("New");
?>
</body>
</html>
