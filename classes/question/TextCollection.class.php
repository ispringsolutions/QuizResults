<?php

class TextCollection
{
    /**
     * @var array of string
     */
    private $items;

    public function TextCollection()
    {
        $this->clear();
    }

    /**
     * Add new item to collection
     * @param $item - String
     * @return item index
     */
    public function addItem($item)
    {
        $this->items[] = trim($item);
        return count($this->items) - 1;
    }

    public function getItem($index)
    {
        return $this->items[$index];
    }

    public function getItemsCount()
    {
        return count($this->items);
    }

    public function toArray()
    {
        return $this->items;
    }

    public function initFromXmlNode(DomElement $node, $itemTagName)
    {
        $this->clear();

        $itemsNodes = $node->getElementsByTagName($itemTagName);
        foreach ($itemsNodes as $itemNode)
        {
            $this->addItem(XmlUtils::getElementText($itemNode));
        }
    }

    /**
     * Create new TextCollection object, and init it from xml node
     *
     * @param DomElement $node
     * @param            $itemTagName
     *
     * @return TextCollection
     */
    public static function fromXmlNode(DomElement $node, $itemTagName)
    {
        $collection = new TextCollection();
        $collection->initFromXmlNode($node, $itemTagName);
        return $collection;
    }

    public function clear()
    {
        $this->items = array();
    }
}

?>