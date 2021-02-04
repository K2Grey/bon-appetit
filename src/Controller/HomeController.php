<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param RecipeRepository $recipeRepository
     * @return Response
     */
    public function index(RecipeRepository $recipeRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'recipes' => $recipeRepository->lastRecipesAdded(),
        ]);
    }
}
