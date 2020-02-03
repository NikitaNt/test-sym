<?php

namespace App\Service;

use App\Service\Abstraction\AbstractAwsS3;
use App\Service\Abstraction\AwsS3Interface;
use Aws\S3\S3Client;
use phpDocumentor\Reflection\Types\Mixed_;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AmazonS3Service
 *
 * @package Acme\DemoBundle\Service
 */
class AwsS3Service extends AbstractAwsS3
{
    /**
     * @param string $fileName
     * @param string $content
     * @param array  $meta
     * @param string $privacy
     * @return string file url
     */
    public function upload( $fileName, $content, array $meta = [], $privacy = 'private')
    {
        if ($this->isBucketExists()) {
            return $this->getClient()->upload($this->getBucket(), $fileName, $content, $privacy, [
                'Metadata' => $meta
            ])->toArray()['ObjectURL'];
        } else {
            throw new NotFoundHttpException(sprintf('%s - bucket is not exists', $this->getBucket()));
        }
    }

    /**
     * @param string       $fileName
     * @param string|null  $newFilename
     * @param array        $meta
     * @param string       $privacy
     * @return string file url
     */
    public function uploadFile($fileName, $newFilename = null, array $meta = [], $privacy = 'private') {
        $fileName = self::PUBLIC_PATH . self::IMAGE_PATH . $fileName;

        if(!$newFilename) {
            $newFilename = basename($fileName);
        }

        if(!isset($meta['contentType'])) {
            // Detect Mime Type
            $mimeTypeHandler = finfo_open(FILEINFO_MIME_TYPE);
            $meta['contentType'] = finfo_file($mimeTypeHandler, $fileName);
            finfo_close($mimeTypeHandler);
        }

        return $this->upload($newFilename, file_get_contents($fileName), $meta, $privacy);
    }
}