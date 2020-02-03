<?php

namespace App\Service\Abstraction;

use Aws\S3\S3Client;
use phpDocumentor\Reflection\Types\Mixed_;

/**
 * Class AmazonS3Service
 *
 * @package Acme\DemoBundle\Service
 */
interface AwsS3Interface
{
    public function getClient();

    public function setClient(S3Client $client);

    public function getBucket();

    public function setBucket($bucket);
}