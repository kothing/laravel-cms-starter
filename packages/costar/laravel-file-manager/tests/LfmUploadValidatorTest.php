<?php

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Costar\LaravelFileManager\Exceptions\DuplicateFileNameException;
use Costar\LaravelFileManager\Exceptions\EmptyFileException;
use Costar\LaravelFileManager\Exceptions\ExcutableFileException;
use Costar\LaravelFileManager\Exceptions\FileFailedToUploadException;
use Costar\LaravelFileManager\Exceptions\FileSizeExceedConfigurationMaximumException;
use Costar\LaravelFileManager\Exceptions\FileSizeExceedIniMaximumException;
use Costar\LaravelFileManager\Exceptions\InvalidMimeTypeException;
use Costar\LaravelFileManager\FileManagerPath;
use Costar\LaravelFileManager\FileManagerUploadValidator;

function trans()
{
    // leave empty
}

class FileManagerUploadValidatorTest extends TestCase
{
    public function testPassesSizeLowerThanIniMaximum()
    {
        $uploaded_file = m::mock(UploadedFile::class);
        $uploaded_file->shouldReceive('getError')->andReturn(UPLOAD_ERR_OK);

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->assertEquals($validator->sizeLowerThanIniMaximum(), $validator);
    }

    public function testFailsSizeLowerThanIniMaximum()
    {
        $uploaded_file = m::mock(UploadedFile::class);
        $uploaded_file->shouldReceive('getError')->andReturn(UPLOAD_ERR_INI_SIZE);

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->expectException(FileSizeExceedIniMaximumException::class);

        $validator->sizeLowerThanIniMaximum();
    }

    public function testPassesUploadWasSuccessful()
    {
        $uploaded_file = m::mock(UploadedFile::class);
        $uploaded_file->shouldReceive('getError')->andReturn(UPLOAD_ERR_OK);

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->assertEquals($validator->uploadWasSuccessful(), $validator);
    }

    public function testFailsUploadWasSuccessful()
    {
        $uploaded_file = m::mock(UploadedFile::class);
        $uploaded_file->shouldReceive('getError')->andReturn(UPLOAD_ERR_PARTIAL);

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->expectException(FileFailedToUploadException::class);

        $validator->uploadWasSuccessful();
    }

    public function testPassesNameIsNotDuplicate()
    {
        $uploaded_file = m::mock(UploadedFile::class);

        $fileManager_path = m::mock(FileManagerPath::class);
        $fileManager_path->shouldReceive('setName')->andReturn($fileManager_path);
        $fileManager_path->shouldReceive('exists')->andReturn(false);

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->assertEquals($validator->nameIsNotDuplicate('new_file_name', $fileManager_path), $validator);
    }

    public function testFailsNameIsNotDuplicate()
    {
        $uploaded_file = m::mock(UploadedFile::class);

        $fileManager_path = m::mock(FileManagerPath::class);
        $fileManager_path->shouldReceive('setName')->andReturn($fileManager_path);
        $fileManager_path->shouldReceive('exists')->andReturn(true);

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->expectException(DuplicateFileNameException::class);

        $validator->nameIsNotDuplicate('new_file_name', $fileManager_path);
    }

    public function testPassesIsNotExcutable()
    {
        $uploaded_file = m::mock(UploadedFile::class);
        $uploaded_file->shouldReceive('getMimeType')->andReturn('image/jpeg');

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->assertEquals($validator->isNotExcutable(), $validator);
    }

    public function testFailsIsNotExcutable()
    {
        $uploaded_file = m::mock(UploadedFile::class);
        $uploaded_file->shouldReceive('getMimeType')->andReturn('text/x-php');

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->expectException(ExcutableFileException::class);

        $validator->isNotExcutable();
    }

    public function testPassesMimeTypeIsValid()
    {
        $uploaded_file = m::mock(UploadedFile::class);
        $uploaded_file->shouldReceive('getMimeType')->andReturn('image/jpeg');

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->assertEquals($validator->mimeTypeIsValid(['image/jpeg']), $validator);
    }

    public function testFailsMimeTypeIsValid()
    {
        $uploaded_file = m::mock(UploadedFile::class);
        $uploaded_file->shouldReceive('getMimeType')->andReturn('image/jpeg');

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->expectException(InvalidMimeTypeException::class);

        $validator->mimeTypeIsValid(['image/png']);
    }

    public function testPassesSizeIsLowerThanConfiguredMaximum()
    {
        $uploaded_file = m::mock(UploadedFile::class);
        $uploaded_file->shouldReceive('getSize')->andReturn(500 * 1000);

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->assertEquals($validator->sizeIsLowerThanConfiguredMaximum(1000), $validator);
    }

    public function testFailsSizeIsLowerThanConfiguredMaximum()
    {
        $uploaded_file = m::mock(UploadedFile::class);
        $uploaded_file->shouldReceive('getSize')->andReturn(2000 * 1000);

        $validator = new FileManagerUploadValidator($uploaded_file);

        $this->expectException(FileSizeExceedConfigurationMaximumException::class);

        $validator->sizeIsLowerThanConfiguredMaximum(1000);
    }
}
