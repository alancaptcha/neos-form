<?php

namespace Alan\NeosForm\Validation\Validator;

use AlanCaptcha\Php\AlanApi;
use Neos\Flow\Validation\Validator\AbstractValidator;

class IsValidValidator extends AbstractValidator
{

    /**
     * @var boolean
     */
    protected $acceptsEmptyValues = false;

    /**
     * @var array
     */
    protected $supportedOptions = [
        'apiKey' => ['', 'The Api Key for Alan Captcha', 'string', true],
        'errorMessage' => ['', 'A custom error message if the check fails', 'string', false]
    ];

    /**
     *
     * @param mixed $value The value that should be validated
     *
     * @return void
     * @throws \Neos\Flow\Validation\Exception\InvalidValidationOptionsException
     * @api
     */
    protected function isValid($value)
    {
        if (!is_string($value)) {
            $this->addError('The given value was not a valid string.', 1728420822);
            return;
        }

        $alanApi = new AlanApi();

        $validateResult = false;

        if (!empty($value)) {
            try {
                $validateResult = $alanApi->widgetValidate($this->options['apiKey'], $value);
            } catch (\InvalidArgumentException $e) {
                $validateResult = false;
            }
        }

        $errorMessage = !empty($this->options['errorMessage']) ? $this->options['errorMessage'] : 'Captcha validation failed.';

        if ($validateResult === false) {
            $this->addError($errorMessage, 1728420822);
        }
    }
}
