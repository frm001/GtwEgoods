# Egoods Plugin for CakePHP

## Requirements

CakePHP 2.4.0+  
[GtwUi](https://github.com/Phillaf/GtwUsers)

## Installation
Copy this plugin in a folder named `app/Plugin/GtwUsers` or add these lines to your `composer.json` file :

        "require": {
            "phillaf/gtw_egoods": "*@dev"
        }
Load the plugin adding these lines to `app/Config/bootstrap.php` : 

    CakePlugin::load('GtwEGoods');

Import this plugins style into your project by adding this to your less file.
	@import "../GtwEgoods/less/egoods.less";

### How to access
	/gtw_egoods/egoods
	/gtw_egoods/egoods/listing
	/gtw_egoods/egoods/add

## Copyright and license   
Author: Philippe Lafrance   
Copyright 2013 [Gintonic Web](http://gintonicweb.com)  
Licensed under the [Apache 2.0 license](http://www.apache.org/licenses/LICENSE-2.0.html)
