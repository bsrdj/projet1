<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Tools\Cart\CartTools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index")
     */
    public function index(ProductRepository $productRepository, CartTools $cartTools)
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
            'totalItems' => $cartTools->getTotalItem()
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_view")
     */
    public function viewProduct($id, ProductRepository $productRepository, CartTools $cartTools)
    {
        return $this->render('product/view.html.twig', [
            'product' => $productRepository->find($id),
            'totalItems' => $cartTools->getTotalItem()
        ]);
    }
}
