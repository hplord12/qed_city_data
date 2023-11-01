# qed_city_data
Custom module for migrate city data from mongodb to drupal 8 database

1. Access Code Git URL = https://github.com/hplord12/qed_city_data

2. MongoDB setup 
       1. MongoDB (3.2.22)
       2. mongodb extension (1.5.5)
       3. Mongo PHP Library(1.1)
       4. mongodb contributed module(8.x-2.0 )

3. Migration setup
     1. Core module Migrate
     2. Contributed module Migration Plus and Migration Tools
     3. Custom module  city_data

4. Custom module city_data functionality points
     1. Field mapping form = I have used bootstrap class to build form proper way . I have used bootstrap theme as parent theme.
         1. Created custom form for mapping.

     2. Migration from mongodb to drupal 
         1. Created custom services who gone call mongodb connection call and fetch city json results.
         2. Custom controller who is actual responsible to pass source data to migration. Calling custom services in this controller to fetch data.

     3. Created custom content type with custom fields.
         1. Content type name = City Data
             machine name = city_data.

         2. Fields
              City Id = field_city_id (integer)
            City Name = field_city_name
            City Latitude = field_city_latitude
              City Pop = field_city_pop  (integer)
            City State = field_city_state
            New City Name = field_new_city_name


     4. Imported all data in City Data nodes

      5. configuration name is = city_data (use drush migrate-import city_data) to import data.
