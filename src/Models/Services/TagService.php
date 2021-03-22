<?php

namespace WalkerChiu\MorphTag\Models\Services;

use Illuminate\Support\Facades\App;
use WalkerChiu\Core\Models\Services\CheckExistTrait;

class TagService
{
    use CheckExistTrait;

    protected $repository;

    public function __construct()
    {
        $this->repository = App::make(config('wk-core.class.morph-tag.tagRepository'));
    }

    /**
     * @param String $host_type
     * @param Int    $host_id
     * @param String $code
     * @return Array
     */
    public function listOption($host_type, $host_id, String $code)
    {
        return $this->repository->listOption($host_type, $host_id, $code);
    }
}
