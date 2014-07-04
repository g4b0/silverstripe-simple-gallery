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

```YAML
Page:
  extensions:
    - SimpleGalleryExtension
```

## Template

A really basic template is given, to use it just put this code into your Page template:

```HTML
<% include simplegallery %>
```

For a nice visualization into the default SS template add this CSS code:

```CSS
.simplegallery img {width: 30%; float: left; margin: 10px;}
```

You have to write your own .ss files for more advanced features. Just overwrite template/simplegallery.ss into your theme and loop over 
$SortedImages writing your HTML code:

```HTML
<div class="simplegallery">
<% loop SortedImages %>
	<% if $CustomLink %>
	 <a href="$CustomLink">$Image</a>
	<% else %>
	 $Image
	<% end_if %>
<% end_loop %>
</div>
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

Just like simplegallery, a very basic template is given, to use it just put this code into your Page template:

```HTML
<% include simplegalleries %>
```

For a nice visualization into the default SS template add this CSS code:

```CSS
.simplegallery {clear: both;}
.simplegallery img {width: 30%; float: left; margin: 10px;}
```

You have to write your own .ss files for more advanced features. Just overwrite template/simplegalleries.ss into your theme and loop 
over $SortedGalleries, and then over $SortedImages

```HTML
<% loop $SortedGalleries %>
	<div class="simplegallery">
		<article>
			<h3>$Name</h3>
			$Description
			<div>
			<% loop SortedImages %>
				<% if $CustomLink %>
				 <a href="$CustomLink">$Image</a>
				<% else %>
				 $Image
				<% end_if %>
			<% end_loop %>
			</div>
		</article>
	</div>
<% end_loop %>

```