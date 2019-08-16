<?php

namespace NovaTesting\Assert;

use Illuminate\Support\Collection;

trait AssertFields
{
    // ['id' => 1, 'email' => 'emai']
    // ^ should be on one row; not multiple assertions

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
        if ($attribute instanceof Collection) {
            $attribute = $attribute->toArray();
        }

        if ($value instanceof Collection) {
            $value = $value->toArray();
        }

        // ->assertFieldsInclude('id')
        if (!is_array($attribute) && is_null($value)) {
            return $this->assertFieldAttribute($attribute, $method);
        }

        // ->assertFieldsInclude('id', [1,2,3])
        if (!is_array($attribute) && is_array($value)) {
            return $this->assertFieldManyValues($attribute, $value, $method);
        }

        // ->assertFieldsInclude('id', 1)
        if (!is_array($attribute) && !is_null($value)) {
            return $this->assertFieldValue($attribute, $value, $method);
        }

        // ->assertFieldsInclude(['id', 'email'])
        if (is_array($attribute) && is_numeric(array_keys($attribute)[0])) {
            return $this->assertFieldKeys($attribute, $method);
        }

        // ->assertFieldsInclude(['id' => 1])
        if (is_array($attribute)) {
            return $this->assertFieldKeyValue($attribute, $method);
        }

        return $this;
    }

    public function assertFieldAttribute($attribute, $method)
    {
        return $this->$method([
            'attribute' => $attribute
        ]);
    }

    public function assertFieldValue($attribute, $value, $method)
    {
        return $this->$method([
            'attribute' => $attribute,
            'value' => $value,
        ]);
    }

    public function assertFieldManyValues($attribute, array $value, $method)
    {
        foreach ($value as $v) {
            $this->assertFieldValue($attribute, $v, $method);
        }

        return $this;
    }

    public function assertFieldKeys(array $keys, $method)
    {
        foreach ($keys as $key) {
            $this->assertFieldAttribute($key, $method);
        }

        return $this;
    }

    public function assertFieldKeyValue($attribute, $method)
    {
        foreach ($attribute as $attr => $value) {
            $this->assertFieldValue($attr, $value, $method);
        }

        return $this;
    }
}
