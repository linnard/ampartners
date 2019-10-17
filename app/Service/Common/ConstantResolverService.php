<?php

namespace App\Service\Common;

class ConstantResolverService
{
    /**
     * @var array
     */
    private $_constants = [];

    /**
     * @param string $className
     * @return $this
     */
    public function resolve(string $className)
    {
        $obj = new \ReflectionClass($className);

        $this->_constants = $obj->getConstants();

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collect()
    {
        return collect($this->_constants);
    }
}
