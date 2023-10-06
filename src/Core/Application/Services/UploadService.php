<?php

namespace Core\Application\Services;

use Utils\FileDestroyer\FileDestroyer;
use Utils\Uploader\ImageUploader;
use Exception;
use Utils\Uploader\VideoUploader;

class UploadService
{
    public function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function uploadThumbnail($targetFile): ?string
    {
        try {
            $fileType = $_FILES["fileToUpload"]["type"];
            $uploadDir = '/thumbnails/';
            $imageType = ['image/jpeg', 'image/png', 'image/gif'];

            if (in_array($fileType, $imageType)) {
                $imageUploader = new ImageUploader();
                return $imageUploader->upload($targetFile, $uploadDir);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function uploadVideo($targetFile): ?string
    {
        try {
            $fileType = $_FILES["fileToUpload"]["type"];
            $uploadDir = '/videos/';
            $imageType = ['video/mpeg', 'video/mp4', 'video/quicktime', 'video/x-msvideo'];

            if (in_array($fileType, $imageType)) {
                $videoUploader = new VideoUploader();
                return $videoUploader->upload($targetFile, $uploadDir);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function uploadAvatar($targetFile): ?string
    {
        try {
            $fileType = $_FILES["fileToUpload"]["type"];
            $uploadDir = '/avatars/';
            $imageType = ['image/jpeg', 'image/png', 'image/gif'];

            if (in_array($fileType, $imageType)) {
                $imageUploader = new ImageUploader();
                return $imageUploader->upload($targetFile, $uploadDir);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteAvatar($fileName): bool
    {
        $fileDestroyer = new FileDestroyer();
        return $fileDestroyer->destroy($fileName, 'avatars');
    }

}