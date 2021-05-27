Bitoneer PHP Framework
===================

This project contains all files for Bitoneer. Bitoneer is a self-written php framework developed by acreation - Sascha Nos.


generate documentation
-------------

To generate the PHP documentation files, run the following command on your console:
`apigen generate -s library/ -d documentation/`


changelog
-------------

[...]

## 6.0 ##
* implement correct camelcase style of several methods
* add first version of documentation (not final)
* add readme file

## 7.0 ##
* delete navigation methods for Pages
* remove attribute Name from Pages
* add attribute viewClass to Pages (to have multiple ViewServices)

### 7.1.0 ##
* add input stream var helpers (now possible to get params via put or delete)

## 8.0 ##
* remove minifyScript method in ApiHelper
* new method names in ViewService (error404Action, error500Action)
* new method names in ApiService (templateAction, minifyScriptsAction)
* change return values of ApiService (now error 400 used instead of param "success")

#### 8.0.1 ####
* add missing key for templateAction (returned wrong json)

### 8.1.0 ###
* enable group by in sql statement by setting param


todos
-------------

* add full changelog
* add documentation to all methods
* add haml (with twig): http://mthaml.readthedocs.org/en/latest/twig-syntax.html
* fix array key sort; umlauts are at end of list (maybe just another sorting type needed?)
* fix array key dort; default should be ASC sorting
* add README file for bitoneer_js