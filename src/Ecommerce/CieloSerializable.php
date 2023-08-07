<?php
namespace Paulinhoajr\Cielo\Ecommerce;

interface CieloSerializable extends \JsonSerializable
{
    public function populate(\stdClass $data);
}
