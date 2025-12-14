<?php

namespace Tests\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    private $profileModel;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->profileModel = new Profile();
    }
    
    public function testGetAtmosphereTypes()
    {
        $types = $this->profileModel->getAtmosphereTypes();
        
        $this->assertIsArray($types);
        $this->assertCount(4, $types);
        $this->assertContains('oxygen', $types);
        $this->assertContains('methane', $types);
        $this->assertContains('vacuum', $types);
        $this->assertContains('aquatic', $types);
    }
    
    public function testGetCommunicationModes()
    {
        $modes = $this->profileModel->getCommunicationModes();
        
        $this->assertIsArray($modes);
        $this->assertCount(4, $modes);
        $this->assertContains('verbal', $modes);
        $this->assertContains('telepathic', $modes);
        $this->assertContains('chemical', $modes);
        $this->assertContains('luminous', $modes);
    }
    
    public function testGetTechLevels()
    {
        $levels = $this->profileModel->getTechLevels();
        
        $this->assertIsArray($levels);
        $this->assertCount(3, $levels);
        $this->assertContains('organic', $levels);
        $this->assertContains('hybrid', $levels);
        $this->assertContains('advanced', $levels);
    }
    
    public function testGetCoreValues()
    {
        $values = $this->profileModel->getCoreValues();
        
        $this->assertIsArray($values);
        $this->assertCount(4, $values);
        $this->assertContains('harmony', $values);
        $this->assertContains('survival', $values);
        $this->assertContains('expansion', $values);
        $this->assertContains('knowledge', $values);
    }
    
    public function testCreateValidatesUserId()
    {
        $data = [
            'user_id' => '', // Vide
            'atmosphere_type' => 'oxygen',
            'communication_mode' => 'verbal',
            'tech_level' => 'organic',
            'core_value' => 'harmony',
            'avatar_path' => 'test.jpg'
        ];
        
        $result = $this->profileModel->create($data);
        $this->assertFalse($result);
    }
    
    public function testCreateValidatesAtmosphereType()
    {
        $data = [
            'user_id' => 1,
            'atmosphere_type' => 'invalid',
            'communication_mode' => 'verbal',
            'tech_level' => 'organic',
            'core_value' => 'harmony',
            'avatar_path' => 'test.jpg'
        ];
        
        $result = $this->profileModel->create($data);
        $this->assertFalse($result);
    }
    
    public function testCreateValidatesCommunicationMode()
    {
        $data = [
            'user_id' => 1,
            'atmosphere_type' => 'oxygen',
            'communication_mode' => 'invalid',
            'tech_level' => 'organic',
            'core_value' => 'harmony',
            'avatar_path' => 'test.jpg'
        ];
        
        $result = $this->profileModel->create($data);
        $this->assertFalse($result);
    }
    
    public function testCreateValidatesTechLevel()
    {
        $data = [
            'user_id' => 1,
            'atmosphere_type' => 'oxygen',
            'communication_mode' => 'verbal',
            'tech_level' => 'invalid',
            'core_value' => 'harmony',
            'avatar_path' => 'test.jpg'
        ];
        
        $result = $this->profileModel->create($data);
        $this->assertFalse($result);
    }
    
    public function testCreateValidatesCoreValue()
    {
        $data = [
            'user_id' => 1,
            'atmosphere_type' => 'oxygen',
            'communication_mode' => 'verbal',
            'tech_level' => 'organic',
            'core_value' => 'invalid',
            'avatar_path' => 'test.jpg'
        ];
        
        $result = $this->profileModel->create($data);
        $this->assertFalse($result);
    }
    
    public function testCreateValidatesAvatarPath()
    {
        $data = [
            'user_id' => 1,
            'atmosphere_type' => 'oxygen',
            'communication_mode' => 'verbal',
            'tech_level' => 'organic',
            'core_value' => 'harmony',
            'avatar_path' => '' // Vide
        ];
        
        $result = $this->profileModel->create($data);
        $this->assertFalse($result);
    }
}

