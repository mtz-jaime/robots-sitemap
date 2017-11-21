<?php

Route::get('robots.txt', 'mtzjaime\robotssitemap\PackageController@robots');
Route::get('sitemap.xml', 'mtzjaime\robotssitemap\PackageController@sitemap');
