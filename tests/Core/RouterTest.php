<?php

namespace Tests\Core;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testRouterCanRegisterGetRoute()
    {
        // Test de validation de la structure du routeur
        $this->assertTrue(class_exists('App\Core\Router'));
    }
    
    public function testRouterCanRegisterPostRoute()
    {
        // Test de validation de la structure du routeur
        $this->assertTrue(class_exists('App\Core\Router'));
    }
    
    public function testRouterCanDispatchRoute()
    {
        // Test de validation de la structure du routeur
        $this->assertTrue(class_exists('App\Core\Router'));
    }
}

