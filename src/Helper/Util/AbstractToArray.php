<?php
namespace A3Soft\A3PayPhpClient\Helper\Util;

use ReflectionObject;

abstract class AbstractToArray
{
    /**
     * @param bool $ignoreNull
     * @param bool $recursive
     * @return array
     */
    public function toArray(bool $ignoreNull = false, bool $recursive = false): array
    {
        $result = [];
        $reflectionObject = new \ReflectionObject($this);
        foreach ($reflectionObject->getProperties() as $reflectionProperty) {
            $reflectionProperty->setAccessible(true);
            if($reflectionProperty->isInitialized($this)) {
                if($ignoreNull && $reflectionProperty->getValue($this) === null)
                    continue;
                if($recursive) {
                    if(is_array($reflectionProperty->getValue($this))) {
                        foreach($reflectionProperty->getValue($this) as $reflectionPropertyKey => $reflectionPropertyValue) {
                            if(is_object($reflectionPropertyValue)) {
                                $reflectionPropertyObject = new ReflectionObject($reflectionProperty->getValue($this)[$reflectionPropertyKey]);
                                if($reflectionPropertyObject->hasMethod('toArray') && $reflectionPropertyObject->getMethod('toArray')->isPublic()) {
                                    $result[$reflectionProperty->getName()][$reflectionPropertyKey] = $reflectionPropertyObject->getMethod('toArray')->invoke($reflectionProperty->getValue($this)[$reflectionPropertyKey], $ignoreNull, $recursive);
                                }
                            }
                        }
                        continue;
                    } elseif (is_object($reflectionProperty->getValue($this))) {
                        $reflectionPropertyObject = new ReflectionObject($reflectionProperty->getValue($this));
                        if($reflectionPropertyObject->hasMethod('toArray') && $reflectionPropertyObject->getMethod('toArray')->isPublic()) {
                            $result[$reflectionProperty->getName()] = $reflectionPropertyObject->getMethod('toArray')->invoke($reflectionProperty->getValue($this), $ignoreNull, $recursive);
                            continue;
                        }
                    }
                }
                $result[$reflectionProperty->getName()] = $reflectionProperty->getValue($this);
            }
        }
        return $result;
    }
}
