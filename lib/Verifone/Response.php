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

use Verifone\ResponseMessage\ErrorResponseMessage;
use Zend\Soap\Client;

/**
 * Responsible for representing the response received from the WS.
 *
 * @package    Verifone
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class Response
{
    /** @var Client */
    private $client;

    /** @var \stdClass */
    private $response;

    /**
     * Constructor.
     *
     * @param Client $client
     * @param \stdClass $response
     */
    public function __construct(\stdClass $response, Client $client)
    {
        $this->client   = $client;
        $this->response = $response;

        $this->checkForErrors();
    }

    /**
     * Get the client header.
     *
     * @return \stdClass
     */
    public function getClientHeader()
    {
        return $this->response->ProcessMsgResult->ClientHeader;
    }

    /**
     * Get the message type.
     *
     * @return string
     */
    public function getMessageType()
    {
        return (string) $this->response->ProcessMsgResult->MsgType;
    }

    /**
     * Get the message data.
     *
     * @return string
     */
    public function getMessageData()
    {
        return (string) $this->response->ProcessMsgResult->MsgData;
    }

    /**
     * Get debug info.
     *
     * @return string
     */
    public function getDebugInfo()
    {
        return sprintf(
            "HTTP Req & Resp:\n%s\n%s\n%s\n%s",
            $this->getLastRequestHeaders(),
            $this->getLastRequest(),
            $this->getLastResponseHeaders(),
            $this->getLastResponse()
        );
    }

    /**
     * Get the last response.
     *
     * @return string
     */
    public function getLastResponse()
    {
        return $this->client->getLastResponse();
    }

    /**
     * Get the last response headers.
     *
     * @return string
     */
    public function getLastResponseHeaders()
    {
        return $this->client->getLastResponseHeaders();
    }

    /**
     * Get the last request.
     *
     * @return string
     */
    public function getLastRequest()
    {
        return $this->client->getLastRequest();
    }

    /**
     * Get the last request headers.
     *
     * @return string
     */
    public function getLastRequestHeaders()
    {
        return $this->client->getLastRequestHeaders();
    }

    /**
     * Checks for errors.
     */
    protected function checkForErrors()
    {
        if ($this->isError()) {
            $this->raiseError();
        }
    }

    /**
     * Check for an error.
     *
     * @return bool
     */
    protected function isError()
    {
        return 'ERROR' == strtoupper($this->getMessageType());
    }

    /**
     * Raises an error.
     *
     * @throws Exception\GeneralException
     */
    protected function raiseError()
    {
        if ($this->isError()) {
            $errorResponseMessage = new ErrorResponseMessage($this->getMessageData());

            // If no message is sent to WS then reply is capitalised camel.
            // Otherwise it's all uppercase.
            throw new Exception\GeneralException(
                (string) $errorResponseMessage->getMsgTxt(),
                (int) $errorResponseMessage->getCode(),
                $this->getLastRequest(),
                $this->getLastRequestHeaders()
            );
        }
    }
}
