Readme
------
This module lets you restrict new user registrations to people over a configurable age. At the moment, it doesn't track attempts, so an underage user could just try again and change the birthyear to sign up. Since there are lots of ways around this (e.g. switch browsers, switch computers), it's a low priorty feature.

Send comments to Gwen Park at: http://drupal.org/user/99925.

Requirements
------------
This module requires Drupal 6.x.

Installation
------------
1. Copy the validateage directory and its contents to the Drupal modules directory, probably /sites/all/modules/.

2. Enable the Validate Age module in the modules admin page /admin/build/modules.

3. Set the minimum age and date of birth field in the settings page /admin/user/validateage.

Upgrading from 5.x to 6.x
-------------------------
I removed the dependency on the profile module in the 6.x version so please note the following issues:
1. There is currently no script to copy old profile birthday data into the new validateage table. If you use birthday info, you will have to deal with data conversion manually.
2. I have no plans to write code to keep profile birthday data synced with validateage data. If you're using profile module for birthdays, you'll have users' birthdays stored in 2 different places.

Credits
-------
Written by Gwen Park.

TODO
----
1. Write script to convert old profile birthday info to new table.
2. Write code to prevent rejected users from re-signing up.

Page verification Option
-----------------------------------
This provides validation to access any page on the site and makes both page and validation validation processes optional.
Page validation requires cookies to work.

Installation
------------

Add a phptemplate_preprocess_page($vars) function to template.php as follows:

  function phptemplate_preprocess_page(&$vars) {
    if (arg(0)=="validateage") $vars['template_file'] = 'validateage';
  }

Create a copy of your theme's page.tpl.php template called validateage.tpl.php and remove items you don't want underage users to see, such as sidebars, menus and banners

Go to admin/user/validateage and turn on page and/or registration validation depending on your needs. You can also select for search engines to bypass validation.
