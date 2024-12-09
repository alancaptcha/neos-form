<?php
namespace Alan\NeosForm\ViewHelpers;

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
        $this->templateVariableContainer->add('lang', $captchaElement->getProperty('lang'));
        $this->templateVariableContainer->add('uniqueIdentifier', $captchaElement->getUniqueIdentifier());
        $this->templateVariableContainer->add('identifier', $captchaElement->getIdentifier());

        $output = $this->renderChildren();

        $this->templateVariableContainer->remove('siteKey');
        $this->templateVariableContainer->remove('monitorTag');
        $this->templateVariableContainer->remove('lang');
        $this->templateVariableContainer->remove('uniqueIdentifier');
        $this->templateVariableContainer->remove('identifier');

        return $output;

    }
}
