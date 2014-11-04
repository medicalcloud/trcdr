<?php
require_once("ItemController.php");
#$controller = new ItemController();
#$item = $controller->editForm();
global $ITEM;
?>
<?php echo $ITEM->id; ?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head><title>Edit Item <?php ph($ITEM->id) ?></title></head>
<body><?php
$form = new Form($ITEM->id);
echo "Name:";
$form->textbox("name", $ITEM->name);
echo "<br/>";
$form->submitButton("Update");
$form->formEnd();
?>
</body>
</html>

