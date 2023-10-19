<?php

namespace App\Service;

use App\Entity\Tag;
use App\Exception\GraphQL\Tag\UpdateTagException;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;

class MutationService
{
    private EntityManagerInterface $em;
    private TagRepository $tagRepository;

    public function __construct(EntityManagerInterface $manager, TagRepository $tagRepository) {
        $this->em = $manager;
        $this->tagRepository = $tagRepository;
    }

    public function updateTag(array $tagDetails): Tag
    {
        $id = $tagDetails['id'] ?? null;
        $tag = $id ? $this->tagRepository->find($id) : null;

        if (is_null($tag)) {
            $tag = (new Tag())
                ->setName($tagDetails['name'])
                ->setColor($tagDetails['color'])
                ->setScore($tagDetails['score'])
                ->setType($tagDetails['type'] ?? null)
                ->setUpdatedAt(new \DateTime())
            ;

            $this->em->persist($tag);
        } else {
            $name = $tagDetails['name'];
            $type = $tagDetails['type'];

            if ($tag->getName() !== $name || $tag->getType() !== $type) {
                throw new UpdateTagException;
            }

            $tag
                ->setColor($tagDetails['color'])
                ->setUpdatedAt(new \DateTime())
            ;

            $this->em->persist($tag);
        }

        $this->em->flush();

        return $tag;
    }
}
