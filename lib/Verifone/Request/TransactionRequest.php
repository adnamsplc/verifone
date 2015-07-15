<?php
/**
 * Adnams Tours API.
 *
 * @link      http://github.com/adnams/tours-api for the canonical source repository
 * @author    Chris Yallop <chris.yallop@adnams.co.uk>
 * @package   Verifone\Request
 * @copyright Copyright (c) 2014 Adnams Plc. (http://adnams.co.uk)
 */

namespace Verifone\Request;

use Verifone\RequestMessage\TransactionRequestMessageInterface;

/**
 * Responsible for wrapping an e-commerce transaction request.
 *
 * @package    Verifone\Request
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class TransactionRequest extends AbstractRequest
{
    /** @var TransactionRequestMessageInterface */
    private $transaction;

    /**
     * Constructor.
     *
     * @param string $systemId
     * @param string $systemGuid
     * @param float $passcode
     * @param TransactionRequestMessageInterface $transaction
     */
    public function __construct($systemId, $systemGuid, $passcode, TransactionRequestMessageInterface $transaction)
    {
        parent::__construct($systemId, $systemGuid, $passcode);

        $this->transaction  = $transaction;
    }

    /**
     * Get the message type.
     *
     * @return string
     */
    protected function getMsgType()
    {
        return 'TXN';
    }

    /**
     * Get the message data.
     *
     * @return string
     */
    protected function getMsgData()
    {
        $transReq = $this->getDomDoc()->appendChild($this->getDomDoc()->createElement('transactionrequest'));
        $this->getDomDoc()->createAttributeNS('TXN', 'Verifone'); // arg2 is not used but can't be empty.

        $this->createAndAppendElement($transReq, 'merchantreference', $this->transaction->getMerchantReference());
        $this->createAndAppendElement($transReq, 'accountid', $this->transaction->getAccountId());
        $this->createAndAppendElement($transReq, 'accountpasscode', $this->transaction->getAccountPasscode());
        $this->createAndAppendElement($transReq, 'txntype', $this->transaction->getTxnType()); // Purchase
        $this->createAndAppendElement($transReq, 'transactioncurrencycode', $this->transaction->getTransactionCurrencyCode());
        $this->createAndAppendElement($transReq, 'terminalcountrycode', $this->transaction->getTerminalCountryCode());
        $this->createAndAppendElement($transReq, 'apacsterminalcapabilities', $this->transaction->getApacsTerminalCapabilities()); // CNP/ECommerce (if flagged for payer authorisation with acquirer; no CNP transactions are allowed with the exception of refunds)
        $this->createAndAppendElement($transReq, 'capturemethod', $this->transaction->getCaptureMethod()); // Keyed Cardholder Not Present E-Commerce Order
        $this->createAndAppendElement($transReq, 'processingidentifier', $this->transaction->getProcessingIdentifier()); // Auth and Charge
        $this->createAndAppendElement($transReq, 'pan', $this->transaction->getPan());
        $this->createAndAppendElement($transReq, 'csc', $this->transaction->getCsc());
        $this->createAndAppendElement($transReq, 'avshouse', $this->transaction->getAvsHouse());
        $this->createAndAppendElement($transReq, 'avspostcode', $this->transaction->getAvsPostcode());
        $this->createAndAppendElement($transReq, 'expirydate', $this->transaction->getExpiryDate());
        $this->createAndAppendElement($transReq, 'txnvalue', $this->transaction->getTxnValue());

        return $this->getDomDoc()->saveXML();
    }
}
