<?php

namespace App\Core;

class Config
{
    private static $config = [];

    /**
     * Charger un fichier de configuration
     */
    public static function load($file)
    {
        $configPath = __DIR__ . '/../../config/' . $file . '.php';
        
        if (file_exists($configPath)) {
            self::$config[$file] = require $configPath;
        }
    }

    /**
     * Récupérer une valeur de configuration
     * 
     * @param string $key Format: "fichier.cle" ou "fichier.env.cle"
     * @param mixed $default Valeur par défaut
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $keys = explode('.', $key);
        $file = array_shift($keys);

        // Charger le fichier si pas encore chargé
        if (!isset(self::$config[$file])) {
            self::load($file);
        }

        // Récupérer la valeur
        $value = self::$config[$file] ?? [];
        
        foreach ($keys as $k) {
            if (is_array($value) && isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }

        return $value;
    }

    /**
     * Récupérer la configuration selon l'environnement actuel
     */
    public static function getForEnv($file, $default = null)
    {
        $env = $_ENV['APP_ENV'] ?? 'development';
        return self::get($file . '.' . $env, $default);
    }
}

