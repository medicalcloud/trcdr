<?php
require_once("ItemController.php");
$controller = new ItemController;
$items = $controller->showMany();
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head><title>Item List</title></head>
<body>
<?php 
$table = new Table();
foreach ($items as $item) {
    $table->tr();
    $table->td();
    ph($item->id);
    $table->tdEnd();
    $table->td();
    linkToShowOne(h($item->name), $item->id);
    $table->tdEnd();
    $table->td();
    linkToEdit("Edit", $item->id);
    $table->tdEnd();
    $table->td();
    buttonToRemove("Remove", $item->id);
    $table->tdEnd();
    $table->trEnd();
}
$table->tableEnd();
linkToNew("New")
?>
</body>
</html>
