<?php
global $SO;
$item = $SO->get('item');
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head><title>Edit Item <?php ph($item->id) ?></title></head>
<body><?php
$form = new Form($item->id);
echo "Name:";
$form->textbox("name", $item->name);
echo "<br/>";
$form->submitButton("Update");
$form->formEnd();
?>
</body>
</html>

