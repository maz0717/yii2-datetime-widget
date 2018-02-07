<?php

namespace trntv\yii\datetime;

use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\base\ModelEvent;
use Expression;


class DateTimeBehavior extends Behavior {

    /**
     * @var string
     */
    // TODO: unify Widget and Behavior config for formats
    public $datetimeFormat = 'm/d/Y h:i:s a O';

    /**
     * @var array
     */
    public $dateTimeAttributes = [];

    /**
     * @var string
     */
    public $saveFormat = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    public $saveFormatRegex = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';

    /**
     * @var string
     */
    public $saveTimezone = 'UTC';

    public function events() {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }

    /**
     * @param ModelEvent $event
     */
    public function beforeSave($event) {

        foreach($this->dateTimeAttributes as $dateField) {
            $field = $this->owner->$dateField;

            // Skip if blank
            if(!$field) {
                continue;
            }

            // Skip expressions;
            if ($field instanceof Expression || strpos($field, '(') !== false) {
                continue;
            }

            // Skip if already the save format
            if(preg_match($this->saveFormatRegex,$field)) {
                continue;
            }

            $date = \DateTime::createFromFormat($this->datetimeFormat,$field);
            if(!$date) {
                // TODO
                echo $field . PHP_EOL;
                echo var_dump(\DateTime::getLastErrors());
                exit;
            }
            $date->setTimezone(new \DateTimeZone($this->saveTimezone));
            $this->owner->$dateField = $date->format($this->saveFormat);
        }
    }



}
