<?php
require __DIR__ . '/../../vendor/autoload.php';

$input = json_decode('{
                "username": "Lukas"
            }');

$schema = new \JsonSchemaPhpGenerator\Schema\Example();
$errors = [];
if ($schema->validate($input, $errors)) {
    echo "Validation OK" . PHP_EOL;
} else {
    echo "Validation NOT OK" . PHP_EOL;
    echo "Errors: ".var_export($errors, true);
}
