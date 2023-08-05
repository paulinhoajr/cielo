<?php
namespace App\Cielo\Ecommerce\Request;

use App\Cielo\Ecommerce\Request\AbstractSaleRequest;
use App\Cielo\Environment;
use App\Cielo\Merchant;
use App\Cielo\Ecommerce\Sale;

class QuerySaleRequest extends AbstractSaleRequest
{

    private $environment;

    public function __construct(Merchant $merchant, Environment $environment)
    {
        parent::__construct($merchant);
        
        $this->environment = $environment;
    }

    public function execute($paymentId)
    {
        $url = $this->environment->getApiQueryURL() . '1/sales/' . $paymentId;
        
        return $this->sendRequest('GET', $url);
    }

    protected function unserialize($json)
    {
        return Sale::fromJson($json);
    }
}