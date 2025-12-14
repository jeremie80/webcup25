<?php

namespace Tests\Core;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    public function testDatabaseClassExists()
    {
        $this->assertTrue(class_exists('App\Core\Database'));
    }
    
    public function testDatabaseIsSingleton()
    {
        // Vérifier que la classe Database implémente le pattern Singleton
        $reflection = new \ReflectionClass('App\Core\Database');
        
        // Vérifier que le constructeur est privé
        $constructor = $reflection->getConstructor();
        $this->assertTrue($constructor->isPrivate());
        
        // Vérifier qu'il existe une méthode getInstance
        $this->assertTrue($reflection->hasMethod('getInstance'));
        $this->assertTrue($reflection->getMethod('getInstance')->isStatic());
    }
}

