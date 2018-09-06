<?php

class XmlUtils
{
    const XML_ATTRIBUTE_BOOLEAN_TRUE_VALUE = 'true';

    /**
     * @param DOMElement|null $element
     * @param string $attributeName
     * @return bool|null
     */
    public static function getElementBooleanAttribute(DOMElement $element = null, $attributeName)
    {
        if (!$element || !$element->hasAttribute($attributeName))
        {
            return null;
        }
        return $element->getAttribute($attributeName) == self::XML_ATTRIBUTE_BOOLEAN_TRUE_VALUE;
    }
}