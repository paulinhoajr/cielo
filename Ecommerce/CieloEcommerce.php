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

    /**
     * Create an instance of CieloEcommerce choosing the environment where the
     * requests will be send
     *
     * @param
     *            \App\Cielo\Ecommerce\Merchant merchant
     *            The merchant credentials
     * @param
     *            \App\Cielo\Ecommerce\Environment environment
     *            The environment: {@link Environment::production()} or
     *            {@link Environment::sandbox()}
     */
    public function __construct(Merchant $merchant, Environment $environment = null)
    {
        if ($environment == null) {
            $environment = Environment::production();
        }

        $this->merchant = $merchant;
        $this->environment = $environment;
    }

    /**
     * Send the Sale to be created and return the Sale with tid and the status
     * returned by Cielo.
     *
     * @param \App\Cielo\Ecommerce\Sale $sale
     *            The preconfigured Sale
     * @return \App\Cielo\Ecommerce\Sale The Sale with authorization, tid, etc. returned by Cielo.
     * @throws CieloRequestException if anything gets wrong.
     * @see <a href=
     *      "https://developercielo.github.io/Webservice-3.0/english.html#error-codes">Error
     *      Codes</a>
     */
    public function createSale(Sale $sale)
    {
        $createSaleRequest = new CreateSaleRequest($this->merchant, $this->environment);

        return $createSaleRequest->execute($sale);
    }

    /**
     * Query a Sale on Cielo by paymentId
     *
     * @param string $paymentId
     *            The paymentId to be queried
     * @return \App\Cielo\Ecommerce\Sale The Sale with authorization, tid, etc. returned by Cielo.
     * @throws CieloRequestException if anything gets wrong.
     * @see <a href=
     *      "https://developercielo.github.io/Webservice-3.0/english.html#error-codes">Error
     *      Codes</a>
     */
    public function getSale($paymentId)
    {
        $querySaleRequest = new QuerySaleRequest($this->merchant, $this->environment);

        return $querySaleRequest->execute($paymentId);
    }

    /**
     * Query a RecurrentPayment on Cielo by RecurrentPaymentId
     *
     * @param string $recurrentPaymentId
     *            The RecurrentPaymentId to be queried
     * @return \App\Cielo\Ecommerce\RecurrentPayment The RecurrentPayment with authorization, tid, etc. returned by Cielo.
     * @throws CieloRequestException if anything gets wrong.
     * @see <a href=
     *      "https://developercielo.github.io/Webservice-3.0/english.html#error-codes">Error
     *      Codes</a>
     */
    public function getRecurrentPayment($recurrentPaymentId)
    {
        $queryRecurrentPaymentRequest = new queryRecurrentPaymentRequest($this->merchant, $this->environment);

        return $queryRecurrentPaymentRequest->execute($recurrentPaymentId);
    }

    /**
     * Cancel a Sale on Cielo by paymentId and speficying the amount
     *
     * @param string $paymentId
     *            The paymentId to be queried
     * @param integer $amount
     *            Order value in cents
     * @return \App\Cielo\Ecommerce\Sale The Sale with authorization, tid, etc. returned by Cielo.
     * @throws CieloRequestException if anything gets wrong.
     * @see <a href=
     *      "https://developercielo.github.io/Webservice-3.0/english.html#error-codes">Error
     *      Codes</a>
     */
    public function cancelSale($paymentId, $amount = null)
    {
        $updateSaleRequest = new UpdateSaleRequest('void', $this->merchant, $this->environment);

        $updateSaleRequest->setAmount($amount);

        return $updateSaleRequest->execute($paymentId);
    }

    /**
     * Capture a Sale on Cielo by paymentId and specifying the amount and the
     * serviceTaxAmount
     *
     * @param string $paymentId
     *            The paymentId to be captured
     * @param integer $amount
     *            Amount of the authorization to be captured
     * @param integer $serviceTaxAmount
     *            Amount of the authorization should be destined for the service
     *            charge
     * @return \App\Cielo\Ecommerce\Payment The captured Payment.
     *
     * @throws CieloRequestException if anything gets wrong.
     * @see <a href=
     *      "https://developercielo.github.io/Webservice-3.0/english.html#error-codes">Error
     *      Codes</a>
     */
    public function captureSale($paymentId, $amount = null, $serviceTaxAmount = null)
    {
        $updateSaleRequest = new UpdateSaleRequest('capture', $this->merchant, $this->environment);

        $updateSaleRequest->setAmount($amount);
        $updateSaleRequest->setServiceTaxAmount($serviceTaxAmount);

        return $updateSaleRequest->execute($paymentId);
    }
}
