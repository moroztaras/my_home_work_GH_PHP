<?php

namespace Blog\BlogBundle\Lib\Searcher;
use Blog\BlogBundle\Entity\PostRepository;

class Searcher
{
    /**
     * @var PostRepository
     */
/*    private $repository;
    public function __construct(PostRepository $repository)
    {
        $this->repository=$repository;//засетили змінну
    }
*/
    public function search ($string)
    {
        //return $this->repository->getIdArrayByName($string);
        return array(68);
    }
}