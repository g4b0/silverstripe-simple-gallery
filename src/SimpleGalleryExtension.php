<?php

namespace g4b0\SimpleGallery;

use SilverStripe\ORM\DataObject;

/**
 * SimpleGalleryExtension
 *
 * @author Gabriele Brosulo <gabriele.brosulo@zirak.it>
 * @creation-date 02-Apr-2014
 */
class SimpleGalleryExtension extends DataExtension {

    public static $has_many = array('Images' => 'SimpleGalleryImage');

    public function updateCMSFields(FieldList $fields) {
        parent::updateCMSFields($fields);

        $fields->removeByName('Images');

        $name = Config::inst()->get('SimpleGalleryExtension', 'gallery_name');

        if ($this->owner->ID > 0) {

            $folder = Config::inst()->get('SimpleGalleryExtension', 'folder_path');
            if (strlen($folder) == 0) {
                $folder = 'simplegallery';
            }

            $gridFieldConfig = GridFieldConfig_RecordEditor::create();
            ;
            $bu = new GridFieldBulkImageUpload('Image', array('Title'));
            $bu->setConfig('folderName', $folder);
            $gridFieldConfig->addComponent($bu);
            $gridFieldSortableRows = new GridFieldSortableRows('SortOrder');
            $gridFieldConfig->addComponent($gridFieldSortableRows->setAppendToTop(true));

            $gridfield = new GridField("Gallery", $name, $this->SortedImages(true), $gridFieldConfig);

            $fields->addFieldToTab('Root.' . $name, $gridfield);
        }

        return $fields;
    }

    public function SortedImages($includeDisabled = false) {
        $retVal = $this->owner->Images();

        if (!$includeDisabled) {
            $retVal = $retVal->filter(array('Disabled' => 0));
        }

        $retVal = $retVal->sort("SortOrder");
        return $retVal;
    }

}

?>
