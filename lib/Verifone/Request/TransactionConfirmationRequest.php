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

use Verifone\RequestMessage\TransactionConfirmationRequestMessage;

/**
 * Responsible for wrapping a transaction confirmation request.
 *
 * @package    Verifone\Request
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class TransactionConfirmationRequest extends AbstractRequest
{
    /** @var TransactionConfirmationRequestMessage */
    private $transactionConfirmationRequestMessage;

    /**
     * Constructor.
     *
     * @param string $systemId
     * @param string $systemGuid
     * @param float $passcode
     * @param string $processingDb
     * @param TransactionConfirmationRequestMessage $transactionConfirmationRequestMessage
     */
    public function __construct($systemId, $systemGuid, $passcode, $processingDb, TransactionConfirmationRequestMessage $transactionConfirmationRequestMessage)
    {
        parent::__construct($systemId, $systemGuid, $passcode);

        $this->setProcessingDb($processingDb);
        $this->transactionConfirmationRequestMessage = $transactionConfirmationRequestMessage;
    }

    /**
     * Get the message type.
     *
     * @return string
     */
    protected function getMsgType()
    {
        return 'CNF';
    }

    /**
     * Get the message data.
     *
     * @return string
     */
    protected function getMsgData()
    {
        $transReq = $this->getDomDoc()->appendChild($this->getDomDoc()->createElement('confirmationrequest'));
        $this->getDomDoc()->createAttributeNS('TXN', 'Verifone'); // arg2 is not used but can't be empty.

        $this->createAndAppendElement($transReq, 'transactionid', $this->transactionConfirmationRequestMessage->getTransactionId());

        return $this->getDomDoc()->saveXML();
    }
}
