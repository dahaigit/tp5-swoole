<?php
// 创建表的时候，需要指定表最大行数
$table = new swoole_table(1024);
// 创建表
$table->column('name', swoole_table::TYPE_STRING, 256);
$table->column('age', swoole_table::TYPE_INT, 3);
$table->create();
// 插入数据
$table->set(1, [
    'name' => '大海牛逼',
    'age' => 18,
]);
// 获取数据
var_dump($table->get(1));
