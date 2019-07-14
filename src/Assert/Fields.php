<?php

namespace NovaTesting\Assert;

trait Fields
{
    public function assertFieldsInclude($attribute, $value=null)
    {
        return $this->fieldCheck($attribute, $value, 'assertJsonFragment');
    }

    public function assertFieldsExclude($attribute, $value=null)
    {
        return $this->fieldCheck($attribute, $value, 'assertJsonMissing');
    }

    protected function fieldCheck($attribute, $value = null, $method)
    {
        if (!is_array($field) && is_null($value)) {
            return $this->$method([
                'attribute' => $attribute
            ]);
        }

        if (!is_array($field) && !is_null($value)) {
            return $this->$method([
                'attribute' => $attribute,
                'value' => $value,
            ]);
        }

        foreach ($attribute as $attr => $value) {
            if (is_numeric($attr)) {
                $this->$method([
                    'attribute' => $value
                ]);
            } else {
                $this->$method([
                    'attribute' => $attr,
                    'value' => $value,
                ]);
            }
        }

        return $this;
    }
}
