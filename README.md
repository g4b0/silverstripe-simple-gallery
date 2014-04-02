# Widgets Pages Extension

A simple photogallery management module.

## Introduction

With this module you will be able to extend each DataObjects, including Pages, in order associate to it a photogallery. If a Page needs more
than a single photogallery, than it's possible to create a Gallery Dataobject, extend it with SimpleGallery, than assign it in a has_many relationship
to the page. See example below.

## Requirements

 * SilverStripe 3.1

### Installation

Install the module through [composer](http://getcomposer.org):

	composer zirak/simple-gallery

Extend the desired DataObject through the following yaml:

	:::yml
	Page:
	  extensions:
	    - SimpleGallery

