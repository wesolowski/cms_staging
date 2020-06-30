<?php


namespace App\Tests\integration\Model;

use App\Model\CategoryEntityManager;
use App\Model\Dto\CategoryDataTransferObject;
use App\Model\Entity\Category;
use App\Service\DatabaseManager;
use App\Tests\integration\Helper\ContainerHelper;
use Cycle\ORM\Transaction;

/**
 * @group CategoryEntityManagerTest
 */

class CategoryEntityManagerTest extends \Codeception\Test\Unit
{
    private CategoryDataTransferObject $categoryDTO;
    private ContainerHelper $container;
    private CategoryEntityManager $categoryEntityManager;

    public function _before()
    {
        $this->container = new ContainerHelper();
        $this->categoryEntityManager = $this->container->getCategoryEntityManager();
        $this->createDto('testcategory');
    }

    public function _after()
    {
        $orm = new DatabaseManager();
        $orm = $orm->connect();
        $ormProductRepository = $orm->getRepository(Category::class);
        $transaction = new Transaction($orm);
        $transaction->delete($ormProductRepository->findByPK($this->categoryDTO->getCategoryId()));
        $transaction->run();
    }

    public function testCreateProduct()
    {

        $productFromRepository = $this->container->getCategoryRepository()->getCategory($this->categoryDTO->getCategoryId());
        $this->assertSame($this->categoryDTO->getCategoryId(), $productFromRepository->getCategoryId());
        $this->assertSame($this->categoryDTO->getCategoryKey(), $productFromRepository->getCategoryKey());

    }

    public function testUpdateProduct()
    {
        $this->testCreateProduct();
        $this->categoryDTO->setCategoryKey('fabulous');
        $this->categoryDTO = $this->categoryEntityManager->save($this->categoryDTO);
        $productFromRepository = $this->container->getCategoryRepository()->getCategory($this->categoryDTO->getCategoryId());

        $this->assertSame($this->categoryDTO->getCategoryKey(), $productFromRepository->getCategoryKey());
        $this->assertSame($this->categoryDTO->getCategoryId(), $productFromRepository->getCategoryId());
    }

    public function TestDeleteProduct()
    {
        $this->testCreateProduct();

        $this->categoryEntityManager->delete($this->categoryDTO);

        $this->assertNull($this->container->getCategoryRepository()->getCategory($this->categoryDTO->getCategoryId()));
    }

    private function createDto(String $categoryKey)
    {
        $this->categoryDTO = new CategoryDataTransferObject();
        $this->categoryDTO->setCategoryKey($categoryKey);
    }
}
