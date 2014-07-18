<?php
require_once("ItemModel.php");
ItemModel::remove($_REQUEST["id"]);
echo "Yey! remove action is called!";
#redirect_to index.php

