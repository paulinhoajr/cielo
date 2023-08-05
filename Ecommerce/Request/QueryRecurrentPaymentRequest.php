<?php
namespace Cielo\API30\Ecommerce\Request;

use App\Cielo\Ecommerce\Request\AbstractSaleRequest;
use App\Cielo\Environment;
use App\Cielo\Merchant;
use App\Cielo\Ecommerce\RecurrentPayment;

class QueryRecurrentPaymentRequest extends AbstractSaleRequest
{

    private $environment;

    public function __construct(Merchant $merchant, Environment $environment)
    {
        parent::__construct($merchant);

        $this->environment = $environment;
    }

    public function execute($recurrentPaymentId)
    {
        $url = $this->environment->getApiQueryURL() . '1/RecurrentPayment/' . $recurrentPaymentId;

        return $this->sendRequest('GET', $url);
    }

    protected function unserialize($json)
    {
        return RecurrentPayment::fromJson($json);
    }
}
