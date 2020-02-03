<?php

namespace App\Service\Abstraction;

use App\Service\Abstraction\AwsS3Interface;
use App\Service\AwsS3Service;
use Aws\S3\S3Client;

/**
 * Class AmazonS3Service
 *
 * @package Acme\DemoBundle\Service
 */
abstract class AbstractAwsS3 implements AwsS3Interface
{
    const IMAGE_PATH = '/images/';
    const PUBLIC_PATH = '/home/user/workspace/test-sym/public';

    /**
     * @var S3Client
     */
    private $client;

    /**
     * @var mixed
     */
    private $bucket;

    /**
     * @param string $bucket
     * @param array  $s3arguments
     */
    public function __construct(string $bucket, array $s3arguments)
    {
        $this->setBucket($bucket);
        $this->setClient(new S3Client([
            'credentials' => $s3arguments['credentials'],
            'region'      => $s3arguments['region'],
            'version'     => $s3arguments['version']
        ]));
    }

    protected function isBucketExists()
    {
        return $this->getClient()->doesBucketExist($this->getBucket());
    }

    /**
     * Getter of client
     *
     * @return S3Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Setter of client
     *
     * @param S3Client $client
     *
     * @return $this
     */
    public function setClient(S3Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Getter of bucket
     *
     * @return string
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * Setter of bucket
     *
     * @param string $bucket
     *
     * @return $this
     */
    public function setBucket($bucket)
    {
        $this->bucket = $bucket;

        return $this;
    }
}