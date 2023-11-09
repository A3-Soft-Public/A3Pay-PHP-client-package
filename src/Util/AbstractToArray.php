<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Util;

use ReflectionObject;
use stdClass;

abstract class AbstractToArray
{
    /**
     * @param bool $ignoreNull
     * @param bool $recursive
     * @return array|stdClass
     */
    public function toArray(bool $ignoreNull = false, bool $recursive = false, bool $stdClassIfEmpty = false)
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
                                    $result[$reflectionProperty->getName()][$reflectionPropertyKey] = $reflectionPropertyObject->getMethod('toArray')->invoke($reflectionProperty->getValue($this)[$reflectionPropertyKey], $ignoreNull, $recursive, $stdClassIfEmpty);
                                }
                            }
                        }
                        continue;
                    } elseif (is_object($reflectionProperty->getValue($this))) {
                        $reflectionPropertyObject = new ReflectionObject($reflectionProperty->getValue($this));
                        if($reflectionPropertyObject->hasMethod('toArray') && $reflectionPropertyObject->getMethod('toArray')->isPublic()) {
                            $result[$reflectionProperty->getName()] = $reflectionPropertyObject->getMethod('toArray')->invoke($reflectionProperty->getValue($this), $ignoreNull, $recursive, $stdClassIfEmpty);
                            continue;
                        }
                    }
                }
                $result[$reflectionProperty->getName()] = $reflectionProperty->getValue($this);
            }
        }
        if($stdClassIfEmpty && empty($result)) {
            return new stdClass();
        }

        return  $result;
    }
}
