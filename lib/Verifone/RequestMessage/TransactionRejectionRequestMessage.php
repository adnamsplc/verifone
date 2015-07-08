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
 * Responsible for encapsulating a rejection request.
 *
 * @package    Verifone\RequestMessage
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class TransactionRejectionRequestMessage
{
    /** @var string */
    private $pan;

    /** @var float */
    private $transactionId;

    /**
     * This indicates how the card details were obtained.
     *
     * Acceptable values are:
     * Keyed Customer Present = 1
     * Keyed Customer Not Present Mail Order = 2 Swiped = 3
     * ICC Fallback to Swipe = 4
     * ICC Fallback to Signature = 5
     * ICC PIN Only = 6
     * ICC PIN and Signature = 7
     * ICC – No CVM = 8
     * Contactless EMV = 9
     * Contactless Mag Stripe = 10
     * Keyed Customer Not Present Telephone Order = 11
     * Keyed Customer Not Present E-Commerce = 12
     *
     * @var int The capture method. */
    private $captureMethod = 12;

    /**
     * Constructor.
     *
     * @param string $transactionId
     * @param string $pan
     */
    public function __construct($transactionId, $pan)
    {
        $this->transactionId    = (string) $transactionId;
        $this->pan              = (string) $pan;
    }

    /**
     * Get the transaction ID.
     *
     * @return float
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Get the capture method.
     *
     * @return int
     */
    public function getCaptureMethod()
    {
        return $this->captureMethod;
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
}
