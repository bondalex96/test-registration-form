<?php

namespace App\Persistence\Repository\Doctrine;


use App\Domain\Entity\User\NickName;
use App\Domain\Entity\User\User;
use App\Domain\Repository\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class UserRepository implements \App\Domain\Repository\User\UserRepository
{
    private $em;
    private $entityRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->entityRepository = $this->em->getRepository(User::class);
    }

    public function save(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function getById(string $id): User
    {

        $user = $this->entityRepository->find($id);

        if (!$user) {
            throw new NotFoundException('User not found!');
        }

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->entityRepository->findOneBy(['email' => $email]);
    }

    public function findByNick(NickName $nick): ?User
    {
        return $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.nickName.name = :nickName')
            ->setMaxResults(1)
            ->setParameter(':nickName', $nick->getNickname())
            ->getQuery()
            ->getOneOrNullResult();
        return $this->entityRepository->findOneBy(['nick' => $nick->getNickname()]);
    }

    public function removeAll(): void
    {
        $this
            ->em
            ->createQueryBuilder()
            ->delete(User::class, 'u')
            ->getQuery()
            ->execute();
    }

    public function nextId(): string
    {
        return Uuid::uuid4()->toString();
    }
}
