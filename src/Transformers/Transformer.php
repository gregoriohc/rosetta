<?php

namespace Ghc\Rosetta\Transformers;

abstract class Transformer
{
    /**
     * @var array
     */
    protected $relations = [];

    /**
     * @param array $data
     * @return array
     */
    abstract public function transform($data);

    public function processRelations($data)
    {
        $relationsData = [];

        foreach ($this->relations as $relation) {
            $relationMethod = 'relation' . ucfirst($relation);
            $relationsData[$relation] = call_user_func_array([$this, $relationMethod], [$data]);
        }

        return $relationsData;
    }
}