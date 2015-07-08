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

use Verifone\RequestMessage\TransactionRejectionRequestMessage;

/**
 * Responsible for wrapping a transaction confirmation request.
 *
 * @package    Verifone\Request
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class TransactionRejectionRequest extends AbstractRequest
{
    /** @var TransactionRejectionRequestMessage */
    private $transactionRejectionRequestMessage;

    /**
     * Constructor.
     *
     * @param string $systemId
     * @param string $systemGuid
     * @param float $passcode
     * @param string $processingDb
     * @param TransactionRejectionRequestMessage $transactionRejectionRequestMessage
     */
    public function __construct($systemId, $systemGuid, $passcode, $processingDb, TransactionRejectionRequestMessage $transactionRejectionRequestMessage)
    {
        parent::__construct($systemId, $systemGuid, $passcode);

        $this->setProcessingDb($processingDb);
        $this->transactionRejectionRequestMessage = $transactionRejectionRequestMessage;
    }

    /**
     * Get the message type.
     *
     * @return string
     */
    protected function getMsgType()
    {
        return 'RJT';
    }

    /**
     * Get the message data.
     *
     * @return string
     */
    protected function getMsgData()
    {
        $transReq = $this->getDomDoc()->appendChild($this->getDomDoc()->createElement('rejectionrequest'));
        $this->getDomDoc()->createAttributeNS('TXN', 'Verifone'); // arg2 is not used but can't be empty.

        $this->createAndAppendElement($transReq, 'transactionid', $this->transactionRejectionRequestMessage->getTransactionId());
        $this->createAndAppendElement($transReq, 'capturemethod', $this->transactionRejectionRequestMessage->getCaptureMethod()); // Keyed Cardholder Not Present E-Commerce Order
        $this->createAndAppendElement($transReq, 'pan', $this->transactionRejectionRequestMessage->getPan());

        return $this->getDomDoc()->saveXML();
    }
}
