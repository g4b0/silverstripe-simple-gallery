<?php

/**
 * Description of SimpleGallery
 *
 * @author Gabriele Brosulo <gabriele.brosulo@zirak.it>
 * @creation-date 02-Apr-2014
 */
class SimpleGallery extends DataObject {

	private static $db = array(
			'Name' => 'Varchar(255)',
			'Description' => 'HTMLText',
			'SortOrder' => 'Int'
	);
	private static $has_one = array(
			'Page' => 'Page'
	);
	private static $summary_fields = array(
			'Name',
			'Description.Summary'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeByName('SortOrder');
		$fields->removeByName('PageID');

		return $fields;
	}

}
