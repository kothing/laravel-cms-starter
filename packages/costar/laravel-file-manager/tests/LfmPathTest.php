<?php

namespace Tests;

use Illuminate\Http\Request;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Costar\LaravelFileManager\FileManager;
use Costar\LaravelFileManager\FileManagerItem;
use Costar\LaravelFileManager\FileManagerPath;

class FileManagerPathTest extends TestCase
{
    public function tearDown()
    {
        m::close();

        parent::tearDown();
    }

    public function testMagicGet()
    {
        $storage = m::mock(FileManagerStorage::class);

        $helper = m::mock(FileManager::class);
        $helper->shouldReceive('getStorage')->with('files/bar')->andReturn($storage);
        $helper->shouldReceive('getCategoryName')->andReturn('files');
        $helper->shouldReceive('input')->with('working_dir')->andReturn('/bar');
        $helper->shouldReceive('isRunningOnWindows')->andReturn(false);
        $helper->shouldReceive('ds')->andReturn('/');

        $path = new FileManagerPath($helper);

        $this->assertEquals($storage, $path->storage);
    }

    public function testMagicCall()
    {
        $storage = m::mock(FileManagerStorage::class);
        $storage->shouldReceive('foo')->andReturn('bar');

        $helper = m::mock(FileManager::class);
        $helper->shouldReceive('getStorage')->with('files/bar')->andReturn($storage);
        $helper->shouldReceive('getCategoryName')->andReturn('files');
        $helper->shouldReceive('input')->with('working_dir')->andReturn('/bar');
        $helper->shouldReceive('isRunningOnWindows')->andReturn(false);
        $helper->shouldReceive('ds')->andReturn('/');

        $path = new FileManagerPath($helper);

        $this->assertEquals('bar', $path->foo());
    }

    public function testDirAndNormalizeWorkingDir()
    {
        $helper = m::mock(FileManager::class);
        $helper->shouldReceive('input')->with('working_dir')->once()->andReturn('foo');
        $helper->shouldReceive('isRunningOnWindows')->andReturn(false);

        $path = new FileManagerPath($helper);

        $this->assertEquals('foo', $path->normalizeWorkingDir());
        $this->assertEquals('bar', $path->dir('bar')->normalizeWorkingDir());
    }

    public function testSetNameAndGetName()
    {
        $path = new FileManagerPath(m::mock(FileManager::class));

        $path->setName('bar');

        $this->assertEquals('bar', $path->getName());
    }

    public function testPath()
    {
        $helper = m::mock(FileManager::class);
        $helper->shouldReceive('getRootFolder')->andReturn('/foo');
        $helper->shouldReceive('basePath')->andReturn(realpath(__DIR__ . '/../'));
        $helper->shouldReceive('input')->with('working_dir')->andReturnNull();
        $helper->shouldReceive('getCategoryName')->andReturn('files');
        $helper->shouldReceive('isRunningOnWindows')->andReturn(false);
        $helper->shouldReceive('ds')->andReturn('/');

        $storage = m::mock(FileManagerStorage::class);
        $storage->shouldReceive('rootPath')->andReturn(realpath(__DIR__ . '/../') . '/storage/app');

        $helper->shouldReceive('getStorage')->andReturn($storage);

        $path = new FileManagerPath($helper);

        $this->assertEquals('files/foo', $path->path());
        $this->assertEquals('files/foo/bar', $path->setName('bar')->path('storage'));
    }

    public function testUrl()
    {
        $helper = m::mock(FileManager::class);
        $helper->shouldReceive('getRootFolder')->andReturn('/foo');
        $helper->shouldReceive('input')->with('working_dir')->andReturnNull();
        $helper->shouldReceive('getCategoryName')->andReturn('files');
        $helper->shouldReceive('isRunningOnWindows')->andReturn(false);
        $helper->shouldReceive('ds')->andReturn('/');

        $storage = m::mock(FileManagerStorage::class);
        $storage->shouldReceive('url')->andReturn('/files/foo/foo');

        $helper->shouldReceive('getStorage')->andReturn($storage);

        $path = new FileManagerPath($helper);

        $this->assertEquals('/files/foo/foo', $path->setName('foo')->url());
    }

    public function testFolders()
    {
        $storage = m::mock(FileManagerStorage::class);
        $storage->shouldReceive('directories')->andReturn(['foo/bar']);

        $helper = m::mock(FileManager::class);
        $helper->shouldReceive('getCategoryName')->andReturn('files');
        $helper->shouldReceive('input')->with('working_dir')->andReturn('/shares');
        $helper->shouldReceive('input')->with('sort_type')->andReturn('alphabetic');
        $helper->shouldReceive('getStorage')->andReturn($storage);
        $helper->shouldReceive('getNameFromPath')->andReturn('bar');
        $helper->shouldReceive('getThumbFolderName')->andReturn('thumbs');
        $helper->shouldReceive('isRunningOnWindows')->andReturn(false);
        $helper->shouldReceive('ds')->andReturn('/');
        $helper->shouldReceive('config')
            ->with('item_columns')
            ->andReturn(['name', 'url', 'time', 'icon', 'is_file', 'is_image', 'thumb_url']);

        $path = new FileManagerPath($helper);

        $this->assertInstanceOf(FileManagerItem::class, $path->folders()[0]);
    }

    public function testFiles()
    {
        $storage = m::mock(FileManagerStorage::class);
        $storage->shouldReceive('files')->andReturn(['foo/bar']);

        $helper = m::mock(FileManager::class);
        $helper->shouldReceive('getCategoryName')->andReturn('files');
        $helper->shouldReceive('input')->with('working_dir')->andReturn('/shares');
        $helper->shouldReceive('input')->with('sort_type')->andReturn('alphabetic');
        $helper->shouldReceive('getStorage')->andReturn($storage);
        $helper->shouldReceive('getNameFromPath')->andReturn('bar');
        $helper->shouldReceive('isRunningOnWindows')->andReturn(false);
        $helper->shouldReceive('ds')->andReturn('/');
        $helper->shouldReceive('config')
            ->with('item_columns')
            ->andReturn(['name', 'url', 'time', 'icon', 'is_file', 'is_image', 'thumb_url']);

        $path = new FileManagerPath($helper);

        $this->assertInstanceOf(FileManagerItem::class, $path->files()[0]);
    }

    public function testPretty()
    {
        $helper = m::mock(FileManager::class);
        $helper->shouldReceive('getNameFromPath')->andReturn('bar');
        $helper->shouldReceive('isRunningOnWindows')->andReturn(false);
        $helper->shouldReceive('config')
            ->with('item_columns')
            ->andReturn(['name', 'url', 'time', 'icon', 'is_file', 'is_image', 'thumb_url']);

        $path = new FileManagerPath($helper);

        $this->assertInstanceOf(FileManagerItem::class, $path->pretty('foo'));
    }

    public function testCreateFolder()
    {
        $storage = m::mock(FileManagerStorage::class);
        $storage->shouldReceive('rootPath')->andReturn(realpath(__DIR__ . '/../') . '/storage/app');
        $storage->shouldReceive('exists')->andReturn(false);
        $storage->shouldReceive('makeDirectory')->andReturn(true);

        $helper = m::mock(FileManager::class);
        $helper->shouldReceive('getStorage')->with('files/bar')->andReturn($storage);
        $helper->shouldReceive('getCategoryName')->andReturn('files');
        $helper->shouldReceive('input')->with('working_dir')->andReturn('/bar');
        $helper->shouldReceive('isRunningOnWindows')->andReturn(false);
        $helper->shouldReceive('ds')->andReturn('/');

        $path = new FileManagerPath($helper);

        $this->assertNull($path->createFolder('bar'));
    }

    public function testCreateFolderButFolderAlreadyExists()
    {
        $storage = m::mock(FileManagerStorage::class);
        $storage->shouldReceive('exists')->andReturn(true);
        $storage->shouldReceive('makeDirectory')->andReturn(true);

        $helper = m::mock(FileManager::class);
        $helper->shouldReceive('getStorage')->with('files/bar')->andReturn($storage);
        $helper->shouldReceive('getCategoryName')->andReturn('files');
        $helper->shouldReceive('input')->with('working_dir')->andReturn('/bar');
        $helper->shouldReceive('isRunningOnWindows')->andReturn(false);
        $helper->shouldReceive('ds')->andReturn('/');

        $path = new FileManagerPath($helper);

        $this->assertFalse($path->createFolder('foo'));
    }
}
