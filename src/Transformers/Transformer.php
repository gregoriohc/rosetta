<?php

namespace Ghc\Rosetta\Transformers;

abstract class Transformer
{
    /**
     * Configuration options
     *
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $relations = [];

    /**
     * Connector constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        $this->addDefaultConfig([
            'properties' => [],
        ]);

        $this->boot();
    }

    /**
     * Boot Transformer
     */
    protected function boot()
    {
    }

    /**
     * @param array $data
     * @return array
     */
    public function processRelations($data)
    {
        $relationsData = [];

        foreach ($this->relations as $relation) {
            $relationMethod = 'relation' . ucfirst($relation);
            $relationsData[$relation] = call_user_func_array([$this, $relationMethod], [$data]);
        }

        return $relationsData;
    }

    /**
     * @param array $config
     */
    protected function addDefaultConfig($config)
    {
        $this->config = array_merge($config, $this->config);
    }

    /**
     * @param array $data
     * @return array
     */
    abstract public function transform($data);
}