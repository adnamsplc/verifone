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

/**
 * Responsible for wrapping an e-commerce transaction request.
 *
 * @package    Verifone\Request
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
abstract class AbstractRequest implements RequestInterface
{
    /** @var \DOMDocument */
    private $domDoc;

    /** @var string */
    private $passcode;

    /** @var string */
    private $processingDb = '';

    /** @var string */
    private $systemGuid;

    /** @var float */
    private $systemId;

    /**
     * Get the message type.
     *
     * @return string
     */
    abstract protected function getMsgType();

    /**
     * Get the message data.
     *
     * @return string
     */
    abstract protected function getMsgData();

    /**
     * Constructor.
     *
     * @param string $systemId
     * @param string $systemGuid
     * @param float $passcode
     */
    public function __construct($systemId, $systemGuid, $passcode)
    {
        $this->domDoc                       = new \DOMDocument();
        $this->domDoc->formatOutput         = true;
        $this->domDoc->preserveWhiteSpace   = false;

        $this->passcode     = (string) $passcode;
        $this->systemGuid   = (string) $systemGuid;
        $this->systemId     = (float) $systemId;
    }

    /**
     * Get the message.
     *
     * @return \stdClass
     */
    public function getMessage()
    {
        $message = array(
            'Message' => array(
                'ClientHeader'  => $this->getClientHeader(),
                'MsgType'       => $this->getMsgType(),
                'MsgData'       => $this->getMsgData(),
            ),
        );

        return json_decode(json_encode($message));
    }

    /**
     * Creates and appends an element to a parent element.
     *
     * @param \DOMElement $parentElement
     * @param string $dataElement
     * @param mixed $data
     */
    protected function createAndAppendElement(\DOMElement $parentElement, $dataElement, $data)
    {
        if (in_array(gettype($data), array('boolean', 'integer', 'double'))) {
            $dataElement = $this->domDoc->createElement($dataElement, $data);
        } else {
            $data        = $this->domDoc->createCDATASection((string) $data);
            $dataElement = $this->domDoc->createElement($dataElement);
            $dataElement->appendChild($data);
        }

        $parentElement->appendChild($dataElement);
    }

    /**
     * Get client header.
     *
     * @return array
     */
    protected function getClientHeader()
    {
        return array(
            'SystemID'      => $this->getSystemId(),
            'SystemGUID'    => $this->getSystemGuid(),
            'Passcode'      => $this->getPasscode(),
            'ProcessingDB'  => $this->getProcessingDb(),
            'SendAttempt'   => 0,
            'CDATAWrapping' => false, // Tried true but simplexml_load_string generates parse error
        );
    }

    /**
     * Get the domDoc.
     *
     * @return \DOMDocument
     */
    protected function getDomDoc()
    {
        return $this->domDoc;
    }

    /**
     * Get the passcode.
     *
     * @return string
     */
    protected function getPasscode()
    {
        return $this->passcode;
    }

    /**
     * Get the processingDb.
     *
     * @return string
     */
    protected function getProcessingDb()
    {
        return $this->processingDb;
    }

    /**
     * Get the systemGuid.
     *
     * @return string
     */
    protected function getSystemGuid()
    {
        return $this->systemGuid;
    }

    /**
     * Get the systemId.
     *
     * @return float
     */
    protected function getSystemId()
    {
        return $this->systemId;
    }

    /**
     * Set the processingDb.
     *
     * @param string $processingDb
     * @return $this
     */
    protected function setProcessingDb($processingDb)
    {
        $this->processingDb = (string)$processingDb;
        return $this;
    }
}
