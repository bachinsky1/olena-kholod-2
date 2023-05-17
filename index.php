<?php

$pdo = new PDO('mysql:host=localhost;dbname=olena2', 'root', '');

$time_start = microtime(true);
 
$stmt = $pdo->query('SELECT * FROM categories');


$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tree = [];

function buildTree($parent, $parentId = 0)
{
    $branch = [];

    foreach($parent as $row)
    {
        if($parentId == $row['parent_id'])
        {
            $children = buildTree($parent, $row['categories_id']);

            if(!empty($children)) {
                $branch[$row['categories_id']] = $children;
            } else {
                $branch[$row['categories_id']] = $row['categories_id'];
            } 
        }
    }

    return $branch;
}

$time_end = microtime(true);
$execution_time = $time_end - $time_start;

echo 'Execution time (without connection): ' . $execution_time . '<br>';
echo "<pre>";

print_r(buildTree($categories));

// header('Content-Type: application/json; charset=utf-8');
// echo json_encode(buildTree($categories));

// print_r(buildTree($categories));
