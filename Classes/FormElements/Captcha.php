<?php

namespace Alan\Neos\FormElements;

use Neos\Error\Messages\Error;
use Neos\Flow\Configuration\ConfigurationManager;
use Neos\Form\Core\Model\AbstractFormElement;
use Neos\Form\Core\Runtime\FormRuntime;
use Neos\Flow\Annotations as Flow;
use AlanCaptcha\Php\AlanApi;

class Captcha extends AbstractFormElement
{

    /**
     * @Flow\Inject
     * @var ConfigurationManager
     */
    protected $configurationManager;

    public function getValue()
    {
        return $this->getDefaultValue();
    }

    /**
     * Run sum checks on submit of the captcha field.
     *
     * @param FormRuntime $formRuntime The current form runtime
     * @param mixed $elementValue The transmitted value of the form field.
     *
     * @return void
     */
    public function onSubmit(FormRuntime $formRuntime, &$elementValue)
    {
        $parsedBody = $formRuntime->getRequest()->getHttpRequest()->getParsedBody();

        if (!isset($parsedBody["alan-solution"])) {
            $processingRule = $this
                ->getRootForm()
                ->getProcessingRule($this->getIdentifier());
            $processingRule
                ->getProcessingMessages()
                ->addError(
                    new Error(
                        'Captcha solution missing.',
                        1668767354
                    )
                );
            return;
        }

        $properties = $this->getProperties();

        $alanApi = new AlanApi();
        $validateResult = false;
        try {
            $validateResult = $alanApi->widgetValidate($properties['apiKey'], $parsedBody["alan-solution"]);
        } catch (\InvalidArgumentException $e) {
            $processingRule = $this
                ->getRootForm()
                ->getProcessingRule($this->getIdentifier());
            $processingRule
                ->getProcessingMessages()
                ->addError(
                    new Error(
                        'Captcha fields missing.',
                        1668767354
                    )
                );
            return;
        }

        if (!$validateResult) {
            $processingRule = $this
                ->getRootForm()
                ->getProcessingRule($this->getIdentifier());
            $processingRule
                ->getProcessingMessages()
                ->addError(
                    new Error(
                        'Captcha validation failed.',
                        1668767354
                    )
                );
        }
    }
}
