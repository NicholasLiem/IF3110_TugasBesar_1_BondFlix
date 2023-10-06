<?php

namespace Handler\Upload;

use Core\Application\Services\UploadService;
use Exception;
use Handler\BaseHandler;
use Utils\Http\HttpStatusCode;
use Utils\Response\Response;
use Utils\Uploader\ImageUploader;

class UploadHandler extends BaseHandler
{
   protected static UploadHandler $instance;
   private UploadService $uploadService;

   private function __construct(UploadService $uploadService)
   {
       $this->uploadService = $uploadService;
   }

   public static function getInstance(UploadService $uploadService): UploadHandler
   {
       if (!isset(self::$instance)) {
           self::$instance = new static(
               $uploadService
           );
       }
       return self::$instance;
   }

   /**
    * @throws Exception
    */
    public function post($params = null): void
    {
        $targetFile = basename($_FILES["fileToUpload"]["name"]);
        $fileType = $_FILES["fileToUpload"]["type"];

        $imageType = ['image/jpeg', 'image/png', 'image/gif'];
        $videoType = ['video/mpeg', 'video/mp4'];

        try {
            $fileName = null;
            $statusCode = HttpStatusCode::BAD_REQUEST;
            $message = "Fail to upload file";

            if (in_array($fileType, $imageType)) {
                $fileName = $this->uploadService->uploadThumbnail($targetFile);
            } elseif (in_array($fileType, $videoType)) {
                $fileName = $this->uploadService->uploadVideo($targetFile);
            }

            if ($fileName !== null) {
                $statusCode = HttpStatusCode::OK;
                $message = "File uploaded successfully: " . $fileName;
            }

            $response = new Response(true, $statusCode, $message, null);
        } catch (Exception $e) {
            $response = new Response(false, HttpStatusCode::BAD_REQUEST, "Fail to upload file: " . $e->getMessage(), null);
        }

        $response->encode_to_JSON();
    }
}