<?php
namespace App\Cielo\Ecommerce;

use App\Cielo\Merchant;
use App\Cielo\Ecommerce\Request\CreateSaleRequest;
use App\Cielo\Ecommerce\Request\QuerySaleRequest;
use App\Cielo\Ecommerce\Request\UpdateSaleRequest;
use App\Cielo\Ecommerce\Request\QueryRecurrentPaymentRequest;


/**
 * The Cielo Ecommerce SDK front-end;
 */
class CieloEcommerce
{

    private $merchant;

    private $environment;

    public function __construct(Merchant $merchant, Environment $environment = null)
    {
        if ($environment == null) {
            $environment = Environment::production();
        }

        $this->merchant = $merchant;
        $this->environment = $environment;
    }

    public function createSale(Sale $sale)
    {
        $createSaleRequest = new CreateSaleRequest($this->merchant, $this->environment);

        return $createSaleRequest->execute($sale);
    }

    public function getSale($paymentId)
    {
        $querySaleRequest = new QuerySaleRequest($this->merchant, $this->environment);

        return $querySaleRequest->execute($paymentId);
    }

    public function getRecurrentPayment($recurrentPaymentId)
    {
        $queryRecurrentPaymentRequest = new queryRecurrentPaymentRequest($this->merchant, $this->environment);

        return $queryRecurrentPaymentRequest->execute($recurrentPaymentId);
    }

    public function cancelSale($paymentId, $amount = null)
    {
        $updateSaleRequest = new UpdateSaleRequest('void', $this->merchant, $this->environment);

        $updateSaleRequest->setAmount($amount);

        return $updateSaleRequest->execute($paymentId);
    }

    public function captureSale($paymentId, $amount = null, $serviceTaxAmount = null)
    {
        $updateSaleRequest = new UpdateSaleRequest('capture', $this->merchant, $this->environment);

        $updateSaleRequest->setAmount($amount);
        $updateSaleRequest->setServiceTaxAmount($serviceTaxAmount);

        return $updateSaleRequest->execute($paymentId);
    }
}
