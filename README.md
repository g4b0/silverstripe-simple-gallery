# Simple Gallery

A simple photogallery management module.

## Introduction

With this module you will be able to extend each DataObjects, including Pages, in order associate to it a photogallery. If a Page needs more
than a single photogallery, than it's possible to create a Gallery Dataobject, extend it with SimpleGallery, than assign it in a has_many relationship
to the page. See example below.

## Requirements

 * SilverStripe 3.1
 * colymba/gridfield-bulk-editing-tools
 * undefinedoffset/sortablegridfield

## Installation

Install the module through [composer](http://getcomposer.org):

	composer require zirak/simple-gallery
  composer update

### Single gallery

To have a single gallery per page extend the desired page type through the following yaml:

	:::yml
	Page:
	  extensions:
	    - SimpleGalleryExtension

## Template

No default template is given, you have to write your own .ss files. Just loop over Images:

```HTML
<% loop Images %>
	<% if $CustomLink %>
	 <a href="$CustomLink">$Image</a>
	<% else %>
	 $Image
	<% end_if %>
<% end_loop %>
```

### Multiple gallery

If you prefer to have multiple sortable gallery in a specific page type simply add an has_many relationship
like the following example:

```php
class Portfolio extends Page {

	private static $has_many = array(
			'Galleries' => 'SimpleGallery'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$gridFieldConfig = GridFieldConfig_RelationEditor::create();
		$gridFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));
		$field = new GridField(
						'Galleries', 'Galleries', $this->SortedGalleries(), $gridFieldConfig
		);
		$fields->addFieldToTab('Root.Galleries', $field);

		return $fields;
	}

	public function SortedGalleries() {
		return $this->Galleries()->sort('SortOrder');
	}

}
```

## Template

No default template is given, you have to write your own .ss files. Simply loop over $SortedGalleries, and then over $SortedImages

```HTML
<% loop $SortedGalleries %>
	<div>
		<article>
			<h3>$Name</h3>
			$Description
			<% loop $SortedImages %>
				$Image
			<% end_loop %>
		</article>
	</div>
<% end_loop %>
```