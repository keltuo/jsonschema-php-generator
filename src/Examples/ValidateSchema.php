<?php
declare(strict_types=1);

use JsonSchemaPhpGenerator\Schema\Example;

require __DIR__ . '/../../vendor/autoload.php';

$input = (object)json_decode('{
                "username": "Lukas",
                "password": "Skywalker"
            }');

$schema = new Example();
$errors = [];

if ($schema->validate($input, $errors)) {
    echo "Validation OK" . PHP_EOL;
} else {
    echo "Validation NOT OK" . PHP_EOL;
    echo "Errors: ".var_export($errors, true);
}
