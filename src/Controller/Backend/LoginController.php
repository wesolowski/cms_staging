<?php
declare(strict_types=1);

namespace App\Controller\Backend;

use App\Controller\BackendController;
use App\Model\Dto\EmailDataTransferObject;
use App\Model\Dto\UserDataTransferObject;
use App\Model\UserEntityManager;
use App\Service\Container;
use App\Service\PasswordManager;
use App\Service\SymfonyMailerManager;
use App\Service\View;
use App\Model\UserRepository;
use App\Service\SessionUser;

class LoginController implements BackendController
{
    public const ROUTE = 'login';
    private View $view;
    private UserRepository $userRepository;
    private UserEntityManager $userEntityManager;
    private PasswordManager $passwordManager;
    private SessionUser $userSession;
    private SymfonyMailerManager $mailManager;


    public function __construct(Container $container)
    {
        $this->userSession = $container->get(SessionUser::class);
        $this->view = $container->get(View::class);
        $this->userRepository = $container->get(UserRepository::class);
        $this->userEntityManager = $container->get(UserEntityManager::class);
        $this->passwordManager = $container->get(PasswordManager::class);
        $this->mailManager = $container->get(SymfonyMailerManager::class);
    }

    public function init(): void
    {
        if ($this->userSession->isLoggedIn() && !($_GET['page'] === 'logout')) {
            $this->redirect(DashboardController::ROUTE, 'page=list');
        }
        $this->view->addTlpParam('login', 'LOGIN AREA');
    }

    public function loginAction(): void
    {
        if (isset($_POST['login']) && !empty(trim($_POST['username'])) && !empty(trim($_POST['password']))) {
            $username = (string)trim($_POST['username']);
            $password = (string)trim($_POST['password']);
            $userDTO = $this->userRepository->getUser($username);
            if ($userDTO instanceof UserDataTransferObject) {
                $this->loginUser($userDTO, $password, $username);
            }
            $this->view->addTlpParam('loginMessage', 'Invalid Username or Password');
        }

        $this->view->addTemplate('login.tpl');
    }
    public function resetAction()
    {
        $this->view->addTemplate('passwordReset.tpl');
        if (isset($_POST['resetpassword'])&& !empty(trim($_POST['email']))) {
            $username = (string)trim($_POST['email']);
            $userDTO = $this->userRepository->getUser($username);
            if ($userDTO instanceof UserDataTransferObject) {
                $resetCode = $this->passwordManager->createResetPassword();
                $emailDTO = new EmailDataTransferObject();
                $emailDTO->setTo($username);
                $emailDTO->setSubject('Reseting your Password');
                $emailDTO->setMessage('If you really have forgotten your password pls enter the following number:' . $resetCode);

                if ($this->mailManager->sendMail($emailDTO)) {
                    $sessionId = $this->setEmergencySession($username);
                    $this->setEmergencyUserData($sessionId, $resetCode, $userDTO);
                    $this->redirect(PasswordController::ROUTE, 'page=reset');
                } else {
                    throw new \Exception('Email could not be send.', 1);
                }
            } else {
                $this->view->addTlpParam('loginMessage', 'Invalid Username');
            }
        }
    }


    public function logoutAction()
    {
        $this->userSession->logoutUser();
        $this->redirect(LoginController::ROUTE, 'page=login');
    }
    private function loginUser(UserDataTransferObject $userDTO, string $password, string $username)
    {
        if ($this->passwordManager->checkPassword($password, $userDTO->getUserPassword())) {
            $this->userSession->loginUser($username);
            $this->userSession->setUserRole($userDTO->getUserRole());
            $this->redirect(DashboardController::ROUTE, 'page=list');
        }
    }
    private function redirect(String $cl, String $page): void
    {
        //$host = $_SERVER['HTTP_HOST'];
        $uri = trim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'Index.php?cl='.$cl;
        $extra2 = '&'.$page;
        $extra3 = '&admin=true';
        //header("Location: http://$host$uri/$extra$extra2$extra3");
        header("Location: http://localhost:8080$uri/$extra$extra2$extra3");
    }
    private function setEmergencySession(string $username):String
    {
        $sessionId = $this->passwordManager->encryptPassword($username.time());
        $this->userSession->setSessionTimer();
        $this->userSession->setSessionId($sessionId);
        $this->userSession->setUser($username);
        return $sessionId;
    }

    private function setEmergencyUserData(String $sessionId, string $resetCode, UserDataTransferObject $userDTO)
    {
        $userDTO->setSessionId($sessionId);
        $userDTO->setResetPassword($resetCode);
        $this->userEntityManager->save($userDTO);
    }
}
