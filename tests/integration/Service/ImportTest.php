<?php
namespace App\Tests\integration\Service;


use App\Backend\ImportComponent\Loader\CsvImportLoader;
use App\Backend\ImportProduct\Business\Model\Importer;
use App\Client\Product\Persistence\ProductRepository;
use App\Client\Product\Persistence\Entity\Product;
use App\Tests\integration\Helper\ContainerHelper;
use Symfony\Component\Filesystem\Filesystem;
use UnitTester;

/**
 * @group Import
 */


class ImportTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester $tester
     */
    protected UnitTester $tester;

    protected ContainerHelper $container;
    protected ProductRepository $productRepository;

    protected Importer $importer;
    protected CsvImportLoader $csvLoader;
    protected String $path;
    protected Filesystem $filesystem;

    protected function _before()
    {
        $this->filesystem = new Filesystem();
        $this->container = new ContainerHelper();
        $this->productRepository = $this->container->getProductRepository();
        $this->csvLoader = $this->container->getCsvImportLoader();


        $this->path = dirname(__DIR__, 4).'/MVC/import/test';

        $this->importer = new Importer(
            $this->csvLoader,
            $this->container->getCreateProduct(),
            $this->container->getUpdateImport(),
            $this->path,

        );
    }

    protected function _after()
    {
        parent::_after();
        unset($_SERVER['REQUEST_METHOD']);
        $this->deleteTestArticleFromDB();
        $this->setBackFiles('/import/dumper/test_product_abstract.csv', '/import/test/test_product_abstract.csv');
    }

    // tests
    public function testProductImportNewProduct(): void
    {
        $importList = $this->csvLoader->mapCSVToDTO($this->path);
        $this->setBackFiles('/import/dumper/test_product_abstract.csv', '/import/test/test_product_abstract.csv');
        $this->importer->import();
        foreach ($importList as $product) {
            $productFromRepository = $this->productRepository->getProduct($product->getArticleNumber());
            if ($productFromRepository !== null) {
                $this->assertSame($product->getProductName(), $productFromRepository->getProductName());
                $this->assertSame($product->getProductDescription(), $productFromRepository->getProductDescription());
            }
        }
    }

    public function testProductImportUpdate():void
    {
        $this->importer->import();
        $importList = $this->csvLoader->mapCSVToDTO(dirname(__DIR__, 3).'/import/testUpdate/');
        $this->setBackFiles('/import/dumper/test_product_abstract2.csv', '/import/test/test_product_abstract2.csv');
        $this->importer->import();

        foreach ($importList as $product) {
            $productFromRepository = $this->productRepository->getProduct($product->getArticleNumber());
            if ($productFromRepository !== null) {
                $this->assertSame($product->getProductName(), $productFromRepository->getProductName());
                $this->assertSame($product->getProductDescription(), $productFromRepository->getProductDescription());
            }
        }
        $this->setBackFiles('/import/dumper/test_product_abstract2.csv', '/import/testUpdate/test_product_abstract2.csv');
    }




    public function deleteTestArticleFromDB()
    {
        $orm = $this->container->getOrmProductRepository();
        $source = $orm->getSource(Product::class);
        $db = $source->getDatabase();
        $db->execute('DELETE FROM product WHERE article_number LIKE \'Unit%\' ');
    }

    private function setBackFiles(string $origin, string $target)
    {
        $this->filesystem->copy(
            dirname(__DIR__, 3).$origin,
            dirname(__DIR__, 3).$target
        );
        $this->filesystem->remove(dirname(__DIR__, 3).$origin);
    }
    
}