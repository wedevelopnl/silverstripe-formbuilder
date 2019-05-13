<?php

namespace TheWebmen\Formbuilder\Fields;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

class ModelDropdownField extends \SilverStripe\Forms\DropdownField
{
    private $_overrideValidator = false;
    private static $_fieldsSetToDefault = 0;
    private $_customErrorMessage = false;

    /**
     * @param mixed $customErrorMessage
     */
    public function setCustomErrorMessage($customErrorMessage)
    {
        $this->_customErrorMessage = $customErrorMessage;
    }

    /**
     * @return mixed
     */
    public function getCustomErrorMessage()
    {
        return $this->_customErrorMessage;
    }

    public function setOverrideValidator($bool)
    {
        $this->_overrideValidator = $bool;
    }

    public function getOverrideValidator()
    {
        return $this->_overrideValidator;
    }

    public function validate($validator)
    {
        $val = trim($this->value);

        if ($val == $this->getEmptyString())
        {
            // We want to deny validation but not display a message
            if (self::$_fieldsSetToDefault > 0)
                return false;

            $validator->validationError(
                $this->name,
                $this->_customErrorMessage !== false ? $this->_customErrorMessage : _t(
                    'SilverStripe\\Forms\\ModelDropdownField.SOURCE_VALIDATION',
                    "Please select a value within the list provided. {value} is not a valid option",
                    array('value' => $val)
                ),
                "validation"
            );

            self::$_fieldsSetToDefault++;

            return false;
        }

        return true;
    }

    public static function get_allowed_models()
    {
        $models = self::get_config_data()->get('models');

        $return = ArrayList::create();

        foreach ($models as $model)
        {
            $model = reset($model);
            $return->push(new ArrayData(['class' => $model['class'], 'name' => (new $model['class']())->plural_name()]));
        }

        return $return;
    }

    public static function get_config_data()
    {
        return self::config();
    }

    public static function get_frontend_javascript($config = [])
    {
        $extraScript = <<<EOS
<script type="text/javascript">
    $(function()
    {
        $('option', '[data-relation-dropdown=parent]').each(function()
        {
            var id = $(this).val();
            $(this).val($(this).text()).data('id', id);
        });
        
        $('[data-relation-dropdown=parent]').on('change', function(evt)
        {
            var id = $('option:selected', this).data('id');
            var model = $(this).data('data');
            
            var child = $('[data-relation-dropdown=child][data-data='+model+']');
            $(child).empty();
            $(window[model][id]).each(function()
            {
                $('<option>').val(this.Key).text(this.Value).appendTo(child);
            });
        });
    });
</script>
EOS;

        if (isset($config['relation']) &&
            isset($config['relation']['hideOnNoValue']) &&
            $config['relation']['hideOnNoValue'])
        {
            $extraScript .= <<<EOS
<script type="text/javascript">
    $(function()
    {
        $('[data-relation-dropdown=child]').hide();
        
        $('[data-relation-dropdown=parent]').on('change', function(evt)
        {
            if (this.selectedIndex > 0)
            {
                $('[data-relation-dropdown=child]').show();
            }
            else 
            {
                $('[data-relation-dropdown=child]').hide();
            }
        });
    });
</script>
EOS;

        }

        return $extraScript;
    }

}