.. _db:

Resetting the Database
======================

There will be occasional circumstances in which (some of the tables in) the
database will need to be cleared. To do so, you'll need to access the database
with ``mysql -u pac12 -p pac12`` and run the following MySQL statements in
order:
  
  * Delete all times::
    TRUNCATE TABLE times;

  * Zero school totals (minutes and students)::
    UPDATE totals SET minutes = 0, students = 0;

  * Profiles do not cascade delete, so to delete user profiles::
    DELETE profiles FROM profiles LEFT JOIN users ON profiles.user_id=users.id WHERE users.type <> 'admin' AND users.type <> 'superadmin';

  * Delete all users that are neither admin nor superadmin::
    DELETE FROM users WHERE type <> 'amdin' AND type <> 'superadmin';
