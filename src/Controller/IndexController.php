<?php

namespace App\Controller;

use App\Service\AwsS3GetterService;
use App\Service\AwsS3Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private $s3Service;

    private $awsS3GetterService;

    /**
     * IndexController constructor.
     * @param AwsS3Service $awsS3Service
     * @param AwsS3GetterService $awsS3GetterService
     */
    public function __construct(AwsS3Service $awsS3Service, AwsS3GetterService $awsS3GetterService)
    {
        $this->s3Service = $awsS3Service;
        $this->awsS3GetterService = $awsS3GetterService;
    }

    /**
     * @Route("/", name="index")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $result = $this->s3Service->uploadFile('1.jpg', 'image/jpg/test-image' . rand(0,999999999) . '.jpg');
        //$result = '1';
        return $this->render('index/index.html.twig', [
            'controller_name' => 'Index',
            'result' => $result
        ]);
    }

    /**
     * @Route("/get-image", name="get_image")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getImage(Request $request)
    {
        $result = $this->awsS3GetterService->getFile('test-image.jpg');

        return $this->render('index/get.html.twig', [
            'controller_name' => 'getter',
            'result' => $result
        ]);
    }
}
