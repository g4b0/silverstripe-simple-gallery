<?php

class SimpleGalleryExtension extends DataExtension {

  public static $has_many = array('Images' => 'SimpleGalleryImage');

  public function updateCMSFields(FieldList $fields) {
    parent::updateCMSFields($fields);
		
		$fields->removeByName('Images');

		$name = Config::inst()->get('SimpleGalleryExtension', 'gallery_name');
		
    if ($this->owner->ID > 0) {
			$gridFieldConfig = GridFieldConfig_RecordEditor::create();;
			$gridFieldConfig->addComponent(new GridFieldBulkImageUpload('Image', array('Title')));
			$gridFieldSortableRows = new GridFieldSortableRows('SortOrder');
			$gridFieldConfig->addComponent($gridFieldSortableRows->setAppendToTop(true));

      $gridfield = new GridField("Gallery", $name, $this->SortedImages(), $gridFieldConfig);

      $fields->addFieldToTab('Root.'.$name, $gridfield);
    }

    return $fields;
  }

  public function SortedImages() {
    return $this->owner->Images()->sort("SortOrder");
  }

}

?>
