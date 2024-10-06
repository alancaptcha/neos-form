<?php
namespace Alan\Neos\ViewHelpers;

use Neos\Flow\Annotations as Flow;
use Neos\FluidAdaptor\Core\ViewHelper\AbstractViewHelper;
use Neos\Flow\I18n;

class AlanLanguageViewHelper extends AbstractViewHelper
{
    /**
     * @Flow\Inject
     * @var I18n\Service
     */
    protected $localizationService;

    public function render()
    {
        $locale = $this->localizationService->getConfiguration()->getCurrentLocale();
        $lang =  $locale->getLanguage();

        if (str_starts_with($lang, 'de')) {
            return 'de';
        } else if (str_starts_with($lang, 'en')) {
            return 'en';
        } else {
            return 'en';
        }
    }
}
