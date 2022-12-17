<?php

namespace Framework\Validator;

class ValidationError
{

    private $key;
    private $rule;
    private $attributes;
    private $message = [
        'required' => 'Le champ %s est requis',
        'empty' => 'Le champ %s ne peut être vide',
        'slug' => 'Le champ %s n\'est pas un slug valide',
        'minLength' => 'Le champ %s doit contenir plus de %d caracteres',
        'maxLength' => 'Le champ %s doit contenir moins de %d caracteres',
        'betweenLength' => 'Le champ %s doit contenir entre %d et %d caracteres',
        'dateTime' => 'Le champ %s doit être une date valide (%s)'
    ];

    public function __construct(string $key, string $rule, array $attributes = [])
    {
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }

    public function __toString()
    {
        $params = array_merge([$this->message[$this->rule], $this->key], $this->attributes);
        return (string)call_user_func_array('sprintf', $params);
    }
}
