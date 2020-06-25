<?php
declare(strict_types=1);

namespace App\Model\Mapper;

use App\Model\Dto\ProductDataTransferObject;
use App\Model\Entity\Product;

class ProductImportMapper implements ProductMapperInterface
{
    public function map(Product $product): ProductDataTransferObject
    {
        $productDataTransferObject = new ProductDataTransferObject();
        $productDataTransferObject->setName($product->getName());
        $productDataTransferObject->setDescription($product->getDescription());
        $productDataTransferObject->setArticleNumber($product->getArticleNumber());
        $productDataTransferObject->setCategory($product->getCategory());

        return $productDataTransferObject;
    }
}
