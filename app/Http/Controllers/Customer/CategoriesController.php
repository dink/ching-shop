<?php

namespace ChingShop\Http\Controllers\Customer;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;

use ChingShop\Http\Controllers\Controller;
use ChingShop\Catalogue\Product\ProductRepository;

class CategoriesController extends Controller
{
    /** @var ProductRepository */
    private $productRepository;

    /** @var ViewFactory */
    private $viewFactory;

    /** @var ResponseFactory */
    private $responseFactory;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepository
     * @param ViewFactory $viewFactory
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        ProductRepository $productRepository,
        ViewFactory $viewFactory,
        ResponseFactory $responseFactory
    ) {
        $this->productRepository = $productRepository;
        $this->viewFactory = $viewFactory;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function viewAction()
    {
        $products = $this->productRepository->presentLatest();
        return $this->viewFactory->make(
            'customer.product.category',
            compact('products')
        );
    }
}
