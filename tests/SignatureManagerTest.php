<?php
use Bravist\Cnvex\SignatureManager;

class SignatureManagerTest extends PHPUnit_Framework_TestCase
{
    public function testDefaultSignerCanBeResolved()
    {
        $app = [
            'config' => [
                'signature' => [
                    'default' => 'md5',
                    'md5' => [
                        'driver' => 'md5',
                        'options' => [
                            'signKey' => '111'
                        ]
                    ]
                ]
            ]
        ];
        
        $manager = new SignatureManager($app);
        $this->assertEquals('96e79218965eb72c92a549dd5a330112', $manager->signer()->sign('111'));
    }
}
