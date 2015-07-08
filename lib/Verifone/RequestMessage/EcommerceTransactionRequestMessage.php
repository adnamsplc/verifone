<?php
/**
 * Adnams Tours API.
 *
 * @link      http://github.com/adnams/tours-api for the canonical source repository
 * @author    Chris Yallop <chris.yallop@adnams.co.uk>
 * @package   Verifone\RequestMessage
 * @copyright Copyright (c) 2014 Adnams Plc. (http://adnams.co.uk)
 */

namespace Verifone\RequestMessage;

/**
 * Responsible for modeling an e-commerce transaction.
 *
 * @package    Verifone\RequestMessage
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class EcommerceTransactionRequestMessage extends TransactionRequestMessage
{
    /**
     * Constructor.
     *
     * @param float $accountId
     * @param string $accountPasscode
     * @param string $pan
     * @param string $csc
     * @param string $expiryDate
     * @param float $txnValue
     */
    public function __construct($accountId, $accountPasscode, $pan, $csc, $expiryDate, $txnValue)
    {
        parent::__construct($accountId, $accountPasscode);

        $this->setGeneralValues();
        $this->setEcommerceValues();
        $this->setPaymentValues($pan, $csc, $expiryDate, $txnValue);
    }

    /**
     * Sets general values.
     */
    protected function setGeneralValues()
    {
        $this->setTransactionCurrencyCode('GBP');
        $this->setTerminalCountryCode(826); // United Kingdom
    }

    /**
     * Sets e-commerce specific values.
     */
    protected function setEcommerceValues()
    {
        $this->setTxnType('01'); // Purchase
        $this->setTransactionCurrencyCode(826); // Pound sterling
        $this->setTerminalCountryCode(826); // United Kingdom

        // CNP/ECommerce (if flagged for payer authorisation with acquirer; no
        // CNP transactions are allowed with the exception of refunds)
        $this->setApacsTerminalCapabilities(4298);

        $this->setCaptureMethod(12); // Keyed Cardholder Not Present E-Commerce Order
        $this->setProcessingIdentifier(1); // Auth and Charge
    }

    /**
     * Sets payment values.
     *
     * @param string $pan
     * @param string $csc
     * @param string $expiryDate
     * @param float $txnValue
     */
    protected function setPaymentValues($pan, $csc, $expiryDate, $txnValue)
    {
        $this->setPan($pan);
        $this->setCsc($csc);
        $this->setExpiryDate($expiryDate);
        $this->setTxnValue($txnValue);
    }
}
