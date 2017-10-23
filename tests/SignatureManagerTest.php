<?php
use Bravist\Cnvex\SignatureManager;

class SignatureManagerTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultSignerCanBeResolved()
    {
        $app = [
            'signature' => [
                'default' => 'md5',
                'md5' => [
                    'driver' => 'md5',
                    'options' => [
                        'signKey' => '111'
                    ]
                ]
            ]
        ];
        
        $manager = new SignatureManager($app['signature']);
        $this->assertEquals('8e1ddb64207846dfce403fae54824c05', $manager->signer()->sign($app));
    }
}
