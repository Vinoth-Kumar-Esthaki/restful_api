<?php 
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use AppBundle\Entity\Movie;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\Annotations as Rest;

class MoviesController extends AbstractController{
    
    use ControllerTrait;
    
    /**
     * @Rest\View()
     */
    public function getMoviesAction(){
        $em = $this->getDoctrine();
        $movieRepo = $em->getRepository('AppBundle:Movie');
        $movies = $movieRepo->findAll();
        return $movies;
    }
    /**
     * @Rest\View(statusCode=201)
     * @paramConverter("movie",converter="fos_rest.request_body")
     * @Rest\NoRoute()
     */
    public function postMovieAction(Movie $movie){
        $em = $this->getDoctrine()->getManager();
        $em->persist($movie);
        $em->flush();
        return $movie;
    }
    /**
     * @Rest\View()
     */
    public function deleteMovieAction(Movie $movie){
        if(null === $movie){
            return $this->view(null,404);
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($movie);
        $em->flush();
    }
    /**
     * @Rest\View()
     */
    public function getMovieAction(Movie $movie){
        if(null === $movie){
            return $this->view(null,404);
        }
        return $movie;
    }
}
   

?>