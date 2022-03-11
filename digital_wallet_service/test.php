<?php

// $senha = 'Qwe@123';

// $senha = password_hash($senha, PASSWORD_DEFAULT, [
//     'cost' => 15
// ]);

// var_dump($senha);

// print_r(password_get_info($senha));

$array = [
    'name' => [
        'Robson'
    ]
];

$array2 = [
    'name'
];

foreach ($array as $i => $v) {
    var_dump($i, $v);
}

echo "\n\n";

foreach ($array2 as $i => $v) {
    var_dump($i, $v);
}
