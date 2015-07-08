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
 * Responsible for encapsulating a confirmation request.
 *
 * @package    Verifone\RequestMessage
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class TransactionConfirmationRequestMessage
{
    /** @var float */
    private $transactionId;

    /** @var string */
    private $offlineAuthCode;

    /** @var float */
    private $gratuity;

    /** @var string */
    private $transactionCertificate;

    /** @var string */
    private $arc;

    /** @var string */
    private $applicatonUsageControl;

    /** @var string */
    private $tvr;

    /** @var string */
    private $cld;

    /** @var string */
    private $tsi;

    /** @var string */
    private $iad;

    /**
     * Constructor.
     *
     * @param string $transactionId
     */
    public function __construct($transactionId)
    {
        $this->transactionId = (string) $transactionId;
    }

    /**
     * Set the applicatonUsageControl.
     *
     * @param string $applicatonUsageControl
     * @return $this
     */
    public function setApplicatonUsageControl($applicatonUsageControl)
    {
        $this->applicatonUsageControl = (string)$applicatonUsageControl;
        return $this;
    }

    /**
     * Get the applicatonUsageControl.
     *
     * @return string
     */
    public function getApplicatonUsageControl()
    {
        return $this->applicatonUsageControl;
    }

    /**
     * Set the arc.
     *
     * @param string $arc
     * @return $this
     */
    public function setArc($arc)
    {
        $this->arc = (string)$arc;
        return $this;
    }

    /**
     * Get the arc.
     *
     * @return string
     */
    public function getArc()
    {
        return $this->arc;
    }

    /**
     * Set the cld.
     *
     * @param string $cld
     * @return $this
     */
    public function setCld($cld)
    {
        $this->cld = (string)$cld;
        return $this;
    }

    /**
     * Get the cld.
     *
     * @return string
     */
    public function getCld()
    {
        return $this->cld;
    }

    /**
     * Set the gratuity.
     *
     * @param float $gratuity
     * @return $this
     */
    public function setGratuity($gratuity)
    {
        $this->gratuity = (float)$gratuity;
        return $this;
    }

    /**
     * Get the gratuity.
     *
     * @return float
     */
    public function getGratuity()
    {
        return $this->gratuity;
    }

    /**
     * Set the iad.
     *
     * @param string $iad
     * @return $this
     */
    public function setIad($iad)
    {
        $this->iad = (string)$iad;
        return $this;
    }

    /**
     * Get the iad.
     *
     * @return string
     */
    public function getIad()
    {
        return $this->iad;
    }

    /**
     * Set the offlineAuthCode.
     *
     * @param string $offlineAuthCode
     * @return $this
     */
    public function setOfflineAuthCode($offlineAuthCode)
    {
        $this->offlineAuthCode = (string)$offlineAuthCode;
        return $this;
    }

    /**
     * Get the offlineAuthCode.
     *
     * @return string
     */
    public function getOfflineAuthCode()
    {
        return $this->offlineAuthCode;
    }

    /**
     * Set the transactionCertificate.
     *
     * @param string $transactionCertificate
     * @return $this
     */
    public function setTransactionCertificate($transactionCertificate)
    {
        $this->transactionCertificate = (string)$transactionCertificate;
        return $this;
    }

    /**
     * Get the transactionCertificate.
     *
     * @return string
     */
    public function getTransactionCertificate()
    {
        return $this->transactionCertificate;
    }

    /**
     * Set the tsi.
     *
     * @param string $tsi
     * @return $this
     */
    public function setTsi($tsi)
    {
        $this->tsi = (string)$tsi;
        return $this;
    }

    /**
     * Get the tsi.
     *
     * @return string
     */
    public function getTsi()
    {
        return $this->tsi;
    }

    /**
     * Set the tvr.
     *
     * @param string $tvr
     * @return $this
     */
    public function setTvr($tvr)
    {
        $this->tvr = (string)$tvr;
        return $this;
    }

    /**
     * Get the tvr.
     *
     * @return string
     */
    public function getTvr()
    {
        return $this->tvr;
    }

    /**
     * Get the transactionId.
     *
     * @return float
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }
}
