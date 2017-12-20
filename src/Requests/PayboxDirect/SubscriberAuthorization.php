<?php

namespace Bnb\PayboxGateway\Requests\PayboxDirect;

use Bnb\PayboxGateway\ActivityCode;
use Bnb\PayboxGateway\QuestionTypeCode;
use Bnb\PayboxGateway\Responses\PayboxDirect\SubscriberAuthorization as SubscriberAuthorizationResponse;
use Carbon\Carbon;

class SubscriberAuthorization extends SubscriberRequest
{

    /**
     * @var string
     */
    protected $cardExpirationDate = null;

    /**
     * @var string
     */
    protected $cardControlNumber = null;

    /**
     * @var string
     */
    protected $activity = ActivityCode::UNSPECIFIED;


    /**
     * Set card expiration date provided by the customer.
     *
     * @param Carbon $cardExpirationDate
     *
     * @return $this
     */
    public function setCardExpirationDate(Carbon $cardExpirationDate)
    {
        $this->cardExpirationDate = $cardExpirationDate->format('dy');

        return $this;
    }


    /**
     * Set card control number (CVV) provided by the customer.
     *
     * @param string $cardControlNumber
     *
     * @return $this
     */
    public function setCardControlNumber($cardControlNumber)
    {
        $this->cardControlNumber = $cardControlNumber;

        return $this;
    }


    /**
     * Set operation activity code
     *
     * @param string $activity
     *
     * @return $this
     *
     * @see ActivityCode
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;

        return $this;
    }


    /**
     * Get parameters that will be send to Paybox Direct.
     *
     * @return array
     */
    public function getBasicParameters()
    {
        return [
            'MONTANT' => $this->amount,
            'DEVISE' => $this->currencyCode,
            'REFERENCE' => $this->paymentNumber,
            'REFABONNE' => $this->subscriberNumber,
            'PORTEUR' => $this->subscriberWallet,
            'DATEVAL' => $this->cardExpirationDate,
            'CVV' => $this->cardControlNumber,
            'ACTIVITE' => $this->activity,
        ];
    }


    /**
     * @inheritdoc
     */
    public function getQuestionType()
    {
        return QuestionTypeCode::SUBSCRIBER_AUTHORIZATION_ONLY;
    }


    /**
     * @inheritdoc
     */
    public function getResponseClass()
    {
        return SubscriberAuthorizationResponse::class;
    }

}