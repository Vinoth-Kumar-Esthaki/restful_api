<?php 
namespace AppBundle\Controller;

use AppBundle\Entity\Movie;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
    public function postMovieAction(Movie $movie, ConstraintViolationListInterface $validationErrors){
        
        if(count($validationErrors) > 0){
            throw new HttpException(400,"The data is invalid or incomplete");
        }
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