# Alan.NeosForm

ALAN Captcha is a privacy-first, GDPR-compliant anti-bot solution that protects Neos website forms like `Neos.Form`, `Neos.Form.Builder` and `Neos.Fusion.Form` from spam, abuse, and attacks.
It is the ultimate captcha solution to safeguard your website and protect user privacy by utilizing unique crypto puzzles based on a proof-of-work mechanism.
This is user-friendly, privacy-preserving reCAPTCHA alternative.
Start protecting logins, forms, and more in minutes. Fully GDPR & WACC compliant!

Please note: You need an ALAN Captcha account to use these package.

For more details, Visit our website at: www.alancaptcha.com

## Installation

ALAN Captcha is available via packagist run `composer require alancaptcha/neos-form`. We use semantic versioning so every breaking change will increase the major-version number.

```bash
composer require alancaptcha/neos-form
```

Create an account on the [AlanCaptcha Admin Panel](https://my.alancaptcha.com/) and get your Site key and Api key. This is further explained in the [AlanCaptcha documentation](https://docs.alancaptcha.com).

## Usage

### [Neos.Form](https://github.com/neos/form)

Just add the new form element to your form definition renderables:
```yaml
label: 'MyLabel'
identifier: myForm
type: 'Neos.Form:Form'
renderables:
  -
    type: 'Neos.Form:Page'
    identifier: page-one
    renderables:
      -
        type: 'Alan.NeosForm:Captcha'
        identifier: captcha
        label: 'Alan Captcha'
        properties:
            apiKey: 'API_KEY'
            siteKey: 'SITE_KEY'
            monitorTag: 'MONITOR_TAG (optional)'
            unverifiedtext: '<<Unverified>>'
            verifiedtext: '<<Verified>>'
            retrytext: '<<Retry>>'
            workingtext: '<<Working...'
            starttext: '<<Start>>'
finishers:
  -
    <Your finishers here>
```

The text properties are optional and can be used to customize the text of the captcha element.

### [Neos.Form.Builder](https://github.com/neos/form-builder)

Add the AlanCaptcha form element to your form:
![AlanCaptcha Form Element](form-builder.png)
Configure the element with your AlanCaptcha Api Key and Site Key.

### [Neos.Fusion.Form](https://github.com/neos/fusion-form)

Add a `FieldContainer` with the `Alan.NeosForm:FusionForm.Captcha` element to your form:

```
<Neos.Fusion.Form:FieldContainer field.name="captcha">
    <Alan.NeosForm:FusionForm.Captcha siteKey="SITE_KEY" />
</Neos.Fusion.Form:FieldContainer>
```

Set the field name based on our needs, but make sure to use the same field name in the schema (see below).

The following options are available:
- `siteKey` (required): The AlanCaptcha Site Key.
- `monitorTag` (optional): The AlanCaptcha Monitor Tag to use.
- `lang.unverifiedtext` (optional): The AlanCaptcha Monitor Tag to use.
- `lang.verifiedtext` (optional)
- `lang.retrytext` (optional)
- `lang.workingtext` (optional)
- `lang.starttext` (optional)

Then, add the field to the schema and configure the Validator:

```
captcha = ${Form.Schema.string().validator('Alan.NeosForm:IsValid', {apiKey: 'API_KEY', errorMessage: 'The Alan Captcha check failed. Try submitting the form again.'})}
```

Make sure that the key (e.g. captcha) matches the key in the FieldContainer (see above).

The following options are available:
- `apiKey` (required): The AlanCaptcha Api Key.
- `errorMessage`: Use this to override the error message in case of a failed captcha check.

## Language Support
The package supports language content dimensions and automatically sets the widget's language based on the language dimension. Currently, only two-character language codes are supported. If a longer identifier (e.g., "en-us") is used, it will be truncated to the first two characters.

## Contribution
Development sponsored by scrinus web&co - Neos CMS Agency in Vienna

