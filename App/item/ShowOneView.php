<?php
require_once("ItemController.php");
$controller = new ItemController();
$item = $controller->showOne();
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head><title>Show Item <?php echo($item->id) ?></title></head>
<body>
アイテムID：<?php ph($item->id); ?><br>
アイテム名：<?php ph($item->name); ?><br>
<?php linkToEdit("Edit", $item->id); ?><br>
<?php linkToShowMany("Back"); ?><br>
</body>
</html>

