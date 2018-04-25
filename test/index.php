<?php

require '../vendor/autoload.php';

$cnpj = new \src\ConsultaCnpj\ConsultaCnpj();
$cnpj->checkCnpj('CNPJ');
echo $cnpj->nome();




