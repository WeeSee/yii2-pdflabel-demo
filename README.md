Yii2-Pdflabel Demo
==================

This demo shows some examples of how the Yii2 extension
[yii2-pdflabel](https://github.com/WeeSee/yii2-pdflabel) can be used.

To see this extension working, have a look at:

* [SiteContoller: actionPdfLabelDownload](/controllers/SiteController.php#L132)
* [views/site/about.php](/views/site/about.php)

Installation
------------

This is a full Yii2 application (basic template).

The preferred way to install (with local composer installation) is 

    $ cd /var/www/html
    $ git clone https://github.com/weesee/yii2-pdflabel-demo
    $ php composer.phar install

Usage
-----

Then start your web browser with ```http://localhost/web/index.php```, goto ```About```
and try the labels listes.

You should see this About-Screen:

![About-Screen](/images/yii2-pdflabel-1.png)

and label prints like this (in PDF, in A4 format):

![Label page](/images/yii2-pdflabel-2.png)



