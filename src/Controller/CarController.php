<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Image;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/car', name: 'car_')]
class CarController extends AbstractController
{
    private CarRepository $carRepository;
    private EntityManagerInterface $entityManager;
    private $sluggerInterface;


    /**
     * CarController constructor.
     * @param CarRepository $carRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        CarRepository $carRepository,
        EntityManagerInterface $entityManager,
        SluggerInterface $sluggerInterface
    ) {
        $this->carRepository = $carRepository;
        $this->entityManager = $entityManager;
        $this->sluggerInterface = $sluggerInterface;
    }


    #[Route('/', name: 'list')]
    public function index(): Response
    {
        $cars = $this->carRepository->findAll();

        return $this->render(
            'car/index.html.twig',
            [
                'cars' => $cars,
            ]
        );
    }

    #[Route('/{car}', name: 'detail', requirements: ['car' => '\d+'])]
    public function detail(
        Car $car
    ): Response {
        return $this->render(
            'car/detail.html.twig',
            [
                'car' => $car
            ]
        );
    }

    #[Route('/update/{car}', name: 'update')]
    public function update(
        Car $car,
        Request $request
    ): Response {
        $form = $this->createForm(CarType::class, $car);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $car = $form->getData();
            $this->entityManager->persist($car);
            $this->entityManager->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add(
                "notice",
                $car->getModel() . " "
                . $car->getBrand()->getName() . "update"
            );
            return $this->redirectToRoute(
                'car_list'
            );
        }

        return $this->render(
            'car/form.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/delete/{car}', name: 'delete')]
    public function delete(
        Car $car,
        Request $request
    ): Response {
        $session = $request->getSession();
        $session->getFlashBag()->add(
            "notice",
            $car->getModel() . " "
            . $car->getBrand()->getName() . "Deleted"
        );
        $this->entityManager->remove($car);
        $this->entityManager->flush();
        return $this->redirectToRoute(
            'car_list'
        );
    }

    #[Route('/add', name: 'add')]
    public function create(
        Request $request
    ): Response {
        $form = $this->createForm(CarType::class, new Car());
        $form->handleRequest($request);
        $car = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get("image")->getData();

            foreach ($images as $image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->sluggerInterface->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dump($e);
                    die();
                }

                $image = new Image();
                $image->setUrl($newFilename);
                $image->setName($originalFilename);
                $image->setAlt($newFilename . "_image");
//                remove if error
                $image->setCars($car);
                $car->addImage($image);
            }
            $this->entityManager->persist($car);
            $this->entityManager->flush();

            $session = $request->getSession();
            $session->getFlashBag()->add(
                "notice",
                $car->getModel() . " "
                . $car->getBrand()->getName() . "Added"
            );

            return $this->redirectToRoute(
                'car_list'
            );
        }

        return $this->render(
            'car/form.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

}
