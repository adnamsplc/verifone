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
 * Responsible for abstracting a transaction response.
 *
 * @package    Verifone\Model
 * @copyright  Copyright (c) 2014 Adnams Plc (http://adnams.co.uk)
 */
class TransactionResponseMessage extends AbstractResponseMessage
{
    const AUTH_VALUE_NOT_PROVIDED   = 0;
    const AUTH_VALUE_NOT_CHECKED    = 1;
    const AUTH_VALUE_MATCHED        = 2;
    const AUTH_VALUE_NOT_MATCHED    = 4;
    const AUTH_VALUE_PARTIAL_MATCH  = 8;

    /** @var array */
    private $authResultDescriptionMap = [
        self::AUTH_VALUE_NOT_PROVIDED   => 'Not Provided',
        self::AUTH_VALUE_NOT_CHECKED    => 'Not Checked',
        self::AUTH_VALUE_MATCHED        => 'Matched',
        self::AUTH_VALUE_NOT_MATCHED    => 'Not Matched',
        self::AUTH_VALUE_PARTIAL_MATCH  => 'Partial Match',
    ];

    /**
     * Checks for errors.
     */
    public function init()
    {
        $this->checkForErrors();
    }

    /**
     * Get the transaction result.
     *
     * @return string
     */
    public function getTxnResult()
    {
        return strtoupper((string) $this->getResponseMessage()->txnresult);
    }

    /**
     * Get the CVC result.
     *
     * @return int
     */
    public function getCvcResult()
    {
        return $this->getResponseMessage()->cvcresult;
    }

    /**
     * Get the CVC result description.
     *
     * @return int
     */
    public function getCvcResultDescription()
    {
        return $this->authResultDescriptionMap[(int) $this->getResponseMessage()->cvcresult];
    }

    /**
     * Get the postcode result.
     *
     * @return int
     */
    public function getPostcodeResult()
    {
        return $this->getResponseMessage()->pcavsresult;
    }

    /**
     * Get the postcode result description.
     *
     * @return int
     */
    public function getPostcodeResultDescription()
    {
        return $this->authResultDescriptionMap[(int) $this->getResponseMessage()->pcavsresult];
    }

    /**
     * Get the house number result.
     *
     * @return int
     */
    public function getHouseNumberResult()
    {
        return $this->getResponseMessage()->ad1avsresult;
    }

    /**
     * Get the house number result description.
     *
     * @return int
     */
    public function getHouseNumberResultDescription()
    {
        return $this->authResultDescriptionMap[(int) $this->getResponseMessage()->ad1avsresult];
    }

    /**
     * Check for an error.
     *
     * @return bool
     */
    public function isError()
    {
        return 'ERROR' == $this->getTxnResult();
    }

    /**
     * Check for a referral.
     *
     * @return bool
     */
    public function isReferral()
    {
        return 'REFERRAL' == $this->getTxnResult();
    }

    /**
     * Check for a decline.
     *
     * @return bool
     */
    public function isDeclined()
    {
        return 'DECLINED' == $this->getTxnResult();
    }

    /**
     * Check for a rejection.
     *
     * @return bool
     */
    public function isRejected()
    {
        return 'REJECTED' == $this->getTxnResult();
    }

    /**
     * Check if charged.
     *
     * @return bool
     */
    public function isCharged()
    {
        return 'CHARGED' == $this->getTxnResult();
    }

    /**
     * Check if approved.
     *
     * @return bool
     */
    public function isApproved()
    {
        return 'APPROVED' == $this->getTxnResult();
    }

    /**
     * Check if authorised.
     *
     * @return bool
     */
    public function isAuthorised()
    {
        return 'AUTHORISED' == $this->getTxnResult();
    }

    /**
     * Check for authorisation only.
     *
     * @return bool
     */
    public function isAuthOnly()
    {
        return 'AUTHONLY' == $this->getTxnResult();
    }

    /**
     * Check if comms is down.
     *
     * @return bool
     */
    public function isCommsDown()
    {
        return 'COMMSDOWN' == $this->getTxnResult();
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
     * Was the postcode code submitted?
     *
     * @return bool
     */
    public function isPostcodeNotProvided()
    {
        return self::AUTH_VALUE_NOT_PROVIDED == $this->getPostcodeResult();
    }

    /**
     * Was the postcode not checked?
     *
     * @return bool
     */
    public function isPostcodeNotChecked()
    {
        return self::AUTH_VALUE_NOT_CHECKED == $this->getPostcodeResult();
    }

    /**
     * Is the postcode result a match?
     *
     * @return bool
     */
    public function isPostcodeMatched()
    {
        return self::AUTH_VALUE_MATCHED == $this->getPostcodeResult();
    }

    /**
     * Is the postcode result a failed match?
     *
     * @return bool
     */
    public function isPostcodeNotMatched()
    {
        return self::AUTH_VALUE_NOT_MATCHED == $this->getPostcodeResult();
    }

    /**
     * Is the postcode result a partial match?
     *
     * @return bool
     */
    public function isPostcodePartialMatched()
    {
        return self::AUTH_VALUE_PARTIAL_MATCH == $this->getPostcodeResult();
    }

    /**
     * Was the house number code submitted?
     *
     * @return bool
     */
    public function isHouseNumberNotProvided()
    {
        return self::AUTH_VALUE_NOT_PROVIDED == $this->getHouseNumberResult();
    }

    /**
     * Was the house number not checked?
     *
     * @return bool
     */
    public function isHouseNumberNotChecked()
    {
        return self::AUTH_VALUE_NOT_CHECKED == $this->getHouseNumberResult();
    }

    /**
     * Is the house number result a match?
     *
     * @return bool
     */
    public function isHouseNumberMatched()
    {
        return self::AUTH_VALUE_MATCHED == $this->getHouseNumberResult();
    }

    /**
     * Is the house number result a failed match?
     *
     * @return bool
     */
    public function isHouseNumberNotMatched()
    {
        return self::AUTH_VALUE_NOT_MATCHED == $this->getHouseNumberResult();
    }

    /**
     * Is the house number result a partial match?
     *
     * @return bool
     */
    public function isHouseNumberPartialMatched()
    {
        return self::AUTH_VALUE_PARTIAL_MATCH == $this->getHouseNumberResult();
    }

    /**
     * Was the CVC code given?
     *
     * @return bool
     */
    public function isCvcNotProvided()
    {
        return self::AUTH_VALUE_NOT_PROVIDED == $this->getCvcResult();
    }

    /**
     * Was the CVC code not checked?
     *
     * @return bool
     */
    public function isCvcNotChecked()
    {
        return self::AUTH_VALUE_NOT_CHECKED == $this->getCvcResult();
    }

    /**
     * Is the CVC result a match?
     *
     * @return bool
     */
    public function isCvcMatched()
    {
        return self::AUTH_VALUE_MATCHED == $this->getCvcResult();
    }

    /**
     * Is the CVC result a failed match?
     *
     * @return bool
     */
    public function isCvcNotMatched()
    {
        return self::AUTH_VALUE_NOT_MATCHED == $this->getCvcResult();
    }

    /**
     * Maps a scheme code to it's description.
     *
     * @return string
     */
    public function mapSchemeCodeToDescription()
    {
        $schemeCodeToDescriptionMap = [
            1 => 'Amex',
            2 => 'Visa',
            3 => 'MasterCard/MasterCard One',
            4 => 'Maestro',
            5 => 'Diners',
            6 => 'Visa Debit',
            7 => 'JCB',
            8 => 'BT Test Host',
            9 => 'Time / TradeUK Account card',
            10 => 'Solo (ceased)',
            11 => 'Electron',
            21 => 'Visa CPC',
            23 => 'AllStar CPC',
            24 => 'EDC/Maestro (INT) / Laser',
            26 => 'LTF',
            27 => 'CAF (Charity Aids Foundation)',
            28 => 'Creation',
            29 => 'Clydesdale',
            31 => 'BHS Gold',
            32 => 'Mothercare Card',
            33 => 'Arcadia Group card',
            35 => 'BA AirPlus',
            36 => 'Amex CPC',
            41 => 'FCUK card (Style)',
            48 => 'Premier Inn Business Account card',
            49 => 'MasterCard Debit',
            51 => 'IKEA Home card (IKANO)',
            53 => 'HFC Store card',
            999 => 'Invalid Card Range',
        ];

        $schemeName = (string) $this->getResponseMessage()->schemename;

        if (array_key_exists($schemeName, $schemeCodeToDescriptionMap)) {
            return $schemeCodeToDescriptionMap[$schemeName];
        }

        return $schemeName;
    }

    /**
     * Return the response time of this transaction.
     *
     * @return string
     */
    public function getResponseTime()
    {
        return (string) $this->getResponseMessage()->resultdatetimestring;
    }

    /**
     * Convert the response message to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'transactionId' => (int) $this->getResponseMessage()->transactionid,
            'resultDateTimeString' => (string) $this->getResponseMessage()->resultdatetimestring,
            'processingDb' => (string) $this->getResponseMessage()->processingdb,
            'errorMsg' => (string) $this->getResponseMessage()->errormsg,
            'merchantNumber' => (string) $this->getResponseMessage()->merchantnumber,
            'tid' => (string) $this->getResponseMessage()->tid,
            'schemeName' => $this->mapSchemeCodeToDescription(),
            'messageNumber' => (string) $this->getResponseMessage()->messagenumber,
            'authCode' => (string) $this->getResponseMessage()->authcode,
            'authMessage' => (string) $this->getResponseMessage()->authmessage,
            'vrTel' => (string) $this->getResponseMessage()->vrtel,
            'txnResult' => (string) $this->getTxnResult(),
            'pcAvsResult' => (int) $this->getResponseMessage()->pcavsresult,
            'ad1AvsResult' => (int) $this->getResponseMessage()->ad1avsresult,
            'cvcResult' => (int) $this->getCvcResult(),
            'arc' => (string) $this->getResponseMessage()->arc,
            'iadArc' => (string) $this->getResponseMessage()->iadarc,
            'iadOad' => (string) $this->getResponseMessage()->iadoad,
            'isd' => (string) $this->getResponseMessage()->isd,
            'authorisingEntity' => (int) $this->getResponseMessage()->authorisingentity,
        );
    }

    /**
     * Raises an error.
     *
     * @throws
     */
    protected function raiseError()
    {
        if ($this->isError()) {
            throw new \RuntimeException(
                (string) $this->getAuthMessage(),
                (int) $this->getMessageNumber()
            );
        }
    }
}
