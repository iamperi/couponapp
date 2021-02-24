<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Tienes que aceptar :attribute.',
    'active_url' => ':attribute no es una URL válida.',
    'after' => ':attribute tiene que ser una fecha posterior a :date.',
    'after_or_equal' => ':attribute tiene que ser una fecha posterior o igual a :date.',
    'alpha' => ':attribute solo puede contener letras.',
    'alpha_dash' => ':attribute solo puede contener letras, números, guiones y guiones bajos.',
    'alpha_num' => ':attribute solo puede contener letras y números.',
    'array' => ':attribute tiene que ser un array.',
    'before' => ':attribute tiene que ser una fecha anterior a :date.',
    'before_or_equal' => ':attribute tiene que ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => ':attribute tiene que estar entre :min y :max.',
        'file' => ':attribute tiene que estar entre :min y :max kilobytes.',
        'string' => ':attribute tiene que estar entre :min y :max characters.',
        'array' => ':attribute tiene que tener entre :min y :max items.',
    ],
    'boolean' => ':attribute tiene que ser true o false.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'date' => ':attribute no es una fecha válida.',
    'date_equals' => ':attribute tiene que ser una fecha igual a :date.',
    'date_format' => ':attribute no coincide con el formato :format.',
    'different' => ':attribute y :other tienen que ser diferentes.',
    'digits' => ':attribute tiene que tener :digits dígitos.',
    'digits_between' => ':attribute tiene que estar entre :min y :max dígitos.',
    'dimensions' => 'Las dimensiones de :attribute no son válidas',
    'distinct' => ':attribute tiene un valor duplicado.',
    'email' => ':attribute tiene que ser un email válido.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'exists' => ':attribute no es válido.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => ':attribute es obligatorio.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'code' => [
            'required' => 'Introduce un código de cupón'
        ],
        'coupon_amount' => [
            'required' => 'Introduce una cantidad',
            'number' => 'Escribe un número válido',
        ],
        'coupon_count' => [
            'required' => 'Escribe el nº de cupones que quieres crear',
            'integer' => 'Escribe un número válido',
            'min' => 'Mínimo 1 cupón'
        ],
        'coupon_validity' => [
            'required' => 'Escribe la validez de cada cupón',
            'integer' => 'Escribe un número válido',
            'min' => 'Mínimo 1 hora'
        ],
        'dni' => [
            'required' => 'Escribe tu D.N.I.',
            'max' => 'Máximo 9 caracteres'
        ],
        'email' => [
            'required' => 'Escribe un email',
            'email' => 'Escribe un email válido',
            'unique' => 'Ya existe un usuario con ese email'
        ],
        'last_name' => [
            'required' => 'Escribe tus apellidos'
        ],
        'limit_per_person' => [
            'required' => 'Escribe un número',
            'integer' => 'Escribe un número válido',
            'min' => 'Mínimo 1 cupón'
        ],
        'name' => [
            'required' => 'Escribe un nombre',
            'unique' => 'Ese nombre ya está en uso'
        ],
        'password' => [
            'required' => 'Escribe una contraseña',
            'confirmed' => 'Las contraseñas no coinciden'
        ],
        'phone' => [
            'required' => 'Escribe un teléfono',
            'unique' => 'Ya existe un usuario con ese teléfono',
            'max' => 'Máximo 9 caracteres'
        ],
        'prefix' => [
            'required' => 'Escribe un prefijo',
            'size' => 'El prefijo tiene que tener 3 caracteres'
        ],
        'starts_at' => [
            'required' => '¿Cuándo empieza la campaña?'
        ],
        'username' => [
            'required' => 'Escribe un nombre de usuario',
            'unique' => 'Ese nombre de usuario ya está en uso'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
