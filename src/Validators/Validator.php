<?php

namespace Sprocketbox\Toolkit\Validators;

use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

abstract class Validator
{
    /**
     * @param array                                    $data
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @param array                                    $extra
     *
     * @return \Sprocketbox\Toolkit\Validators\Validator
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function validate(array $data = [], ?Model $model = null, array $extra = []): Validator
    {
        $validator = new static($data, $model);
        $validator->setExtra($extra);
        $validator->fire();

        return $validator;
    }

    /**
     * @var \Illuminate\Database\Eloquent\Model|mixed
     */
    protected $model;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var array
     */
    protected array $extra = [];

    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    protected ?ValidatorContract $validator = null;

    /**
     * BaseValidator constructor.
     *
     * @param array      $data
     * @param Model|mixed|null $model
     */
    private function __construct(array $data = [], $model = null)
    {
        $this->data  = $data;
        $this->model = $model;
    }

    /**
     * @return array
     */
    abstract public function rules(): array;

    public function setExtra(array $extra): void
    {
        $this->extra = $extra;
    }

    /**
     * @return array
     */
    protected function attributes(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return $this->data;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failed(): void
    {
        throw new ValidationException($this->validator);
    }

    /**
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function fire(): bool
    {
        $validator = $this->validator();
        $this->preValidation();

        if ($validator->fails()) {
            $this->failed();
        }

        return true;
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function makeValidator(): ValidatorContract
    {
        $factory = Container::getInstance()->make(Factory::class);

        return $factory->make($this->data(), $this->rules(), $this->messages(), $this->attributes());
    }

    /**
     * @return array
     */
    protected function messages(): array
    {
        return [];
    }

    protected function preValidation(): void
    {
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function validator(): ValidatorContract
    {
        if (! $this->validator) {
            $this->validator = $this->makeValidator();
        }

        return $this->validator;
    }
}