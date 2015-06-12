<?php

$query = $conn->query("SELECT `id` FROM `stations`;");


$row = $query->fetchAll(PDO::FETCH_ASSOC);


foreach ($row as $value) {
	echo '<a href="?p=station&id=' . $value['id'] . '">' . $value['id'] . '</a>';
	echo '<hr />';
}