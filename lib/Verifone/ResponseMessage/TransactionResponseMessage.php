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
     * Was the CVC code given?
     *
     * @return bool
     */
    public function isCvcNotProvided()
    {
        return 0 == $this->getCvcResult();
    }

    /**
     * Was the CVC code not checked?
     *
     * @return bool
     */
    public function isCvcNotChecked()
    {
        return 1 == $this->getCvcResult();
    }

    /**
     * Is the CVC result a match?
     *
     * @return bool
     */
    public function isCvcMatched()
    {
        return 2 == $this->getCvcResult();
    }

    /**
     * Is the CVC result a failed match?
     *
     * @return bool
     */
    public function isCvcNotMatched()
    {
        return 4 == $this->getCvcResult();
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
