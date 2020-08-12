<?php
declare(strict_types=1);

namespace App\Backend\ImportProduct\Business\Model\Create;

use App\Backend\ImportProduct\Business\Model\IntegrityManager\IntegrityManagerInterface;
use App\Client\Product\Business\ProductBusinessFacadeInterface;
use App\Generated\Dto\CsvProductDataTransferObject;
use App\Generated\Dto\ProductDataTransferObject;


class Product implements ProductInterface
{
    private ProductBusinessFacadeInterface $productBusinessFacade;
    private IntegrityManagerInterface $integrityManager;

    public function __construct(ProductBusinessFacadeInterface $productBusinessFacade, IntegrityManagerInterface $integrityManager)
    {
        $this->productBusinessFacade = $productBusinessFacade;
        $this->integrityManager = $integrityManager;
    }

    public function createProduct(CsvProductDataTransferObject $csvDTO) : ?CsvProductDataTransferObject
    {
        if ($csvDTO->getArticleNumber() === '') {
            throw new \Exception('ArticleNumber must not be empty', 1);
        }

        $productFromRepo = $this->productBusinessFacade->get($csvDTO->getArticleNumber());
        if ($productFromRepo instanceof ProductDataTransferObject) {
            $csvDTO->setId($productFromRepo->getId());
            return $csvDTO;
        }
        $productDTO = new ProductDataTransferObject();
        $productDTO->setArticleNumber($csvDTO->getArticleNumber());
        $csvDTO->setId($this->productBusinessFacade->save($productDTO)->getId());
        //$csvDTO->setProduct($this->integrityManager->mapEntity($csvDTO));

        return $csvDTO;
    }
}
