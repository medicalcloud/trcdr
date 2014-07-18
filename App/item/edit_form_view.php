<?php
require_once("ItemModel.php");
require_once(_TR_LIBPATH."Helpers.php");
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head><title>Edit Item <?php ph($_REQUEST['id']) ?></title></head>
<body><?php
$item = ItemModel::findOne($_REQUEST['id']);
$form = new Form($item->id);
echo "Name:";
$form->textbox("name", $item->name);
echo "<br/>";
$form->submitButton("Update");
$form->formEnd();
?>
</body>
</html>

