<?php
/**
 * Adnams Tours API.
 *
 * @link      http://github.com/adnams/tours-api for the canonical source repository
 * @author    Chris Yallop <chris.yallop@adnams.co.uk>
 * @package   Verifone
 * @copyright Copyright (c) 2014 Adnams Plc. (http://adnams.co.uk)
 */

namespace Verifone;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Verifone\Request\RequestInterface;
use Verifone\Request\TransactionConfirmationRequest;
use Verifone\Request\TransactionRejectionRequest;
use Verifone\Request\TransactionRequest;
use Verifone\RequestMessage\EcommerceTransactionRequestMessage;
use Verifone\RequestMessage\TransactionConfirmationRequestMessage;
use Verifone\RequestMessage\TransactionRejectionRequestMessage;
use Verifone\ResponseMessage\TransactionResponseMessage;
use Zend\Soap\Client;

/**
 * Responsible for sending messages directly to the Verifone WS.
 *
 * @package    Verifone
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class Verifone implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /** @var Client */
    private $client;

    /** @var array */
    private $config;

    /**
     * Get an instance of the Verifone object.
     *
     * @param array $config
     * @return Verifone
     */
    static public function factory(array $config)
    {
        $client = new Client($config['system']['wsdlUrl']);

        return new Verifone($client, $config);
    }

    /**
     * Constructor.
     *
     * @param Client $client
     * @param array $config
     */
    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;

        // Set the default web service timeout value.
        // Need to test, only works when waiting for a response.
        if (60 != ini_get('default_socket_timeout')) {
            ini_set('default_socket_timeout', 60);
        }
    }

    /**
     * Set the WSDL URL to an invalid one for testing.
     *
     * @return $this
     */
    public function setWsdlUrlToInvalidUrlForTesting()
    {
        $this->client->setWSDL(
            $this->config['system']['invalidUrl']
        );

        return $this;
    }

    /**
     * Authorise a transaction.
     *
     * @param string $pan
     * @param string $csc
     * @param string $expiryDate
     * @param float $txnAmount
     * @param string $merRef
     * @return TransactionResponseMessage
     */
    public function authoriseTransaction($pan, $csc, $expiryDate, $txnAmount, $merRef = '')
    {
        $ecomTrans  = new EcommerceTransactionRequestMessage(
            $this->config['merchant']['accountId'],
            $this->config['merchant']['accountPasscode'],
            $pan,
            $csc,
            $expiryDate,
            $txnAmount
        );
        $ecomTrans->setMerchantReference($merRef);

        $transReq   = new TransactionRequest(
            $this->config['system']['systemId'],
            $this->config['system']['systemGuid'],
            $this->config['system']['passcode'],
            $ecomTrans
        );

        $response = $this->send($transReq);

        // @todo This should probably be set on the property txnMsg then the client can call getTxnMsg()
        // and still access the debug info.
        // e.g. $response->setTxnRespMsg(new TransactionResponseMessage($response->getMessageData());
        // and then the client can call $response->getTxnMsg(); and still call $response->GetDebugInfo();
        // or the response object just figures out the correct message to instantiate. Mmm, who's responsible for what??
        // or the response message has the whole response object set for retrieval.
        return new TransactionResponseMessage($response->getMessageData());
    }

    /**
     * Confirms a transaction.
     *
     * @param TransactionResponseMessage $transactionResponseMessage
     * @return TransactionResponseMessage
     */
    public function confirmTransaction(TransactionResponseMessage $transactionResponseMessage)
    {
        $transactionConfirmationRequestMessage  = new TransactionConfirmationRequestMessage($transactionResponseMessage->getTransactionId());
        $transactionConfirmationRequest         = new TransactionConfirmationRequest(
            $this->config['system']['systemId'],
            $this->config['system']['systemGuid'],
            $this->config['system']['passcode'],
            $transactionResponseMessage->getProcessingDb(),
            $transactionConfirmationRequestMessage
        );

        $transactionConfirmationResponse = $this->send($transactionConfirmationRequest);
        return new TransactionResponseMessage($transactionConfirmationResponse->getMessageData());
    }

    /**
     * Rejects a transaction.
     *
     * @param TransactionResponseMessage $transactionResponseMessage
     * @param string $pan
     * @return TransactionResponseMessage
     */
    public function rejectTransaction(TransactionResponseMessage $transactionResponseMessage, $pan)
    {
        $transactionRejectionRequestMessage  = new TransactionRejectionRequestMessage(
            $transactionResponseMessage->getTransactionId(),
            (string) $pan
        );

        $transactionRejectionRequest         = new TransactionRejectionRequest(
            $this->config['system']['systemId'],
            $this->config['system']['systemGuid'],
            $this->config['system']['passcode'],
            $transactionResponseMessage->getProcessingDb(),
            $transactionRejectionRequestMessage
        );

        $transactionRejectionResponse = $this->send($transactionRejectionRequest);
        return new TransactionResponseMessage($transactionRejectionResponse->getMessageData());
    }

    /**
     * Send a message to the Verifone WS.
     *
     * @param RequestInterface $request
     * @return Response
     */
    protected function send(RequestInterface $request)
    {
        $rawResponse = $this->client->ProcessMsg(
            $request->getMessage()
        );

        $response = new Response($rawResponse, $this->client);

        if (isset($this->logger) && $this->logger instanceof LoggerInterface) {
            $this->logger->info(
                $this->maskCreditCardNumber($response->getDebugInfo())
            );
        }

        return $response;
    }

    /**
     * Searches for and masks a credit card number in a string of text.
     *
     * @param string $string
     * @return mixed
     */
    protected function maskCreditCardNumber($string)
    {
        return preg_replace('/(\d{6})(\d+)(\d{4})/', '$1****$3', $string);
    }
}
