<?php

namespace g4b0\SimpleGallery;

use SilverStripe\ORM\DataObject;

/**
 * SimpleGallery
 *
 * @author Gabriele Brosulo <gabriele.brosulo@zirak.it>
 * @creation-date 02-Apr-2014
 */
class SimpleGallery extends DataObject {

    private static $db = [
        'Name' => 'Varchar(255)',
        'Description' => 'HTMLText',
        'SortOrder' => 'Int'
    ];
    private static $has_one = [
        'Page' => 'Page'
    ];
    private static $summary_fields = [
        'Name',
        'Description.Summary'
    ];
    private static $table_name = 'SimpleGallery_SimpleGallery';

    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->removeByName('SortOrder');
        $fields->removeByName('PageID');

        return $fields;
    }

}
