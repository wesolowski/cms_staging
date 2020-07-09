<?php
declare(strict_types=1);

namespace App\Frontend\Controller\Backend\Model;

use App\Component\Container;
use App\Component\View;
use App\Service\SessionUser;

class DashboardController implements BackendController
{
    public const ROUTE = 'dashboard';
    private View $view;
    private SessionUser $userSession;

    public function __construct(Container $container)
    {
        $this->userSession = $container->get(SessionUser::class);
        $this->view = $container->get(View::class);
    }

    public function init(): void
    {
        if (!$this->userSession->isLoggedIn()) {
            $this->redirectToPage(LoginController::ROUTE);
        }

    }
    public function action(): void
    {
        $userRole = $this->userSession->getUserRole();
        switch ($userRole) {
            case $userRole === 'user':
                $this->view->addTemplate('userDashboard.tpl');
                break;
            case $userRole === 'admin':
                $this->view->addTemplate('adminDashboard.tpl');
                break;

            case $userRole === 'root':

                $this->view->addTemplate('rootDashboard.tpl');
                break;

        }
        $this->view->addTlpParam('user', $this->userSession->getUser());
    }

    private function redirectToPage(string $route):void
    {
        // $host = $_SERVER['HTTP_HOST'];
        $uri = trim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'Index.php?cl='.$route;
        $extra2 = '&admin=true';
        $extra3 = '&page=list';
        header("Location: http://localhost:8080$uri/$extra$extra2$extra3");
        exit;
    }
}
