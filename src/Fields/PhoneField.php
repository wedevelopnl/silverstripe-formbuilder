<?php

namespace TheWebmen\Formbuilder\Fields;

use SilverStripe\Core\Config\Configurable;

class PhoneField extends \SilverStripe\Forms\TextField
{
    use Configurable;

    /**
     * {@inheritdoc}
     */
    public function Type()
    {
        return 'phone number';
    }

    /**
     * Validates for RFC 2822 compliant email addresses.
     *
     * @see http://www.regular-expressions.info/email.html
     * @see http://www.ietf.org/rfc/rfc2822.txt
     *
     * @param Validator $validator
     *
     * @return string
     */
    public function validate($validator)
    {
        $this->value = trim($this->value);

        $pattern = '^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$';

        $validationPattern = self::config()->get('validation_pattern');
        if (!is_null($validationPattern))
            $pattern = $validationPattern;

        if (!is_array($pattern))
        {
            if ($this->value && !preg_match('/' . $pattern . '/i', $this->value))
            {
                $validator->validationError(
                    $this->name,
                    _t('SilverStripe\\Forms\\PhoneField.VALIDATION', 'Please enter a valid phonenumber.'),
                    'validation'
                );

                return false;
            }
        }
        else
        {
            foreach ($pattern as $idx => $item)
            {
                $pattern[$idx] = ($this->value && preg_match('/' . $item . '/i', $this->value));
            }

            if (array_search(true, $pattern) === false)
            {
                $validator->validationError(
                    $this->name,
                    _t('SilverStripe\\Forms\\PhoneField.VALIDATION', 'Please enter a valid phonenumber.'),
                    'validation'
                );

                return false;
            }
        }

        return true;
    }

    public function getSchemaValidation()
    {
        $rules = parent::getSchemaValidation();
        $rules['phone'] = true;
        return $rules;
    }
}
