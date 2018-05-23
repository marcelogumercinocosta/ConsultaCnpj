<?php

require '../vendor/autoload.php';

$cnpj = new MarceloGumercinoCosta\ConsultaCnpj\ConsultaCnpj();
$cnpj->checkCnpj('06.164.253/0001-87');
echo $cnpj->nome();




