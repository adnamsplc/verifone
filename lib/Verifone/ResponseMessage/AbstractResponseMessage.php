<?php
/**
 * Adnams Tours API.
 *
 * @link      http://github.com/adnams/tours-api for the canonical source repository
 * @author    Chris Yallop <chris.yallop@adnams.co.uk>
 * @package   Verifone\Model
 * @copyright Copyright (c) 2014 Adnams Plc. (http://adnams.co.uk)
 */

namespace Verifone\ResponseMessage;

/**
 * Responsible for abstracting an error response.
 *
 * @package    Verifone\Model
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
abstract class AbstractResponseMessage
{
    /** @var \SimpleXMLElement */
    private $responseMessage;

    /**
     * Constructor.
     *
     * @param string $responseMessage
     */
    public function __construct($responseMessage)
    {
        $responseMessage = html_entity_decode($responseMessage);

        $this->responseMessage = simplexml_load_string(
            $responseMessage,
            "SimpleXMLElement",
            LIBXML_NOWARNING // suppresses an invalid namespace warning for not being absolute
        );

        $this->init();
    }

    /**
     * Really here for child classes to implement if needed, typically for error
     * checking.
     */
    public function init()
    {
    }

    /**
     * Use getters to retrieve message response attributes.
     *
     * @param string $name
     * @param array $arguments
     * @return \SimpleXMLElement[]
     * @throws \RuntimeException
     */
    public function __call($name, $arguments)
    {
        // elements seem to be mixed in case
        if (ctype_upper($this->responseMessage->getName())) {
            $responseAttribute = strtoupper($name);
            $responseAttribute = substr($responseAttribute, 3); // remove get prefix
        } else if (ctype_lower($this->responseMessage->getName())) {
            $responseAttribute = strtolower($name);
            $responseAttribute = substr($responseAttribute, 3); // remove get prefix
        } else { // title case
            $responseAttribute = substr($name, 3); // remove get prefix;
        }

        if (!isset($this->responseMessage->$responseAttribute)) {
            throw new \RuntimeException(sprintf(
                'Response has no attribute %s called with method %s',
                $responseAttribute,
                $name
            ));
        }

        return $this->responseMessage->$responseAttribute;
    }

    /**
     * Get the response message.
     *
     * @return \SimpleXMLElement
     */
    protected function getResponseMessage()
    {
        return $this->responseMessage;
    }
}
