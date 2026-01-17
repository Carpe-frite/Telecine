<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findNewlyAddedEvents(int $amount) {
        $newlyAddedEvents = $this->findBy(['event_is_validated' => true], ['event_date' => 'DESC'], $amount);
        return $newlyAddedEvents;
    }


    public function findNotValidatedEvents() {
        $notValidatedEvents = $this->findBy(['event_is_validated' => false], ['event_date' => 'DESC']);
        return $notValidatedEvents;
    }

    public function findAllValidatedEvents() {
        $allValidatedEvents = $this->findBy(['event_is_validated' => true], ['event_date' => 'DESC']);
        return $allValidatedEvents;
    }

public function findEventsITakePartIn(User $user)
{
    $qb = $this->createQueryBuilder('e')
        ->innerJoin('e.participants', 'p')
        ->where('p.user = :user')
        ->setParameter('user', $user)
        ->orderBy('e.event_date', 'DESC');

    $query = $qb->getQuery();
    $result = $query->getResult();

    return $result;
}

    public function findAllGenresInEventMovies(): array {
        $entityManager = $this->getEntityManager();
        $dql = $entityManager->createQuery('SELECT DISTINCT e.event_movie_genre FROM App\Entity\Event e');
        return $dql->getResult();
    }

    public function findEventsByGenre($selected_genre): array {
        $entityManager = $this->getEntityManager();
        $dql = $entityManager->createQuery('SELECT e FROM App\Entity\Event e WHERE e.event_movie_genre = :selected_genre AND e.event_is_validated = true')->setParameter('selected_genre', $selected_genre);
        return $dql->getResult();
    }

    public function findOneEventByGenre($selected_genre): Event {
        $entityManager = $this->getEntityManager();
        $dql = $entityManager->createQuery('SELECT e FROM App\Entity\Event e WHERE e.event_movie_genre = :selected_genre')->setParameter('selected_genre', $selected_genre)->setMaxResults(1);
        return $dql->getOneorNullResult();
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
