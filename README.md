![logo](assets/logo.png)

# Laravel Query Helper

Laravel Query Helper was developed for [laravel 7.2+](http://laravel.com/) to help you optimizing
sql queries, this package will contain all advanced sql queries to Help us write better and faster queries and clean code.

Features
--------
- Update multi records in one query.
- Chunk a large query to smaller pieces.

Installation
------------
##### 1 - Dependency
The first step is using composer to install the package and automatically update your composer.json file, you can do this by running:
```shell
composer require kmlaravel/laravel-query-helper
```
- #### Laravel uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.
##### 2 - Copy the package providers to your local config with the publish command, this will publish asset and config:
```shell
php artisan vendor:publish --provider="KMLaravel\QueryHelper\Providers\QueryHelperServiceProviders"
```
- #### or you may publish asset and config separately.
```shell
php artisan vendor:publish --tag=query-helper-config
```

Basic usage
-----------
Suppose we have a group of users who have an id and a name and we have an array to update each user with a new name 
as in the following example
```shell
    $usersDataBeforeUpdate = [
        ['id'  => 1, 'name' => 'example before update 1'],
        ['id'  => 2, 'name' => 'example before update 2'],
        ['id'  => 3, 'name' => 'example before update 2'],
     ];
    $usersDataToUpdate = [
        ['id'  => 1, 'name' => 'example after update 1'],
        ['id'  => 2, 'name' => 'example after update 2'],
        ['id'  => 3, 'name' => 'example after update 2'],
    ];

    // so the traditional way to that,
    // loop through $usersDataBeforeUpdate and fetch each user with specific (id, name)
    // and update his name with new name
    // and this will execute a query for each record, for the above array, the request will execute 3 queries
    //  what if we want to update 1000 records previously? 
    
    foreah($usersDataToUpdate as $user){
        User::find($user['id'])->update(['name' => $user['name']]);
    }

```
So the query helper will help you optimize this process, see the following explanation:
```php
    $usersDataBeforeUpdate = [
        ['id'  => 1, 'name' => 'example before update 1'],
        ['id'  => 2, 'name' => 'example before update 2'],
        ['id'  => 3, 'name' => 'example before update 2'],
     ];

    $usersDataToUpdate = [
        ['id'  => 1, 'name' => 'example after update 1'],
        ['id'  => 2, 'name' => 'example after update 2'],
        ['id'  => 3, 'name' => 'example after update 2'],
    ];

    $ids = [];
    $values = [];
    $cases = [];
    $tableName = 'users';
    $columnToUpdate = 'name';
    foreach($usersDataToUpdate as $user){

       array_push($ids , $user['id']);

       array_push($values , $user['name']);

       // if you want to set your cases in query.
       $cases[] = "WHEN id = {$user['id']} then ".$user['name'];
    }

    // if you want to set your cases in query.
    $cases = implode(' ', $cases);

    QueryHelper::updateInOneQueryInstance()
            ->setIds($ids)
            ->setValues($values)
            ->setTableName($tableName) // change this parameter value to your database table name.
            ->setFieldToUpdate($columnToUpdate) // change this parameter value to your database column name.
            ->bindIdsWithValues()
            ->executeUpdateMultiRows();

    // this will execute only one query.
```
What if you want to put your own Cases ?  **okay we support that**.
```php

    $query = QueryHelper::updateInOneQueryInstance()
            ->setIds($ids)
            ->setCasues($cases)
            ->setTableName($tableName) // change this parameter value to your database table name.
            ->setFieldToUpdate($columnToUpdate) // change this parameter value to your database column name.
            ->executeUpdateMultiRows();
```
What if you want dump the query which will execute ?  **okay we support that**.
```php

    $query = QueryHelper::updateInOneQueryInstance()
            ->setIds($ids)
            ->setValues($values)
            ->setTableName($tableName) // change this parameter value to your database table name.
            ->setFieldToUpdate($columnToUpdate) // change this parameter value to your database column name.
            ->buildStatement()
            ->getQuery();
    dd($query);

```
What if you want to reduce these lines in one line ?  **okay we support that**.
```php

    $query = QueryHelper::updateInOneQueryInstance()
            ->fastUpdate($tableName , $ids , $values , $columnToUpdate);
    dd($query);

```
In some databases, you can't do any process that require more than 65K of parameters,
so we have to chunk your large query to smaller pieces, and we can do that for you ar effective way.
```php
    // Suppose we have a group of users, let say's we have 100k items to insert.
    $users = [
    ['name' => 'example 1'],
    ['name' => 'example 2'],
    ['name' => 'example 3'],
    ['name' => 'example 4'],
    ...
    ];   
    QueryHelper::updateInOneQueryInstance()
        ->setAllowedWhereInQueryNumber(2000) // chunk size and you can update the default value from query_helper.php config file
        ->checkIfQueryAllowed($users , function ($data){
            User::insert($data);
        });
```

Changelog
---------
Please see the [CHANGELOG](https://github.com/karam-mustafa/laravel-query-helper/blob/main/CHANGELOG.md) for more information about what has changed or updated or added recently.

Security
--------
If you discover any security related issues, please email them first to karam2mustafa@gmail.com, 
if we do not fix it within a short period of time please open new issue describe your problem. 

Credits
-------
[karam mustafa](https://www.linkedin.com/in/karam2mustafa)
