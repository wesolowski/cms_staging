<?php


namespace App\Model;

use App\Model\Dto\UserDataTransferObject;
use App\Model\Entity\User;
use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;

class UserEntityManager
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    private \Cycle\ORM\RepositoryInterface $ormUserRepository;
    private ORM $orm;

    public function __construct(ORM $orm, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->orm = $orm;
        $this->ormUserRepository = $orm->getRepository(User::class);
    }

    public function delete(UserDataTransferObject $user):void
    {
        $transaction = new Transaction($this->orm);
        $transaction->delete($this->ormUserRepository->findByPK($user->getUserId()));
        $transaction->run();

        $this->userRepository->getUserList();
    }

    public function save(UserDataTransferObject $user): UserDataTransferObject
    {
        $transaction = new Transaction($this->orm);
        $entity = $this->ormUserRepository->findByPK($user->getUserId());

        if (!$entity instanceof User) {
            $entity = new User();
        }
        $entity->setName($user->getUserName());
        $entity->setDescription($user->getUserPassword());

        $transaction->persist($entity);
        $transaction->run();

        $user->setUserId($entity->getId());

        return $user;
    }
}
