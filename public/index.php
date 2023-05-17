<?php


use App\MyQueryBuilder;

require(__DIR__ . '/../vendor/autoload.php');

$config = [
    'dbType' => 'mysql',
    'host' => 'localhost',
    'dbname' => 'test',
    'username' => 'root',
    'password' => ''
];


$db = new MyQueryBuilder($config);
$result = $db->select(['name', 'login', 'pass', 'age'])
    ->from('mytable')
    ->where('age', '>', 1)
    ->limit(1)
    ->execute();

$delete = $db->delete()
    ->from('mytable')
    ->where('age', '=', 2)
    ->execute();

$insert = $db->insert(
    'mytable',
    'aboba',
    'aboba',
    '1234',
    12)
    ->execute();

$update = $db->update('mytable')
    ->set('login', 'sdf')
    ->where('age', '=', 5)
    ->execute();


// Обработка результата
//foreach ($result as $row) {
//    var_dump($row);
//}