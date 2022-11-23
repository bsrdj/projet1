<?php

namespace App\Tools\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartTools
{

    protected $session;
    protected $productRepository;
    public $tva = 5.5;

    /**
     * Constructeur de la class panier outils
     *
     * @param SessionInterface $session
     * @param ProductRepository $productRepository
     */
    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    /**
     * Ajouter produit(s) au panier
     *
     * @param integer $id
     * @return void
     */
    public function add(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $this->session->set('panier', $panier);
    }

    /**
     * Supprime élément(s) du panier
     *
     * @param integer $id
     * @return void
     */
    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    /**
     * Contenu du panier 
     *
     * @return array
     */
    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $panierWithData;
    }

    /**
     * Total du panier
     *
     * @return float
     */
    public function getTotalTTC(): float
    {
        $total = 0;

        foreach ($this->getFullCart() as $item) {
            $total += number_format($item['product']->getPrice(), 2) * $item['quantity'];
        }
        return $total;
    }

    /**
     * Nb d'article du panier
     *
     * @return int
     */
    public function getTotalItem()
    {
        $total = 0;

        foreach ($this->getFullCart() as $item) {
            $total += $item['quantity'];
        }
        return $total;
    }

    /**
     * return TVA
     *
     * @return void
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Calcul TVA
     *
     * @return float
     */
    public function getTotalTVA()
    {
        $total = $this->getTotalTTC();
        return number_format($total * $this->getTva() / 100, 2);
    }


}
