<?php

namespace App\Service;

use App\Service\Abstraction\AbstractAwsS3;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AmazonS3Service
 *
 * @package Acme\DemoBundle\Service
 */
class AwsS3GetterService extends AbstractAwsS3
{
    /**
     * @param string $fileName
     * @param string $content
     * @param array  $meta
     * @param string $privacy
     * @return string file url
     */
    public function getFile($fileName)
    {
        if ($this->isBucketExists()) {
            $result = $this->getClient()->getObject(['Bucket' => $this->getBucket(), 'Key' => $fileName]);
            return $this->decodeImage($result['Body'], rand(0,1000000) . 'file' . rand(0,1000000) . '.jpg');
        } else {
            throw new NotFoundHttpException(sprintf('%s - bucket is not exists', $this->getBucket()));
        }
    }

    private function decodeImage($body, $newFilename)
    {
        $ifp = fopen( AbstractAwsS3::PUBLIC_PATH . AbstractAwsS3::IMAGE_PATH . $newFilename, 'wb' );
        //$data = explode( ',', $body );
        fwrite($ifp,  $body);
        fclose($ifp);

        return AbstractAwsS3::IMAGE_PATH . $newFilename;
    }
}