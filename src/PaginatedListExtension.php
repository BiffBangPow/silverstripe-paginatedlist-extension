<?php

namespace BiffBangPow\Extension;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;

class PaginatedListExtension extends Extension
{

    /**
     * @return string
     */
    public function getResultsString()
    {
        $pageEnd = $this->owner->getPageStart() + $this->owner->getPageLength();
        if ($pageEnd > $this->owner->getTotalItems()) {
            $pageEnd = $this->owner->getTotalItems();
        }
        return sprintf(
            '%s-%s of %s results',
            $this->owner->getPageStart() + 1,
            $pageEnd,
            $this->owner->getTotalItems()
        );
    }

    /**
     * @param $itemNumber
     * @return bool|DataObject
     */
    public function getItem($itemNumber)
    {
        if ($itemNumber > $this->owner->getPageLength()) {
            return false;
        }

        $itemNumber += $this->owner->getPageStart();

        /** @var DataList $list */
        $list = $this->owner->list;

        if ($list->offsetExists($itemNumber)) {
            return $list->offsetGet($itemNumber);
        } else {
            return false;
        }
    }
}