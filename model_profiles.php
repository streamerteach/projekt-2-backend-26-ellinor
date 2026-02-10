<?php
$sql = "SELECT * from profiles";
$result = $conn->query($sql);
$row = $result->fetch();
print_r($row);
//print($row["realname"]);