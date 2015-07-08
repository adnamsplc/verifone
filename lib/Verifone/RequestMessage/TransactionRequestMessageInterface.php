<?php
/**
 * TransactionInterface
 *
 * @package    Verifone\RequestMessage
 * @author     Chris Yallop <chris.yallop@adnams.co.uk>
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */

namespace Verifone\RequestMessage;


/**
 * Responsible for modeling a transaction.
 *
 * @package    Verifone\RequestMessage
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
interface TransactionRequestMessageInterface
{
    /**
     * Get the terminalCountryCode.
     *
     * @return string
     */
    public function getTerminalCountryCode();

    /**
     * Get the expiryDate.
     *
     * @return string
     */
    public function getExpiryDate();

    /**
     * Get the merchantReference.
     *
     * @return string
     */
    public function getMerchantReference();

    /**
     * Get the csc.
     *
     * @return string
     */
    public function getCsc();

    /**
     * Get the pan.
     *
     * @return string
     */
    public function getPan();

    /**
     * Get the txnType.
     *
     * @return string
     */
    public function getTxnType();

    /**
     * Get the apacsTerminalCapabilities.
     *
     * @return string
     */
    public function getApacsTerminalCapabilities();

    /**
     * Get the txnValue.
     *
     * @return float
     */
    public function getTxnValue();

    /**
     * Get the accountPasscode.
     *
     * @return string
     */
    public function getAccountPasscode();

    /**
     * Get the processingIdentifier.
     *
     * @return int
     */
    public function getProcessingIdentifier();

    /**
     * Get the account ID.
     *
     * @return float
     */
    public function getAccountId();

    /**
     * Get the captureMethod.
     *
     * @return int
     */
    public function getCaptureMethod();

    /**
     * Get the transactionCurrencyCode.
     *
     * @return string
     */
    public function getTransactionCurrencyCode();

    /**
     * Set the merchant reference.
     *
     * @param string $merchantReference
     * @return $this
     */
    public function setMerchantReference($merchantReference);
}
