<?php
namespace Alan\Neos\ViewHelpers;

use Neos\FluidAdaptor\ViewHelpers\Form\AbstractFormViewHelper;
use Neos\FluidAdaptor\ViewHelpers\FormViewHelper;
use Neos\Form\Core\Runtime\FormRuntime;

class AlanViewHelper extends AbstractFormViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'input';

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('name', 'string', 'Name of input tag');
    }

    public function render()
    {
        /* @var $formObject FormRuntime */
        $formObject = $this->viewHelperVariableContainer->get(FormViewHelper::class, 'formObject');
        $captchaElement = $formObject->getFormDefinition()->getElementByIdentifier($this->arguments['name']);

        $this->templateVariableContainer->add('siteKey', $captchaElement->getProperty('siteKey'));
        $this->templateVariableContainer->add('monitorTag', $captchaElement->getProperty('monitorTag'));

        $output = $this->renderChildren();

        $this->templateVariableContainer->remove('siteKey');
        $this->templateVariableContainer->remove('monitorTag');

        return $output;

    }
}
