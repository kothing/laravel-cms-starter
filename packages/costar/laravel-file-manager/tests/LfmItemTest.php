<?php

namespace Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Costar\LaravelFileManager\FileManager;
use Costar\LaravelFileManager\FileManagerItem;
use Costar\LaravelFileManager\FileManagerPath;

class FileManagerItemTest extends TestCase
{
    private $fileManager_path;
    private $fileManager;

    public function setUp()
    {
        $this->fileManager = m::mock(FileManager::class);

        $this->fileManager_path = m::mock(FileManagerPath::class);
        $this->fileManager_path->shouldReceive('thumb')->andReturn($this->fileManager_path);
        $this->fileManager->shouldReceive('config')
            ->with('item_columns')
            ->andReturn(['name', 'url', 'time', 'icon', 'is_file', 'is_image', 'thumb_url']);
    }

    public function tearDown()
    {
        m::close();

        parent::tearDown();
    }

    public function testMagicGet()
    {
        $this->fileManager_item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->fileManager_item->attributes['foo'] = 'bar';

        $this->assertEquals('bar', $this->fileManager_item->foo);
    }

    public function testName()
    {
        $this->fileManager_path->shouldReceive('getName')->andReturn('bar');

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertEquals('bar', $item->name());
    }

    public function testAbsolutePath()
    {
        $this->fileManager_path->shouldReceive('path')->with('absolute')->andReturn('foo/bar.baz');

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertEquals('foo/bar.baz', $item->path());
    }

    public function testIsDirectory()
    {
        $this->fileManager_path->shouldReceive('isDirectory')->andReturn(false);

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertFalse($item->isDirectory());
    }

    public function testIsFile()
    {
        $this->fileManager_path->shouldReceive('isDirectory')->andReturn(false);

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertTrue($item->isFile());
    }

    public function testIsImage()
    {
        $this->fileManager_path->shouldReceive('mimeType')->andReturn('application/plain')->shouldReceive('isDirectory')
            ->andReturn(false);

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertFalse($item->isImage());
    }

    public function testMimeType()
    {
        $this->fileManager_path->shouldReceive('mimeType')->andReturn('application/plain');

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertEquals('application/plain', $item->mimeType());
    }

    public function testType()
    {
        $this->fileManager_path->shouldReceive('isDirectory')->andReturn(false);
        $this->fileManager_path->shouldReceive('mimeType')->andReturn('application/plain');
        $this->fileManager_path->shouldReceive('path')->with('absolute')->andReturn('foo/bar.baz');
        $this->fileManager_path->shouldReceive('extension')->andReturn('baz');

        $this->fileManager->shouldReceive('getFileType')->with('baz')->andReturn('File');

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertEquals('File', $item->type());
    }

    public function testExtension()
    {
        $this->fileManager_path->shouldReceive('path')->with('absolute')->andReturn('foo/bar.baz');
        $this->fileManager_path->shouldReceive('extension')->andReturn('baz');

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertEquals('baz', $item->extension());
    }

    public function testThumbUrl()
    {
        $this->fileManager_path->shouldReceive('isDirectory')->andReturn(false);
        $this->fileManager_path->shouldReceive('mimeType')->andReturn('application/plain');

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertNull($item->thumbUrl());
    }

    // TODO: refactor
    public function testUrl()
    {
        $this->fileManager_path->shouldReceive('isDirectory')->andReturn(false);
        $this->fileManager_path->shouldReceive('getName')->andReturn('bar');
        $this->fileManager_path->shouldReceive('setName')->andReturn($this->fileManager_path);
        $this->fileManager_path->shouldReceive('url')->andReturn('foo/bar');

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertEquals('foo/bar', $item->url());
    }

    public function testSize()
    {
        $this->fileManager_path->shouldReceive('size')->andReturn(1024);
        $this->fileManager_path->shouldReceive('isDirectory')->andReturn(false);

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertEquals('1.00 kB', $item->size());
    }

    public function testTime()
    {
        $this->fileManager_path->shouldReceive('lastModified')->andReturn(0)->shouldReceive('isDirectory')
            ->andReturn(false);

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertEquals(0, $item->time());
    }

    public function testIcon()
    {
        $this->fileManager_path->shouldReceive('isDirectory')->andReturn(false);
        $this->fileManager_path->shouldReceive('mimeType')->andReturn('application/plain');
        $this->fileManager_path->shouldReceive('path')->with('absolute')->andReturn('foo/bar.baz');
        $this->fileManager_path->shouldReceive('extension')->andReturn('baz');

        $this->fileManager->shouldReceive('getFileIcon')->with('baz')->andReturn('fa-file');

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertEquals('baz', $item->icon());

        // $path1 = m::mock(FileManagerPath::class);
        // $path1->shouldReceive('path')->with('absolute')->andReturn('foo/bar');
        // $path1->shouldReceive('isDirectory')->andReturn(false);
        // $path1->shouldReceive('mimeType')->andReturn('image/png');

        // $path3 = m::mock(FileManagerPath::class);
        // $path3->shouldReceive('path')->with('absolute')->andReturn('foo/biz');
        // $path3->shouldReceive('isDirectory')->andReturn(true);

        // $this->assertEquals('fa-image',    (new FileManagerItem($path1))->icon());
        // $this->assertEquals('fa-folder-o', (new FileManagerItem($path3))->icon());
    }

    public function testHasThumb()
    {
        $this->fileManager_path->shouldReceive('mimeType')->andReturn('application/plain')->shouldReceive('isDirectory')
            ->andReturn(false);

        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertFalse($item->hasThumb());
    }

    public function testHumanFilesize()
    {
        $item = new FileManagerItem($this->fileManager_path, $this->fileManager);

        $this->assertEquals('1.00 kB', $item->humanFilesize(1024));
        $this->assertEquals('1.00 MB', $item->humanFilesize(1024 ** 2));
        $this->assertEquals('1.00 GB', $item->humanFilesize(1024 ** 3));
        $this->assertEquals('1.00 TB', $item->humanFilesize(1024 ** 4));
        $this->assertEquals('1.00 PB', $item->humanFilesize(1024 ** 5));
        $this->assertEquals('1.00 EB', $item->humanFilesize(1024 ** 6));
    }
}
