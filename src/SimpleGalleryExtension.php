<?php

namespace g4b0\SimpleGallery;

use Colymba\BulkUpload\BulkUploader;
use Colymba\BulkUpload\BulkUploadField;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

/**
 * SimpleGalleryExtension
 *
 * @author        Gabriele Brosulo <gabriele.brosulo@zirak.it>
 * @creation-date 02-Apr-2014
 */
class SimpleGalleryExtension extends DataExtension
{

    private static $has_many = [
        'Images' => SimpleGalleryImage::class,
    ];

    public function updateCMSFields(FieldList $fields)
    {
        parent::updateCMSFields($fields);

        $fields->removeByName('Images');

        $name = Config::inst()->get(SimpleGalleryExtension::class, 'gallery_name');

        if ($this->owner->ID > 0) {

            $folder = Config::inst()->get(SimpleGalleryExtension::class, 'folder_path');
            if (strlen($folder) == 0) {
                $folder = 'simplegallery';
            }

            $gridFieldConfig = GridFieldConfig_RecordEditor::create();;
//            $bu = new BulkUploadField('Image', ['Title']);
            $bu = new BulkUploader();
            $bu->setUfSetup('setFolderName', $folder);
            $gridFieldConfig->addComponent($bu);
            $gridFieldSortableRows = new GridFieldSortableRows('SortOrder');
            $gridFieldConfig->addComponent($gridFieldSortableRows->setAppendToTop(true));

            $gridfield = new GridField("Gallery", $name, $this->SortedImages(true), $gridFieldConfig);

            $fields->addFieldToTab('Root.'.$name, $gridfield);
        }

        return $fields;
    }

    public function SortedImages($includeDisabled = false)
    {
        $retVal = $this->owner->Images();

        if (!$includeDisabled) {
            $retVal = $retVal->filter(array('Disabled' => 0));
        }

        $retVal = $retVal->sort("SortOrder");

        return $retVal;
    }
}
