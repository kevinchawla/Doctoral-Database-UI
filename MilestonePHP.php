<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Mile Stones</title>
</head>
<body>
<h2>Milestones Passed<h2>
<h3>
<?php
include_once 'php_project/php_hw.php';
$object = new Record;
echo $object->display_record();
?>
</body>
</html>
