<?php
require_once("ItemController.php");
ItemController::newForm();
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head><title>New Item</title></head>
<body><?php
$form = new Form();
echo "Name:";
$form->textbox("name", "");
echo "<br/>";
$form->submitButton("Create");
$form->formEnd();
?>
</body>
</html>

