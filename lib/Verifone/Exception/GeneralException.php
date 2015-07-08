<?php
/**
 * Adnams Tours API.
 *
 * @link      http://github.com/adnams/tours-api for the canonical source repository
 * @author    Chris Yallop <chris.yallop@adnams.co.uk>
 * @package   Verifone\Exception
 * @copyright Copyright (c) 2014 Adnams Plc. (http://adnams.co.uk)
 */

namespace Verifone\Exception;

use Zend\Soap\Client;

/**
 * GeneralException.
 *
 * @package    Verifone\Exception
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class GeneralException extends \Exception
{
    /** @var string The last request. */
    private $lastRequest = '';

    /** @var string The last request headers. */
    private $lastRequestHeaders = '';

    /**
     * Constructor.
     *
     * @param string $message
     * @param int $code
     * @param string $lastRequest
     * @param string $lastRequestHeaders
     */
    public function __construct($message = "", $code = 0, $lastRequest = "", $lastRequestHeaders = "")
    {
        $this->lastRequest          = $lastRequest;
        $this->lastRequestHeaders   = $lastRequestHeaders;

        parent::__construct($message, $code, $previous = null);
    }

    /**
     * Get the lastRequest.
     *
     * @return string
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * Get the lastRequestHeaders.
     *
     * @return string
     */
    public function getLastRequestHeaders()
    {
        return $this->lastRequestHeaders;
    }

}
