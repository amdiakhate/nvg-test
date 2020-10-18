<?php

namespace App\Controller\Web;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ListProductsAction
{

    private ProductRepository $productRepository;
    private Environment $templating;
    private PaginatorInterface $paginator;

    private const PAGE_SIZE = 30;

    /**
     * ListProductsAction constructor.
     * @param ProductRepository $productRepository
     * @param Environment $templating
     * @param PaginatorInterface $paginator
     */
    public function __construct(ProductRepository $productRepository, Environment $templating, PaginatorInterface $paginator)
    {
        $this->productRepository = $productRepository;
        $this->templating = $templating;
        $this->paginator = $paginator;
    }


    public function __invoke(Request $request)
    {
        $pagination = $this->paginator->paginate(
            $this->productRepository->getQuery(),
            $request->query->getInt('page', 1),
            self::PAGE_SIZE
        );

        return new Response($this->templating->render('product/list.html.twig', ['pagination' => $pagination]));
    }
}