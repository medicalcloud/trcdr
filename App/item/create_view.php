<?php
require_once("ItemModel.php");
ItemModel::create($_REQUEST);
echo "Yey create action is called!";
var_dump($_REQUEST);
#redirect_to index.php

