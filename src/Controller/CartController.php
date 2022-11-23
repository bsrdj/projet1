<?php

namespace App\Controller;

use App\Tools\Cart\CartTools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    public function index(CartTools $cartTools)
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartTools->getFullCart(),
            'totalTVA' => $cartTools->getTotalTVA(),
            'tva' => $cartTools->getTva(),
            'totalItems' => $cartTools->getTotalItem(),
            'totalTTC' => $cartTools->getTotalTTC()            
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartTools $cartTools)
    {
        $cartTools->add($id);

        return $this->redirectToRoute('product_index');
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartTools $cartTools)
    {
         $cartTools->remove($id);       

        return $this->redirectToRoute('cart_index');
    }
}
