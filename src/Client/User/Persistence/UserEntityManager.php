<?php

declare(strict_types=1);

namespace App\Client\User\Persistence;

use App\Client\User\Persistence\Entity\User;
use App\Generated\Dto\UserDataTransferObject;
use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;

class UserEntityManager implements UserEntityManagerInterface
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    private \Cycle\ORM\RepositoryInterface $ormUserRepository;
    private ORM $orm;

    /**
     * @param \Cycle\ORM\ORM $orm
     * @param \App\Client\User\Persistence\UserRepository $userRepository
     */
    public function __construct(ORM $orm, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->orm = $orm;
        $this->ormUserRepository = $orm->getRepository(User::class);
    }

    /**
     * @param \App\Generated\Dto\UserDataTransferObject $user
     */
    public function delete(UserDataTransferObject $user):void
    {
        $transaction = new Transaction($this->orm);
        $transaction->delete($this->ormUserRepository->findByPK($user->getUserId()));
        $transaction->run();

        $this->userRepository->getUserList();
    }

    /**
     * @param \App\Generated\Dto\UserDataTransferObject $user
     * @return \App\Generated\Dto\UserDataTransferObject
     */
    public function save(UserDataTransferObject $user): UserDataTransferObject
    {
        $transaction = new Transaction($this->orm);
        $entity = $this->ormUserRepository->findByPK($user->getUserId());

        if (!$entity instanceof User) {
            $entity = new User();
        }
        $entity->setUsername($user->getUserName());
        $entity->setPassword($user->getUserPassword());
        $entity->setRole($user->getUserRole());
        $entity->setSessionId($user->getSessionId());
        $entity->setResetPassword($user->getResetPassword());
        $entity->setShoppingCard(implode(',', $user->getShoppingCard()));
        $transaction->persist($entity);
        $transaction->run();

        $user->setUserId($entity->getId());

        return $user;
    }
}
