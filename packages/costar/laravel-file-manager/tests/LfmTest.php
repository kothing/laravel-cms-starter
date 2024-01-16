<?php

namespace Tests;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\Request;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Costar\LaravelFileManager\FileManager;
use Costar\LaravelFileManager\FileManagerFileRepository;
use Costar\LaravelFileManager\FileManagerStorageRepository;

class FileManagerTest extends TestCase
{
    public function tearDown()
    {
        m::close();

        parent::tearDown();
    }

    public function testGetStorage()
    {
        $config = m::mock(Config::class);
        $config->shouldReceive('get')->with('fileManager.disk')->once()->andReturn('local');

        $fileManager = new FileManager($config);
        $this->assertInstanceOf(FileManagerStorageRepository::class, $fileManager->getStorage('foo/bar'));
    }

    public function testInput()
    {
        $request = m::mock(Request::class);
        $request->shouldReceive('input')->with('foo')->andReturn('bar');

        $fileManager = new FileManager(m::mock(Config::class), $request);

        $this->assertEquals('bar', $fileManager->input('foo'));
    }

    public function testGetNameFromPath()
    {
        $this->assertEquals('bar', (new FileManager)->getNameFromPath('foo/bar'));
    }

    public function testAllowFolderType()
    {
        $config = m::mock(Config::class);
        $config->shouldReceive('get')->with('fileManager.allow_private_folder')->once()->andReturn(true);
        $config->shouldReceive('get')->with('fileManager.allow_private_folder')->once()->andReturn(false);
        $config->shouldReceive('get')->with('fileManager.allow_private_folder')->once()->andReturn(true);
        $config->shouldReceive('get')->with('fileManager.allow_shared_folder')->once()->andReturn(false);

        $fileManager = new FileManager($config);

        $this->assertTrue($fileManager->allowFolderType('user'));
        $this->assertTrue($fileManager->allowFolderType('shared'));
        $this->assertFalse($fileManager->allowFolderType('shared'));
    }

    public function testGetCategoryName()
    {
        $config = m::mock(Config::class);
        $config->shouldReceive('get')
               ->with('fileManager.folder_categories.file.folder_name', m::type('string'))
               ->once()
               ->andReturn('files');
        $config->shouldReceive('get')
               ->with('fileManager.folder_categories.image.folder_name', m::type('string'))
               ->once()
               ->andReturn('photos');
        $config->shouldReceive('get')
            ->with('fileManager.folder_categories')
            ->andReturn(['file' => [], 'image' => []]);

        $request = m::mock(Request::class);
        $request->shouldReceive('input')->with('type')->once()->andReturn('file');
        $request->shouldReceive('input')->with('type')->once()->andReturn('image');

        $fileManager = new FileManager($config, $request);

        $this->assertEquals('files', $fileManager->getCategoryName('file'));
        $this->assertEquals('photos', $fileManager->getCategoryName('image'));
    }

    public function testCurrentFileManagerType()
    {
        $request = m::mock(Request::class);
        $request->shouldReceive('input')->with('type')->once()->andReturn('file');
        $request->shouldReceive('input')->with('type')->once()->andReturn('image');
        $request->shouldReceive('input')->with('type')->once()->andReturn('foo');

        $config = m::mock(Config::class);
        $config->shouldReceive('get')
            ->with('fileManager.folder_categories')
            ->andReturn(['file' => [], 'image' => []]);

        $fileManager = new FileManager($config, $request);

        $this->assertEquals('file', $fileManager->currentFileManagerType());
        $this->assertEquals('image', $fileManager->currentFileManagerType());
        $this->assertEquals('file', $fileManager->currentFileManagerType());
    }

    public function testGetUserSlug()
    {
        $config = m::mock(Config::class);
        $config->shouldReceive('get')->with('fileManager.private_folder_name')->once()->andReturn(function () {
            return 'foo';
        });

        $fileManager = new FileManager($config);

        $this->assertEquals('foo', $fileManager->getUserSlug());
    }

    public function testGetRootFolder()
    {
        $config = m::mock(Config::class);
        $config->shouldReceive('get')->with('fileManager.allow_private_folder')->andReturn(true);
        $config->shouldReceive('get')->with('fileManager.private_folder_name')->once()->andReturn(function () {
            return 'foo';
        });
        $config->shouldReceive('get')->with('fileManager.shared_folder_name')->once()->andReturn('bar');

        $fileManager = new FileManager($config);

        $this->assertEquals('/foo', $fileManager->getRootFolder('user'));
        $this->assertEquals('/bar', $fileManager->getRootFolder('shared'));
    }

    public function testGetThumbFolderName()
    {
        $config = m::mock(Config::class);
        $config->shouldReceive('get')->with('fileManager.thumb_folder_name')->once()->andReturn('foo');

        $fileManager = new FileManager($config);

        $this->assertEquals('foo', $fileManager->getThumbFolderName());
    }

    public function testGetFileType()
    {
        $config = m::mock(Config::class);
        $config->shouldReceive('get')->with('fileManager.file_type_array.foo', m::type('string'))->once()->andReturn('foo');
        $config->shouldReceive('get')->with(m::type('string'), m::type('string'))->once()->andReturn('File');

        $fileManager = new FileManager($config);

        $this->assertEquals('foo', $fileManager->getFileType('foo'));
        $this->assertEquals('File', $fileManager->getFileType('bar'));
    }

    public function testAllowMultiUser()
    {
        $config = m::mock(Config::class);
        $config->shouldReceive('get')->with('fileManager.allow_private_folder')->once()->andReturn(true);

        $fileManager = new FileManager($config);

        $this->assertTrue($fileManager->allowMultiUser());
    }

    public function testAllowShareFolder()
    {
        $config = m::mock(Config::class);
        $config->shouldReceive('get')->with('fileManager.allow_private_folder')->once()->andReturn(false);
        $config->shouldReceive('get')->with('fileManager.allow_private_folder')->once()->andReturn(true);
        $config->shouldReceive('get')->with('fileManager.allow_shared_folder')->once()->andReturn(false);

        $fileManager = new FileManager($config);

        $this->assertTrue($fileManager->allowShareFolder());
        $this->assertFalse($fileManager->allowShareFolder());
    }

    public function testTranslateFromUtf8()
    {
        $input = 'test/測試';

        $this->assertEquals($input, (new FileManager)->translateFromUtf8($input));
    }
}
