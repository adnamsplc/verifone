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
interface RequestInterface
{
    /**
     * Get the message.
     *
     * @return \stdClass
     */
    public function getMessage();
}
