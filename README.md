# laravel-forum
Laravel forum with TDD and Vue.js


You should provide your own .env file and run commands

composer install and npm install to install necessary dependency.
 
 And npm run watch to compile.
 
 
 Next because i did TDD you will  need to provide your own test database (my testing_forum) mysql is my driver.
 
 To configure test database you will need to check phpunit.xml;
 
 At the end of the file you have this i provide my example
 
 
 
        <env name="APP_ENV" value="testing"/>
        <env name="DB_CONNECTION" value="mysql"/>
        <env name="DB_DATABASE" value="testing_forum"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
   
 
 
 if you want to check all tests you type this command in the project root folder.
 
   vendor/bin/phpunit  
   
   
  if you want specific test to test you type this command in project root
  
   vendor/bin/phpunit --filter NAME_OF_YOUR_TEST
 
 
 
 Next i dont have seeds yet but i have factory for users, threads and replies, so if you want to populate your database 
 
 go this commands.
 
 
 
php artisan tinker to enter the shell and to be able to mess with our app's data.

factory('App\Thread', 50)->create(); to create a 50 threads 

factory('App'Replay', 30)->create(['thread_id' => App\Thread::latest()->first()->id]);  to create 30 reply for latest thread 



Project and documentation isn't done yet this is only to start app and have some basic UI.
