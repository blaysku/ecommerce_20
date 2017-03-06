<?php

namespace App\Services;

use Form;

class FormMaker
{
    public static function boot()
    {
        Form::component('destroyBootstrap', 'components.destroy', [
            'value',
            'message',
            'class' => '',
        ]);

        Form::component('controlBootstrap', 'components.control', [
            'type',
            'name',
            'errors',
            'label' => null,
            'value' => null,
            'placeholder' => null,
            'columns' => null,
            'pop' => null,
        ]);

        Form::component('checkboxBootstrap', 'components.checkbox', [
            'name',
            'label',
            'checked' => false,
            'columns' => null,
        ]);

        Form::component('selectBootstrap', 'components.select', [
            'name',
            'list' => [],
            'label' => null,
            'selected' => null,
            'columns' => null,
        ]);
    }
}
