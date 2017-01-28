<?php

namespace Akibatech\Crud\Fields;

use Akibatech\Crud\Exceptions\InvalidArgumentException;
use Carbon\Carbon;
use Illuminate\Validation\Validator;

/**
 * Class TinymceField
 *
 * @package Akibatech\Crud\Fields
 */
class DatePickerField extends Field
{
    /**
     * @var string
     */
    const TYPE = 'date-picker';

    /**
     * @var string
     */
    protected $date_format = 'Y-m-d';

    /**
     * @var null|string
     */
    protected $date_min = null;

    /**
     * @var null|string
     */
    protected $date_max = null;

    /**
     * {@inheritdoc}
     */
    public function getViewName()
    {
        return 'crud::fields.date-picker';
    }

    /**
     * @param   string $format
     * @return  self
     */
    public function withDateFormat($format)
    {
        $this->date_format = $format;

        return $this;
    }

    /**
     * @param   string|Carbon $date
     * @return  self
     * @throws  InvalidArgumentException
     */
    public function withMinDate($date)
    {
        if ($date instanceof Carbon)
        {
            $this->date_min = $date->format($this->date_format);
        }
        else if (is_string($date))
        {
            $this->date_min = $date;
        }
        else
        {
            throw new InvalidArgumentException("Min date must be a string or a Carbon instance.");
        }

        return $this;
    }

    /**
     * @param   string|Carbon $date
     * @return  self
     * @throws  InvalidArgumentException
     */
    public function withMaxDate($date)
    {
        if ($date instanceof Carbon)
        {
            $this->date_max = $date->format($this->date_format);
        }
        else if (is_string($date))
        {
            $this->date_max = $date;
        }
        else
        {
            throw new InvalidArgumentException("Max date must be a string or a Carbon instance.");
        }

        return $this;
    }

    /**
     * @param   void
     * @return  array
     */
    public function getViewVariables()
    {
        $locale = config('app.locale');

        return [
            'date_format' => self::dateFormatJs($this->date_format),
            'date_min'    => $this->date_min,
            'date_max'    => $this->date_max,
            'date_locale' => $locale != 'en' ? $locale : false
        ];
    }

    /**
     * @param   Validator $validator
     * @return  Validator
     */
    public function beforeValidation(Validator $validator)
    {
        $rules = [];

        $rules[] = 'date_format:' . $this->date_format;

        if (!is_null($this->date_min))
        {
            $date = Carbon::createFromFormat($this->date_format, $this->date_min)->subDay()->format($this->date_format);
            $rules[] = 'after:' . $date;
        }

        if (!is_null($this->date_max))
        {
            $date = Carbon::createFromFormat($this->date_format, $this->date_max)->addDay()->format($this->date_format);
            $rules[] = 'before:' . $date;
        }

        $this->mergeRules($validator, $rules);

        return $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function getCss()
    {
        return [
            'vendor/crud/fields/datepicker/bootstrap-datepicker3.min.css',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getScripts()
    {
        $locale = config('app.locale');
        $base = ['vendor/crud/fields/datepicker/bootstrap-datepicker.min.js'];
        $extend = [];

        if ($locale != 'fr')
        {
            $extend[] = "vendor/crud/fields/datepicker/bootstrap-datepicker.$locale.min.js";
        }


        return array_merge($base, $extend);
    }

    /**
     * Convert a PHP date format to a JS date format.
     *
     * @param   string  $format
     * @return  string
     */
    public static function dateFormatJs($format)
    {
        $replacements = [
            'd' => 'dd',
            'j' => 'd',
            'D' => 'D',
            'l' => 'DD',
            'm' => 'mm',
            'n' => 'm',
            'M' => 'M',
            'F' => 'MM',
            'y' => 'yy',
            'Y' => 'yyyy',
        ];

        foreach ($replacements as $old => $new)
        {
            $format = preg_replace("#($old){1}#", $new, $format);
        }

        return $format;
    }
}
