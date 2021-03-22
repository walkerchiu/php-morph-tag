<?php

namespace WalkerChiu\MorphTag\Models\Entities;

use WalkerChiu\Core\Models\Entities\Lang;

class TagLang extends Lang
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        $this->table = config('wk-core.table.morph-tag.tags_lang');

        parent::__construct($attributes);
    }
}
