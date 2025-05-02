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

    'accepted' => '：attributeを受け入れる必要です。',
    'active_url' => '：attributeは有効なURLではありません。',
    'after' => 'attributeは：dateの後の日付である必要です。',
    'after_or_equal' => ':attributeは:date以降の日付である必要です。',
    'alpha' => ':attributeは文字のみです。',
    'alpha_dash' => ':attribute は文字、数字、ダッシュ及びアンダースコアのみです。',
    'alpha_num' => ' :attribute は 文字と数字のみです。',
    'array' => ':attributeは配列である必要です。',
    'before' => ':attributeは：dateの前の日付である必要です。',
    'before_or_equal' => ':attributeは:dateの前または等しいの日付である必要です。',
    'between' => [
        'numeric' => ':attributeは：minと：maxの間が必要です。',
        'file' => ':attributeは：minと：max kilobytes の間が必要です。 ',
        'string' => ':attributeは：minと：max characters の間が必要です。',
        'array' => ':attributeは：minと：max items の間が必要です。',
    ],
    'boolean' => ':attributeはtrueまたはfalseが必要です。',
    'confirmed' => ':attributeの確認が一致しませんです。',
    'date' => ':attributeは有効な日付ではありません。',
    'date_equals' => ':attributeは：dateの等しいの日付である必要です。',
    'date_format' => ':attributeは:formatと一致しではありません。',
    'different' => ':attributeと:otherが異なってある必要です。',
    'digits' => ':attributeは:digits数字のみある必要です。',
    'digits_between' => ':attributeは：minと：max digitsの間が必要です。',
    'dimensions' => ':attributeの画像のサイズが無効です。',
    'distinct' => ':attributeは複製があります。',
    'email' => ':attributeは有効なメールアドレスであるが必要です。',
    'ends_with' => ':attributeは:valuesの終了する必要があります。',
    'exists' => '選択された:attributeが無効です。',
    'file' => ':attributeはファイルである必要があります。',
    'filled' => ':attribute値が必要です。',
    'gt' => [
        'numeric' => ':attributeは：valueより大きくする必要があります。',
        'file' => ':attribute は：value kilobytesより大きくする必要があります。 ',
        'string' => 'attribute は：value charactersより大きくする必要があります。',
        'array' => ':attributeは:value itemsのより多いである必要があります。',
    ],
    'gte' => [
        'numeric' => ':attributeは：valueより大きくまたは等しいである必要があります。',
        'file' => ':attributeは：value kilobytes より大きくまたは等しいである必要があります。',
        'string' => ':attributeは：value characters より大きくまたは等しいである必要があります。',
        'array' => ':attributeは:value itemsのより多いである必要があります。',
    ],
    'image' => ':attributeは画像である必要です。',
    'in' => '選択された:attributeが無効です。',
    'in_array' => ':attributeは:otherにではありません。',
    'integer' => ':attributeは整数である必要です。',
    'ip' => ':attributeは有効なIPアドレスである必要です。',
    'ipv4' => ':attributeは有効なIPv4アドレスである必要です。',
    'ipv6' => ':attributeは有効なIPv6アドレスである必要です。',
    'json' => ':attributeは有効なJSON Stringである必要です。',
    'lt' => [
        'numeric' => ':attributeは:valueより少なくする必要があります。',
        'file' => ':attributeは:value kilobytesより少なくする必要があります。',
        'string' => ':attributeは:value charactersより少なくする必要があります。',
        'array' => ':attributeは:value itemsより少なくする必要があります。',
    ],
    'lte' => [
        'numeric' => ':attributeは:valueより少なくまたは等しいである必要があります。',
        'file' => ':attributeは:value kilobytes より少なくまたは等しいである必要があります。',
        'string' => ':attributeは:value charactersより少なくまたは等しいである必要があります。',
        'array' => ':attributeは:value itemsより少なくする必要があります。',
    ],
    'max' => [
        'numeric' => ':attributeは:maxより大きくないである必要です。',
        'file' => ':attributeは:max kilobytesより大きくないである必要です。',
        'string' => ':attributeは:max charactersより大きくないである必要です。',
        'array' => ':attributeは:max itemsより大きくないである必要です。',
    ],
    'mimes' => ':attributeは:valuesのファイルタイプである必要です。',
    'mimetypes' => 'attributeは:valuesのファイルタイプである必要です。',
    'min' => [
        'numeric' => ':attributeは:minより少なくともである必要です。',
        'file' => ':attributeは:min kilobytesより少なくともである必要です。',
        'string' => ':attributeは:min charactersより少なくともである必要です。',
        'array' => ':attributeは:min itemsより少なくともである必要です。',
    ],
    'multiple_of' => ':attributeは:valueの倍数である必要です。',
    'not_in' => '選択された:attributeが無効です。',
    'not_regex' => ':attributeのフォーマットが無効です。',
    'numeric' => ':attributeは整数である必要です。',
    'password' => 'パスワードが正しくないです。',
    'present' => ':attributeは存在する必要があります',
    'regex' => ':attributeのフォーマットが無効です。',
    'required' => ':attributeは必要です。',
    'required_if' => ':otherは:valueのとき:attributeが必要です。',
    'required_unless' => '：otherが：valuesにある場合は:attributeが必要です。',
    'required_with' => ':valuesが ある場合は:attributeが必要です。',
    'required_with_all' => ':valuesがある場合は:attributeが必要です。',
    'required_without' => ':valuesがない場合は:attributeが必要です。',
    'required_without_all' => '：valuesが存在しない場合は:attributeが必要です。',
    'prohibited' => ':attributeが禁止です。',
    'prohibited_if' => ':otherは:valueのとき:attributeが禁止です。',
    'prohibited_unless' => '：otherが：valuesにある場合は:attributeが禁止です。',
    'same' => '：attributeと：otherは一致するが必要です。',
    'size' => [
        'numeric' => ':attributeは:sizeである必要です。',
        'file' => ':attributeは:size kilobytesである必要です。',
        'string' => ':attributeは:size charactersである必要です。',
        'array' => '：attributeには：sizeアイテムが含まれているが必要です。',
    ],
    'starts_with' => ' :attributeは:valuesの次のいずれかで開始するが必要です。',
    'string' => ':attributeは文字列である必要です。',
    'timezone' => ':attributeは有効なゾーンである必要です。',
    'unique' => ':attributeはすでに使用されてあります。',
    'uploaded' => ':attributeのアップロードに失敗しました。',
    'url' => ':attributeのフォーマットが無効です。',
    'uuid' => ':attributeは有効なUUIDである必要です。',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],
];
