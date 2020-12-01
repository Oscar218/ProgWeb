<?php
abstract class Shared
{
    protected $options = array();

    public function show($key)
    {
        if (!isset($this->options[$key])) {
            return null;
        }
        return $this->options[$key];
    }

    public function isValid($key)
    {
        return in_array($key, array_keys($this->options));
    }

    abstract public function input($default = null);
}

class Country extends Shared
{
    protected $options = array(
        'DE' => 'Despesa Pontual',
        'IM' => 'Impostos',
        'FA' => 'Faturas',
        'SA' => 'Salario',
        'BO' => 'Bonus',
        'JE' => 'Job 7 Extra',
    );

    public function input($default = null)
    {
        $result = '<select name="country">';
        foreach ($this->options as $value => $label) {
            $selected = $default == $value ? 'selected' : '';
            $result .= "<option type='radio' name='gender' value='$value' $selected>";
            $result .= $label;
            $result .= '</option>';
        }
        $result .= '</select>';
        return $result;
    }

}


class Gender extends Shared
{
    protected $options = array(
        'M' => 'Mes',
        'A' => 'Ano',
    );

    public function input($default = null)
    {
        $result = '<input name="gender" type="hidden" value=""/>';
        foreach ($this->options as $value => $label) {
            $checked = $default == $value ? 'checked' : '';
            $result .= '<label class="radio">';
            $result .= "<input type='radio' name='gender' value='$value' $checked> $label";
            $result .= '</label>';
        }
        return $result;
    }
}