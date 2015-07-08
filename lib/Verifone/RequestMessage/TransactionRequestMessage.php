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
 * Responsible for modeling a transaction.
 *
 * @package    Verifone\RequestMessage
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class TransactionRequestMessage implements TransactionRequestMessageInterface
{
    /** @var string */
    private $merchantReference;

    /** @var float */
    private $accountId;

    /** @var string */
    private $accountPasscode;

    /** @var string */
    private $txnType;

    /** @var string */
    private $transactionCurrencyCode;

    /** @var string */
    private $terminalCountryCode;

    /** @var string */
    private $apacsTerminalCapabilities;

    /** @var int */
    private $captureMethod;

    /** @var int */
    private $processingIdentifier;

    /** @var string */
    private $pan;

    /** @var string */
    private $csc;

    /** @var string The expiry date, format is YYMM. */
    private $expiryDate;

    /** @var float */
    private $txnValue;

    /**
     * Constructor.
     *
     * @param float $accountId
     * @param string $accountPasscode
     */
    public function __construct($accountId, $accountPasscode)
    {
        $this->setMerchantValues($accountId, $accountPasscode);
    }

    /**
     * Sets merchant values.
     *
     * @param float $accountId
     * @param string $accountPasscode
     */
    protected function setMerchantValues($accountId, $accountPasscode)
    {
        $this->setAccountId($accountId);
        $this->setAccountPasscode($accountPasscode);
    }

    /**
     * Get the accountPasscode.
     *
     * @return string
     */
    public function getAccountPasscode()
    {
        return $this->accountPasscode;
    }

    /**
     * Get the account ID.
     *
     * @return float
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Get the apacsTerminalCapabilities.
     *
     * @return string
     */
    public function getApacsTerminalCapabilities()
    {
        return $this->apacsTerminalCapabilities;
    }

    /**
     * Get the captureMethod.
     *
     * @return int
     */
    public function getCaptureMethod()
    {
        return $this->captureMethod;
    }

    /**
     * Get the csc.
     *
     * @return string
     */
    public function getCsc()
    {
        return $this->csc;
    }

    /**
     * Get the expiryDate.
     *
     * @return string
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Get the merchantReference.
     *
     * @return string
     */
    public function getMerchantReference()
    {
        return $this->merchantReference;
    }

    /**
     * Get the pan.
     *
     * @return string
     */
    public function getPan()
    {
        return $this->pan;
    }

    /**
     * Get the processingIdentifier.
     *
     * @return int
     */
    public function getProcessingIdentifier()
    {
        return $this->processingIdentifier;
    }

    /**
     * Get the terminalCountryCode.
     *
     * @return string
     */
    public function getTerminalCountryCode()
    {
        return $this->terminalCountryCode;
    }

    /**
     * Get the transactionCurrencyCode.
     *
     * @return string
     */
    public function getTransactionCurrencyCode()
    {
        return $this->transactionCurrencyCode;
    }

    /**
     * Get the txnType.
     *
     * @return string
     */
    public function getTxnType()
    {
        return $this->txnType;
    }

    /**
     * Get the txnValue.
     *
     * @return float
     */
    public function getTxnValue()
    {
        return $this->txnValue;
    }

    /**
     * Set the accountId.
     *
     * @param float $accountId
     * @return $this
     */
    protected function setAccountId($accountId)
    {
        $this->accountId = (float)$accountId;
        return $this;
    }

    /**
     * Set the accountPasscode.
     *
     * @param string $accountPasscode
     * @return $this
     */
    protected function setAccountPasscode($accountPasscode)
    {
        $this->accountPasscode = (string)$accountPasscode;
        return $this;
    }

    /**
     * Set the apacsTerminalCapabilities.
     *
     * @param string $apacsTerminalCapabilities
     * @return $this
     */
    protected function setApacsTerminalCapabilities($apacsTerminalCapabilities)
    {
        $this->apacsTerminalCapabilities = (string)$apacsTerminalCapabilities;
        return $this;
    }

    /**
     * Set the captureMethod.
     *
     * @param int $captureMethod
     * @return $this
     */
    protected function setCaptureMethod($captureMethod)
    {
        $this->captureMethod = (int)$captureMethod;
        return $this;
    }

    /**
     * Set the csc.
     *
     * @param string $csc
     * @return $this
     */
    protected function setCsc($csc)
    {
        $this->csc = (string)$csc;
        return $this;
    }

    /**
     * Set the expiryDate.
     *
     * @param string $expiryDate
     * @return $this
     */
    protected function setExpiryDate($expiryDate)
    {
        $this->expiryDate = (string)$expiryDate;
        return $this;
    }

    /**
     * Set the merchant reference.
     *
     * @param string $merchantReference
     * @return $this
     */
    public function setMerchantReference($merchantReference)
    {
        $this->merchantReference = (string)$merchantReference;
        return $this;
    }

    /**
     * Set the pan.
     *
     * @param string $pan
     * @return $this
     */
    protected function setPan($pan)
    {
        $this->pan = (string)$pan;
        return $this;
    }

    /**
     * Set the processingIdentifier.
     *
     * @param int $processingIdentifier
     * @return $this
     */
    protected function setProcessingIdentifier($processingIdentifier)
    {
        $this->processingIdentifier = (int)$processingIdentifier;
        return $this;
    }

    /**
     * Set the terminalCountryCode.
     *
     * @param string $terminalCountryCode
     * @return $this
     */
    protected function setTerminalCountryCode($terminalCountryCode)
    {
        $this->terminalCountryCode = (string)$terminalCountryCode;
        return $this;
    }

    /**
     * Set the transactionCurrencyCode.
     *
     * @param string $transactionCurrencyCode
     * @return $this
     */
    protected function setTransactionCurrencyCode($transactionCurrencyCode)
    {
        $this->transactionCurrencyCode = (string)$transactionCurrencyCode;
        return $this;
    }

    /**
     * Set the txnType.
     *
     * @param string $txnType
     * @return $this
     */
    protected function setTxnType($txnType)
    {
        $this->txnType = (string)$txnType;
        return $this;
    }

    /**
     * Set the txnValue.
     *
     * @param float $txnValue
     * @return $this
     */
    protected function setTxnValue($txnValue)
    {
        $this->txnValue = (float)$txnValue;
        return $this;
    }
}
