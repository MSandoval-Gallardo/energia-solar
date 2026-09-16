<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost:3307;dbname=energia_solar;port=3307',
    'username' => 'energia_solar_app',
    'password' => 'EmVi1985$$',
    'charset' => 'utf8mb4',

    // 'class' => 'yii\db\Connection',
    // 'dsn' => 'mysql:host=localhost;dbname=energia_solar',
    // 'username' => 'energia_solar_app',
    // 'password' => 'SolarApp_2026_Segura!',
    // 'charset' => 'utf8mb4',
    // Para MariaDB específicamente
    // 'driver' => 'mysql',
    
    // Opciones adicionales útiles
    // 'enableSchemaCache' => false, // Desactivar mientras pruebas
    // 'schemaCacheDuration' => 3600,
    // 'schemaCache' => 'cache',



    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
