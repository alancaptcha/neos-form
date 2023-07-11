<?php

namespace Alan\Neos\FormElements;

use Neos\Error\Messages\Error;
use Neos\Flow\Configuration\ConfigurationManager;
use Neos\Form\Core\Model\AbstractFormElement;
use Neos\Form\Core\Runtime\FormRuntime;
use Neos\Flow\Annotations as Flow;

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
        $payload = json_decode($formRuntime->getRequest()->getHttpRequest()->getParsedBody()["alan-solution"], true);
        if (!isset($payload["jwt"], $payload["solutions"])) {
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
            return;
        }
        $settings = $this->configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_SETTINGS, "Alan.Neos");
        $ch = curl_init("https://api.alancaptcha.com/challenge/validate");
        $httpPayload = json_encode([
            "key" => $settings['apiKey'],
            "puzzleSolutions" => $payload["solutions"],
            'jwt' => $payload['jwt'],
        ]);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $httpPayload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        if (!isset($result["success"]) || $result["success"] == false) {
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
