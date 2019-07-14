<?php

namespace NovaTesting\Assert;

trait Fields
{
    public function assertFieldExists($attribute)
    {
        return $this->assertJsonFragment([ 'fields' => [
            'attribute' => $attribute
        ]]);
    }

    public function assertFieldEquals($attribute, $value)
    {
        return $this->assertJsonFragment([
            'attribute' => $attribute,
            'value' => $value,
        ]);
    }
}
