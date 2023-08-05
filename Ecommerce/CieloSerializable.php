<?php
namespace App\Cielo\Ecommerce;

interface CieloSerializable extends \JsonSerializable
{
    public function populate(\stdClass $data);
}