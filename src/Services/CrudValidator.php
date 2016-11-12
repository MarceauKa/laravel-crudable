<?php

namespace Akibatech\Crud\Services;

use Akibatech\Crud\Exceptions\FailedValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class CrudValidator
 *
 * @package Akibatech\Crud\Services
 */
class CrudValidator
{
    /**
     * @var CrudEntry
     */
    protected $entry;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var array
     */
    protected $form_data;

    /**
     * CrudValidator constructor.
     *
     * @param   void
     */
    public function __construct(CrudEntry $entry)
    {
        $this->setEntry($entry);
    }

    /**
     * Defines the CrudEntry to validate.
     *
     * @param   CrudEntry $entry
     * @return  self
     */
    public function setEntry(CrudEntry $entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Gets the entry.
     *
     * @param   void
     * @return  CrudEntry
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param   array $data
     * @return  self
     */
    public function setFormData(array $data)
    {
        $this->form_data = $data;

        return $this;
    }

    /**
     * @param   Request $request
     * @return  self
     */
    public function validateRequest(Request $request)
    {
        return $this->validate($request->only($this->getEntry()->getFields()->keys()));
    }

    /**
     * Validate given array of data against fields rules.
     *
     * @param   array $fields_data
     * @return  self
     */
    public function validate(array $fields_data)
    {
        $rules = $this->getEntry()->getFields()->validationRules();
        $this->setFormData($fields_data);

        $this->validator = Validator::make($fields_data, $rules);
        $this->validator = $this->getEntry()->getFields()->contextualValidationRules($this->validator);
        $this->validator->fails();

        return $this;
    }

    /**
     * @param   void
     * @return  bool
     */
    public function fails()
    {
        return count($this->validator->failed()) === 0 ? false : true;
    }

    /**
     * @param   void
     * @return  bool
     */
    public function passes()
    {
        return $this->validator->fails() === false;
    }

    /**
     * @param   void
     * @return  RedirectResponse
     */
    public function redirect()
    {
        if ($this->fails())
        {
            return redirect()->back()->withInput()->withErrors($this->validator);
        }

        return redirect($this->entry->getManager()->getActionRoute('index'));
    }

    /**
     * @param   void
     * @return  bool
     * @throws  FailedValidationException
     */
    public function save()
    {
        if ($this->fails())
        {
            throw new FailedValidationException("Entry has failed its validation and can't be saved.");
        }

        $this->entry->getFields()->hydrateFormData($this->form_data);

        return $this->entry->save();
    }

    /**
     * @param   void
     * @return  self
     */
    protected function resetValidator()
    {
        $this->validator = null;
        $this->form_data = null;
        $this->getEntry()->resetValidator();

        return $this;
    }
}
