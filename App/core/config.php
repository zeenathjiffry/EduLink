<?php
if($_SERVER['SERVER_NAME'] == 'localhost')
{
    /**database config */
    define('DBNAME','my_db');
    define('DBHOST','localhost');
    define('DBUSER','root');
    define('DBPASS','');

    define('ROOT','http://localhost/MVC/public');
}
else
{
    define('ROOT','http://www.EduLink.lk');
}
