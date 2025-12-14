<?php

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    private $userModel;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->userModel = new User();
    }
    
    public function testGetOriginTypes()
    {
        $originTypes = $this->userModel->getOriginTypes();
        
        $this->assertIsArray($originTypes);
        $this->assertCount(8, $originTypes);
        $this->assertContains('earth_renewed', $originTypes);
        $this->assertContains('oceanic_world', $originTypes);
        $this->assertContains('forest_megacity', $originTypes);
        $this->assertContains('orbital_habitat', $originTypes);
        $this->assertContains('desert_solar', $originTypes);
        $this->assertContains('synthetic_collective', $originTypes);
        $this->assertContains('luminous_dimension', $originTypes);
        $this->assertContains('nomadic_fleet', $originTypes);
    }
    
    public function testCreateValidatesGalacticName()
    {
        $data = [
            'galactic_name' => '', // Nom vide
            'origin_type' => 'earth_renewed',
            'bio_signature' => hash('sha256', 'test')
        ];
        
        $result = $this->userModel->create($data);
        $this->assertFalse($result);
    }
    
    public function testCreateValidatesGalacticNameLength()
    {
        $data = [
            'galactic_name' => str_repeat('A', 201), // Trop long (>200)
            'origin_type' => 'earth_renewed',
            'bio_signature' => hash('sha256', 'test')
        ];
        
        $result = $this->userModel->create($data);
        $this->assertFalse($result);
    }
    
    public function testCreateValidatesOriginType()
    {
        $data = [
            'galactic_name' => 'Test User',
            'origin_type' => 'invalid_type',
            'bio_signature' => hash('sha256', 'test')
        ];
        
        $result = $this->userModel->create($data);
        $this->assertFalse($result);
    }
    
    public function testCreateValidatesBioSignature()
    {
        $data = [
            'galactic_name' => 'Test User',
            'origin_type' => 'earth_renewed',
            'bio_signature' => 'too_short' // Doit faire 64 caractères
        ];
        
        $result = $this->userModel->create($data);
        $this->assertFalse($result);
    }
}

