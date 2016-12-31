Objective:
At the end of this course, you will be able to  
  - Import content from MySQL/CSV dump to content types, taxonomies in Drupal.



Exercise:
1. Create a movie content type with fields ­ Title (text), Plot(Formatted Text), Actors (Node Reference), Genre(Term Reference).

2. Actors and Genres are simple content type and vocab respectively with no additional fields.

3. Import the CSV dumps from here ( https://drive.google.com/folderview?id=0BzCHjdGh1ZXAdGVudW9ybnBwREU&usp=sharing ) to populate the movie nodes in Drupal using Migrate API.



Steps to perform migrations:
1. Create "Actors" content type (machine name: "actors") containing default title field and no additional fields.

2. Create "Genres" vocabulary (machine name: "genres") containing default title field and no additional fields.

3. Create "Actors" content type (machine name: "actors") containing default title field and no additional fields.

4. Enable "Migrate" module (comes with drupal core) and our custom module "card4_migration".

5. Download and enable "Migration Plus" ( https://www.drupal.org/project/migrate_plus ), "Migrate tools" ( https://www.drupal.org/project/migrate_tools ), and "Migrate source csv" ( https://www.drupal.org/project/migrate_source_csv ) modules.

6. Make sure you're using the latest version of Drush.

7. Update the downloaded csv file path in following migration files:
  a. card4_migration.migration.genres.yml ("card4_migration->config->install->card4_migration.migration.genres.yml")
  b. card4_migration.migration.actors.yml ("card4_migration->config->install->card4_migration.migration.actors.yml")
  c. card4_migration.migration.movies.yml ("card4_migration->config->install->card4_migration.migration.movies.yml")

8. Navigate to "Administration->Configuration->Development->Synchronize" (/admin/config/development/configuration/single/import), select "Migration" under Configuration type and perform the following steps:
  a. Copy the content from migration file of "Genre" present in "card4_migration" module ("card4_migration->config->install->card4_migration.migration.genres.yml") in "Paste your configuration here" field.
  b. Navigate to 'terminal' and execute this command: "drush migrate-import genres".
  (should get message like this: "Processed 5 items (5 created, 0 updated, 0 failed, 0 ignored) - done with 'genres'")

9. Navigate to "Administration->Configuration->Development->Synchronize" (/admin/config/development/configuration/single/import), select "Migration" under Configuration type and perform the following steps:
  a. Copy the content from migration file of "Genre" present in "card4_migration" module ("card4_migration->config->install->card4_migration.migration.actors.yml") in "Paste your configuration here" field.
  b. Navigate to 'terminal' and execute this command: "drush migrate-import actors".
  (should get message like this: "Processed 14 items (14 created, 0 updated, 0 failed, 0 ignored) - done with 'actors'")

10. Navigate to "Administration->Configuration->Development->Synchronize" (/admin/config/development/configuration/single/import), select "Migration" under Configuration type and perform the following steps:
  a. Copy the content from migration file of "Genre" present in "card4_migration" module ("card4_migration->config->install->card4_migration.migration.movies.yml") in "Paste your configuration here" field.
  b. Navigate to 'terminal' and execute this command: "drush migrate-import movies".
  (should get message like this: "Processed 5 items (5 created, 0 updated, 0 failed, 0 ignored) - done with 'movies'")

11. Migration completed, check the migrated content here: "/admin/content" (content of both, "Movie" content type and "Actors" content type).


Reference:
https://www.d8cards.com
https://github.com/mikeshiyan/d8cards.com-example-implementation/tree/modules/04_migration_101
https://www.drupal.org/node/2574707