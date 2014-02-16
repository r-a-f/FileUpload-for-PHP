<?php

require( dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."src/FileUpload/FileUpload.php" );



class LoadTest extends \PHPUnit_Framework_TestCase
{
    protected $file;

    protected function setUp()
    {
        $_FILES = array(
            'test'  => array(
                'name'      => 'test.jpg',
                'type'      => 'image/png',
                'size'      => 1644,
                'tmp_name'  => __DIR__ . '/../resources/php-icon.png',
                'error'     => 0
            )
        );
        $this->file = new FileUpload\FileUpload;
    }
    protected function tearDown()
    {
        unset($_FILES);
        unset($this->file);
        @unlink(__DIR__.'/php-icon.png');
    }
    public function testReceive()
    {
        $this->file->setInput( "test" );
        $this->file->setAllowMimeType("image/png");
        $this->file->setUploadFunction("copy");
        $this->file->save();
        $this->assertTrue($this->file->getStatus());
    }
}