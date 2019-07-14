<?php

namespace NovaTesting\Assert;

trait Fields
{
    public function assertFieldExists($attribute)
    {
        return $this->assertJsonFragment([
            'attribute' => $attribute,
        ]);
    }

    public function assertFieldMissing($attribute)
    {
        return $this->assertJsonMissing([
            'attribute' => $attribute,
        ]);
    }

    public function assertFieldEquals($attribute, $value)
    {
        return $this->assertJsonFragment([
            'attribute' => $attribute,
            'value' => $value,
        ]);
    }

    public function assertFieldDoesntEquals($attribute, $value)
    {
        return $this->assertJsonMissing([
            'attribute' => $attribute,
            'value' => $value,
        ]);
    }
}
