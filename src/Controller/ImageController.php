<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Image;
use App\Form\CarType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/image', name: 'image_')]
class ImageController extends AbstractController
{
    private $imageRepository;
    private $entityManagerInterface;



    public function __construct(
        ImageRepository $imageRepository,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface
    ) {
        $this->imageRepository = $imageRepository;
        $this->entityManagerInterface = $entityManagerInterface;
    }


    #[Route('/', name: 'list')]
    public function index(): Response
    {
        $images = $this->imageRepository->findAll();

        return $this->render(
            'image/index.html.twig',
            [
                'images' => $images,
            ]
        );
    }


}
