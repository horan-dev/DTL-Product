<?php

namespace Shared\Bases;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseFactory extends Factory
{
    private array $fields = [];

    public function definition(): array
    {
        return $this->overwriteModelFields($this->getFields());
    }

    public function overwrite(array $values = []): static
    {
        $clone = clone $this;
        $clone->setFields($values);
        return $clone;
    }

    protected function setFields(array $values = []): void
    {
        $this->fields = array_merge($this->getFields(), $values);
    }

    protected function getFields(): array
    {
        return array_merge($this->fields(), $this->fields);
    }

    private function overwriteModelFields(array $defaultModelFields): array
    {
        foreach ($defaultModelFields as &$field) {
            $field = $this->overwriteField($field, $defaultModelFields);
        }

        return $defaultModelFields;
    }

    private function overwriteField($field, array $defaultModelFields)
    {
        if ($this->isModel($field)) {
            return $field->getKey();
        }

        if ($this->isFactory($field)) {
            return $field->create()->getKey();
        }

        if ($this->isCallable($field)) {
            return $field($defaultModelFields);
        }

        return $field;
    }

    private static function isFactory($item): bool
    {
        return $item instanceof Factory;
    }

    private static function isModel($item): bool
    {
        return $item instanceof Model;
    }

    private static function isCallable($field): bool
    {
        return is_callable($field) && !is_string($field) && !is_array($field);
    }

    abstract public function fields(): array;
}
