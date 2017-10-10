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

    'accepted'             => 'O campo :Attribute deve ser aceito.',
    'active_url'           => 'O campo :Attribute não é um URL válido.',
    'after'                => 'O campo :Attribute deve ser uma data depois :date.',
    'after_or_equal'       => 'O campo :Attribute deve ser uma data posterior ou igual a :date.',
    'alpha'                => 'O campo :Attribute só pode conter letras.',
    'alpha_dash'           => 'O campo :Attribute só pode conter letras, números e traços.',
    'alpha_num'            => 'O campo :Attribute só pode conter letras e números.',
    'array'                => 'O campo :Attribute deve ser uma matriz.',
    'before'               => 'O campo :Attribute deve ser uma data anterior :date.',
    'before_or_equal'      => 'O campo :Attribute deve ser uma data anterior ou igual a :date.',
    'between'              => [
        'numeric' => 'O campo :Attribute deve ser entre :min e :max.',
        'file'    => 'O campo :Attribute deve ser entre :min e :max kilobytes.',
        'string'  => 'O campo :Attribute deve ser entre :min e :max caracteres.',
        'array'   => 'O campo :Attribute deve ter entre :min e :max itens.',
    ],
    'boolean'              => 'O campo :Attribute deve ser verdadeiro ou falso.',
    'confirmed'            => 'O campo :Attribute de confirmação não confere.',
    'date'                 => 'O campo :Attribute não é uma data válida.',
    'date_format'          => 'O campo :Attribute não corresponde ao formato :format.',
    'different'            => 'Os campos :Attribute e :other devem ser diferentes.',
    'digits'               => 'O campo :Attribute deve ter :digits dígitos.',
    'digits_between'       => 'O campo :Attribute deve ter entre :min e :max dígitos.',
    'dimensions'           => 'O campo :Attribute tem dimensões de imagem inválidas.',
    'distinct'             => 'O campo :Attribute campo tem um valor duplicado.',
    'email'                => 'O campo :Attribute deve ser um endereço de e-mail válido.',
    'exists'               => 'O campo :Attribute selecionado é inválido.',
    'file'                 => 'O campo :Attribute deve ser um arquivo.',
    'filled'               => 'O campo :Attribute o campo deve ter um valor.',
    'image'                => 'O campo :Attribute deve ser uma imagem.',
    'in'                   => 'O campo :Attribute selecionado é inválido.',
    'in_array'             => 'O campo :Attribute não existe em :other.',
    'integer'              => 'O campo :Attribute deve ser um número inteiro.',
    'ip'                   => 'O campo :Attribute deve ser um endereço de IP válido.',
    'ipv4'                 => 'O campo :Attribute deve ser um endereço IPv4 válido.',
    'ipv6'                 => 'O campo :Attribute deve ser um endereço IPv6 válido.',
    'json'                 => 'O campo :Attribute deve ser uma string JSON válida.',
    'max'                  => [
        'numeric' => 'O campo :Attribute não pode ser superior a :max.',
        'file'    => 'O campo :Attribute não pode ser superior a :max kilobytes.',
        'string'  => 'O campo :Attribute não pode ser superior a :max caracteres.',
        'array'   => 'O campo :Attribute não pode ter mais do que :max itens.',
    ],
    'mimes'                => 'O campo :Attribute deve ser um arquivo de tipo: :values.',
    'mimetypes'            => 'O campo :Attribute deve ser um arquivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'O campo :Attribute deve ser inferior a :min.',
        'file'    => 'O campo :Attribute deve ser inferior a :min kilobytes.',
        'string'  => 'O campo :Attribute deve ser inferior a :min caracteres.',
        'array'   => 'O campo :Attribute deve ter menos do que :min itens.',
    ],
    'not_in'               => 'O campo :Attribute selecionado é inválido.',
    'numeric'              => 'O campo :Attribute deve ser um número.',
    'present'              => 'O campo :Attribute deve estar presente.',
    'regex'                => 'O campo :Attribute tem um formato inválido.',
    'required'             => 'O campo :Attribute é obrigatório.',
    'required_if'          => 'O campo :Attribute é obrigatório quando :other é :value.',
    'required_unless'      => 'O campo :Attribute é obrigatório exceto quando :other seja :values.',
    'required_with'        => 'O campo :Attribute é obrigatório quando :values está presente.',
    'required_with_all'    => 'O campo :Attribute é obrigatório quando :values está presente.',
    'required_without'     => 'O campo :Attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :Attribute é obrigatório quando nenhum dos :values estão presentes.',
    'same'                 => 'Os campos :Attribute e :other devem corresponder.',
    'size'                 => [
        'numeric' => 'O campo :Attribute deve ser :size.',
        'file'    => 'O campo :Attribute deve ser :size kilobytes.',
        'string'  => 'O campo :Attribute deve ser :size caracteres.',
        'array'   => 'O campo :Attribute deve conter :size itens.',
    ],
    'string'               => 'O campo :Attribute deve ser uma string.',
    'timezone'             => 'O campo :Attribute deve ser uma zona válida.',
    'unique'               => 'O campo :Attribute já está sendo utilizado.',
    'uploaded'             => 'O campo :Attribute falha no upload.',
    'url'                  => 'O campo :Attribute tem um formato inválido.',

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
        'livros' => [
            'required' => 'Selecione pelo menos um Livro',
            'exists' => 'Livro não encontrado',
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

    'attributes' => [
        'estudante_id'=>'Estudante',
        'editora_id'=>'Editora',
        'secao_id'=>'Seção',
        'titulo'=>'Título',
        'descricao'=>'Descrição',
        'edicao'=>'Edição',
        'isbn'=>'ISBN',
    ],

];
