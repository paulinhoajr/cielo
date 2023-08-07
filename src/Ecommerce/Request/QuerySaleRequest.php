<?php
namespace Paulinhoajr\Cielo\Ecommerce\Request;

use Paulinhoajr\Cielo\Ecommerce\Request\AbstractSaleRequest;
use Paulinhoajr\Cielo\Environment;
use Paulinhoajr\Cielo\Merchant;
use Paulinhoajr\Cielo\Ecommerce\Sale;

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
