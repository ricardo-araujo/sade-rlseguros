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

    'accepted'             => 'O campo :attribute deve ser aceito.',
    'active_url'           => 'O campo :attribute não é uma URL válida.',
    'after'                => 'O campo :attribute deve ser uma data após :date.',
    'after_or_equal'       => 'O campo :attribute deve ser uma data igual ou após :date.',
    'alpha'                => 'O campo :attribute deve conter apenas letras.',
    'alpha_dash'           => 'O campo :attribute deve conter apenas letras, números e traços.',
    'alpha_num'            => 'O campo :attribute deve conter apenas letras e números.',
    'array'                => 'O campo :attribute deve ser um array.',
    'before'               => 'O campo :attribute deve ser uma data anterior a :date.',
    'before_or_equal'      => 'O campo :attribute deve ser uma data igual ou anterior a :date.',
    'between'              => [
        'numeric' => 'O campo :attribute deve ter entre :min e :max.',
        'file'    => 'O campo :attribute deve ter entre :min e :max kb.',
        'string'  => 'O campo :attribute deve ter entre :min e :max caracteres.',
        'array'   => 'O campo :attribute deve ter entre :min e :max itens.',
    ],
    'boolean'              => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed'            => 'A confirmação do campo :attribute não é válida.',
    'date'                 => 'O campo :attribute não é uma data válida.',
    'date_format'          => 'O campo :attribute não tem o mesmo formato de :format.',
    'different'            => 'O campo :attribute e :other devem ser diferentes.',
    'digits'               => 'O campo :attribute deve ter :digits digitos.',
    'digits_between'       => 'O campo :attribute deve ter entre :min e :max digitos.',
    'dimensions'           => 'O campo :attribute tem dimensões de imagem inválidas.',
    'distinct'             => 'O campo :attribute tem valores duplicados.',
    'email'                => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'exists'               => 'O campo :attribute selecionado é inválido.',
    'file'                 => 'O campo :attribute deve ser um arquivo.',
    'filled'               => 'O campo :attribute deve ter um valor.',
    'image'                => 'O campo :attribute deve ser uma imagem.',
    'in'                   => 'O campo selecionado :attribute é inválido.',
    'in_array'             => 'O campo :attribute não existe em :other.',
    'integer'              => 'O campo :attribute deve ser um inteiro.',
    'ip'                   => 'O campo :attribute deve ser um endereço de IP válido.',
    'ipv4'                 => 'O campo :attribute deve ser um endereço de IPv4 válido.',
    'ipv6'                 => 'O campo :attribute deve ser um endereço de IPv6 válido.',
    'json'                 => 'O campo :attribute deve ser um JSON válido.',
    'max'                  => [
        'numeric' => 'O campo :attribute não deve ser maior que :max.',
        'file'    => 'O campo :attribute não deve ser maior que :max kb.',
        'string'  => 'O campo :attribute não deve ser maior que :max caracteres.',
        'array'   => 'O campo :attribute não deve ter mais que :max itens.',
    ],
    'mimes'                => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'mimetypes'            => 'O campo :attribute deve ser um arquivo do tipo: :values.',
    'min'                  => [
        'numeric' => 'O campo :attribute deve ter no mínimo :min.',
        'file'    => 'O campo :attribute deve ter no mínimo :min kb.',
        'string'  => 'O campo :attribute deve ter no mínimo :min caracteres.',
        'array'   => 'O campo :attribute deve ter no mínimo :min itens.',
    ],
    'not_in'               => 'O campo :attribute selecionado é inválido.',
    'not_regex'            => 'O formato do campo :attribute é inválido.',
    'numeric'              => 'O campo :attribute de ser um número.',
    'present'              => 'O campo :attribute deve estar presente.',
    'regex'                => 'O formato do campo :attribute é inválido.',
    'required'             => 'O campo :attribute é obrigatório.',
    'required_if'          => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless'      => 'O campo :attribute é obrigatório a menos que :other esteja em :values.',
    'required_with'        => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all'    => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_without'     => 'O campo :attribute é obrigatprio quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos valores :values estiverem presente.',
    'same'                 => 'O campo :attribute e :other devem ser iguais.',
    'size'                 => [
        'numeric' => 'O campo :attribute deve ter :size.',
        'file'    => 'O campo :attribute deve ter :size kb.',
        'string'  => 'O campo :attribute deve ter :size caracteres.',
        'array'   => 'O campo :attribute deve conter :size itens.',
    ],
    'string'               => 'O campo :attribute deve ser um texto.',
    'timezone'             => 'O campo :attribute deve ser uma timezone válida.',
    'unique'               => 'Valor já escolhido.',
    'uploaded'             => 'O campo :attribute falhou em realizar o upload.',
    'url'                  => 'O formato do campo :attribute é inválido.',

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
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
