<?php
namespace Paulinhoajr\Cielo\Ecommerce\Request;

use Paulinhoajr\Cielo\Ecommerce\Request\AbstractSaleRequest;
use Paulinhoajr\Cielo\Environment;
use Paulinhoajr\Cielo\Merchant;
use Paulinhoajr\Cielo\Ecommerce\Sale;

class CreateSaleRequest extends AbstractSaleRequest
{

    private $environment;

    public function __construct(Merchant $merchant, Environment $environment)
    {
        parent::__construct($merchant);

        $this->environment = $environment;
    }

    public function execute($sale)
    {
        $url = $this->environment->getApiUrl() . '1/sales/';

        return $this->sendRequest('POST', $url, $sale);
    }

    protected function unserialize($json)
    {
        return Sale::fromJson($json);
    }
}
