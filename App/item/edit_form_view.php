<?php
require_once("ItemModel.php");
require_once(_TR_LIBPATH."Helpers.php");
?>
<html>
<head><title>Edit Item <?php echo($_REQUEST['id']) ?></title></head>
<body><?php
$item = ItemModel::find_one($_REQUEST['id']);
?>
<form action="index.php?id=<?php ph($item->id); ?>" method="post">
<input type="hidden" name="_method" value="put">
Name:<input type="text" name="name" value="<?php ph($item->name); ?>"><br/>
<input type="submit" value="Update">
</form>
</body>
</html>

