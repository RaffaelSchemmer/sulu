<?php
/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Component\Content\Block;

use Sulu\Component\Content\Property;
use Sulu\Component\Content\PropertyInterface;

class BlockProperty extends Property implements BlockPropertyInterface
{
    /**
     * properties managed by this block
     * @var PropertyInterface
     */
    private $childProperties = array();

    function __construct(
        $name,
        $mandatory = false,
        $multilingual = false,
        $maxOccurs = 1,
        $minOccurs = 1,
        $params = array()
    )
    {
        parent::__construct($name, 'block', $mandatory, $multilingual, $maxOccurs, $minOccurs, $params);
    }

    /**
     * returns a list of properties managed by this block
     * @return PropertyInterface
     */
    public function getChildProperties()
    {
        return $this->childProperties;
    }

    /**
     * @param PropertyInterface $property
     */
    public function addChild(PropertyInterface $property)
    {
        $this->childProperties[] = $property;
    }

    public function setValue($value)
    {
        /** @var PropertyInterface $subProperty */
        foreach ($this->childProperties as $subProperty) {
            if (isset($value[$subProperty->getName()])) {
                $subProperty->setValue($value[$subProperty->getName()]);
            }
        }
    }

    public function getValue()
    {
        $data = array();
        /** @var PropertyInterface $subProperty */
        foreach ($this->childProperties as $subProperty) {
            $data[$subProperty->getName()] = $subProperty->getValue();
        }
        return $data;
    }

    public function getIsBlock()
    {
        return true;
    }


}
