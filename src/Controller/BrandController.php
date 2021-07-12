<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Form\BrandType;
use App\Repository\BrandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/brand', name: 'brand_')]
class BrandController extends AbstractController
{
    private BrandRepository $brandRepository;
    private EntityManagerInterface $entityManager;

    /**
     * BrandController constructor.
     * @param BrandRepository $brandRepository
     */
    public function __construct(BrandRepository $brandRepository, EntityManagerInterface $entityManager)
    {
        $this->brandRepository = $brandRepository;
        $this->entityManager = $entityManager;
    }


    #[Route('/', name: 'list')]
    public function index(): Response
    {
        $brands = $this->brandRepository->findAll();
        return $this->render(
            'brand/index.html.twig',
            [
                'brands' => $brands,
            ]
        );
    }



    #[Route('/{brand}', name: 'detail',requirements:['brand' => '\d+'])]
    public function detail( Brand $brand): Response {
        return $this->render(
            'brand/detail.html.twig',
            [
                'brand' => $brand
            ]
        );
    }

    #[Route('/update/{brand}', name: 'update')]
    public function update(
        Brand $brand, Request $request
    ): Response {
        $form = $this->createForm(BrandType::class, $brand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brand = $form->getData();
            $this->entityManager->persist($brand);
            $this->entityManager->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add("notice", $brand->getName() . " "
                                                 . $brand->getLogo()->getUrl() . "update");
            return $this->redirectToRoute(
                'brand_list'
            );
        }

        return $this->render(
            'brand/form.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    #[Route('/delete/{brand}', name: 'delete')]
    public function delete(
        Brand $brand, Request $request
    ): Response {
        $session = $request->getSession();
        $session->getFlashBag()->add("notice", $brand->getName()." ". "Deleted");
        $this->entityManager->remove($brand);
        $this->entityManager->flush();
        return $this->redirectToRoute(
            'brand_list');
    }

    #[Route('/add', name: 'add')]
    public function create( Request $request): Response
    {
        $form = $this->createForm(BrandType::class, new Brand());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brand = $form->getData();
            $this->entityManager->persist($brand);
            $this->entityManager->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add("notice", $brand->getName() . " "
                                                 . $brand->getLogo()->getUrl() . "Added");
            return $this->redirectToRoute(
                'brand_list'
            );
        }

        return $this->render(
            'brand/form.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }



}
