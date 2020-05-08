<?php
declare(strict_types=1);
namespace App\Controller\Backend;

use App\Controller\BackendController;
use App\Model\Dto\ProductDataTransferObject;
use App\Model\ProductEntityManager;
use App\Model\ProductRepository;
use App\Service\Container;
use App\Service\SessionUser;
use App\Service\View;

class ProductController implements BackendController
{
    public const ROUTE = 'product';
    private ProductRepository $productRepository;
    private ProductEntityManager $productEntityManager;
    private SessionUser $userSession;
    private View $view;

    public function __construct(Container $container)
    {
        $this->productRepository= $container->get(ProductRepository::class);
        $this->productEntityManager =$container->get(ProductEntityManager::class);
        $this->userSession=$container->get(SessionUser::class);
        $this->view= $container->get(View::class);
    }

    public function init(): void
    {
        if (!$this->userSession->isLoggedIn()) {
            $this->redirectToPage(LoginCOntroller::ROUTE);
        }
    }

    public function listAction()
    {
        $this->view->addTlpParam('productlist', $this->productRepository->getProductList());
        $this->view->addTemplate('productEditList.tpl');
        if (!empty($_POST)) {
            if (isset($_POST['logout'])) {
                $this->logout();
            }
        }
    }

    public function detailAction(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            switch ($_POST) {
                case !empty($_POST['delete']):
                    $this->deleteProduct((int)$_POST['delete']);
                    break;
                case !empty($_POST['save']):
                    $this->saveProduct((int)$_POST['save'], (string)$_POST['newpagename'], (string)$_POST['newpagedescription']);
                    break;
            }
        }
        $this->view->addTlpParam('', $this->productRepository->getProduct((int)$_GET['id']));
        $this->view->addTemplate('productEditPage.tpl');
    }

    private function deleteProduct(int $id): void
    {
        $this->productEntityManager->delete($this->productRepository->getProduct($id));
        $this->redirectToPage(DashboardController::ROUTE);
    }

    private function saveProduct(int $id, string $description, string $name): void
    {
        if (!empty($id)&& $this->productRepository->hasProduct($id)) {
            $dto = $this->productRepository->getProduct($id);
        } else {
            $dto = new ProductDataTransferObject();
        }
        $dto->setProductDescription($description);
        $dto->setProductName($name);

        $this->productEntityManager->save($dto);
    }

    private function logout(): void
    {
        $this->userSession->logoutUser();
        $this->redirectToPage(LoginController::ROUTE);
    }
    private function redirectToPage(string $route):void
    {
        $host = $_SERVER['HTTP_HOST'];
        $uri = trim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra= 'Index.php?cl='.$route;
        $extra2='&page=detail';
        $extra3='&admin=true';
        header("Location: http://$host$uri/$extra$extra2$extra3");
        exit;
    }
}