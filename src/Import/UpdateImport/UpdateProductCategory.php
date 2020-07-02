<?php
declare(strict_types=1);

namespace App\Import\UpdateImport;

use App\Import\IntegrityManager\CategoryIntegrityManagerInterface;
use App\Model\CategoryEntityManagerInterface;
use App\Model\CategoryRepositoryInterface;
use App\Model\Dto\CategoryDataTransferObject;
use App\Model\Dto\CsvDataTransferObject;
use App\Model\Dto\ProductDataTransferObject;
use App\Model\ProductEntityManagerInterface;
use function PHPUnit\Framework\isEmpty;

class UpdateProductCategory implements UpdateProductCategoryInterface
{
    private CategoryRepositoryInterface $categoryRepository;
    private CategoryEntityManagerInterface $categoryEntityManager;
    private CategoryIntegrityManagerInterface $categoryIntegrityManager;
    private ProductEntityManagerInterface $productEntityManager;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CategoryEntityManagerInterface $categoryEntityManager,
        ProductEntityManagerInterface $productEntityManager,
        CategoryIntegrityManagerInterface $categoryIntegrityManager
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryEntityManager = $categoryEntityManager;
        $this->productEntityManager = $productEntityManager;
        $this->categoryIntegrityManager = $categoryIntegrityManager;
    }

    public function updateProductCategory(CsvDataTransferObject $csvDTO): CsvDataTransferObject
    {
        if ($csvDTO->getCategoryKey() === '') {
            throw new \Exception('CategoryKey must not be empty', 1);
        } else {
            $category = $this->categoryRepository->getCategory($csvDTO->getCategoryId());
            if ($category instanceof CategoryDataTransferObject) {
                $csvDTO->setCategoryId($category->getCategoryId());
            } else {
                $category = new CategoryDataTransferObject();
                $category->setCategoryKey($csvDTO->getCategoryKey());
                $csvDTO->setCategoryId($this->categoryEntityManager->save($category)->getCategoryId());
                $csvDTO->setCategory($this->categoryIntegrityManager->mapEntity($csvDTO));
            }
            $this->saveUpdatedProduct($csvDTO);
        }
        return $csvDTO;
    }

    private function saveUpdatedProduct(CsvDataTransferObject $csvDTO)
    {
        $productDTO = new ProductDataTransferObject();
        if (!empty($csvDTO->getProductId())) {
            $productDTO->setProductId($csvDTO->getProductId());
        }

        $productDTO->setArticleNumber($csvDTO->getArticleNumber());
        $productDTO->setCategory($csvDTO->getCategory());
        $this->productEntityManager->save($productDTO);
    }
}
