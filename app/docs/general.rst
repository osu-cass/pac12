.. _notes:

Notes
=====

The following are general notes about how the PAC 12 site works.


Controllers
-----------
The ``controllers`` directory contains most of the code that determines how
everything works. Want to change how the user can interact with the site? Check
out UserController.php. What about the admin panel? All admin control files are
located in ``controllers\admin``. 


Time Entries
------------

In order to log a workout, users will need to select an activity (type), input
a time, and enter a date.

* Users are allowed to log a maximum of 120 minutes per day. Attempts to add
  more once they have reached this cap will be rejected and are not included in
  their school's totals.

* Dates can either be selected from the provided dropdown calendar or inputted
  manually. Users are allowed to log times for previous and future days if they
  wish, but again, are limited by the 120 minute cap. Submitted dates that are
  outside of the challenge range are rejected. Note that while users are
  allowed to log workouts when the challenge has officially ended (provided 
  that the dates are within the challenge range), these times are not added to
  the school's totals. However, they still show in the user's personal stats.


Miscellaneous
-------------

While most of the main page can be manipulated and changed from the admin
panel, the title is located in ``views/pages/welcome.blade.php``. Modify line
146 to change "PAC-12 RECREATION CHALLENGE" to the desired text.

If the mobile site is active, match any changes made to the title in
``views/pages/welcome-blade.php``.


Quirks/Apparent Inconsistencies
-------------------------------

In UserController.php, on line 520, a check is being done to validate login via
username. Currently, users can only use their email to login, so this check is
unnecessary.

.. note::
    If any other inconsistencies are found, please note them in this section.
