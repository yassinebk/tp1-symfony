<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class TodoController extends AbstractController
{
    private $initial_todos;
    public function __construct()
    {

        $this->initial_todos = array(
            'achat' => 'acheter clé usb',
            'cours' => 'Finaliser mon cours',
            'correction' => 'corriger mes examens'
        );
    }

    #[Route("/", "index")]

    public function indexAction(SessionInterface $session)
    {
        $todos = $session->get("todos", null);
        if ($todos === null) {
            $session->set("todos", $this->initial_todos);
        }
        return $this->render("listeToDo.html.twig", array('todos' => $todos));
    }

    #[Route('/add{todo?}', "add-todo")]
    public function addToDo(SessionInterface $session, Request $request)
    {
        $todo = $request->query->get("todo");
        $todos = $session->get("todos", null);
        dump($todos);


        if ($todo) {
            dump($todo);
            if ($todos === null) {

                $this->addFlash('error', "Il y a eu un erreur. S'il vous plait Rafraichisser la page.");
            } else {

                $this->addFlash('success', "Votre todo a ete ajoute avec succes.");
                $todos[] = $todo;
                $session->set('todos', $todos);
            }
        }
        return $this->render("listeToDo.html.twig", array('todos' => $todos));
    }

    #[Route('/delete/{todo}', "delete-todo")]
    public function deleteToDo(SessionInterface $session, $todo)
    {
        $todos = $session->get("todos", null);
        if ($todos === null) {

            $session->getFlashBag()->add("success", "Votre todo a ete supprime avec succes.");
            // $this->addFlash('error', "Il y a eu un erreur. S'il vous plait Rafraichisser la page.");
        } else {
            // $session->getFlashBag()->add("success", "Votre todo a ete supprime avec succes.");
            $this->addFlash('success', "Votre todo a ete supprime avec succes.");
            $index = array_search($todo, $todos, true);
            unset($todos[$index]);
            $todos2 = array_values($todos);
            $session->set("todos", $todos2);
        }
        return $this->render("listeToDo.html.twig", array('todos' => $todos));
    }

    #[Route("/reset", "reset-todo")]
    public function resetTodo(SessionInterface $session)
    {
        $todos = $session->get("todos", null);
        $session->set("todos", $this->initial_todos);
        return $this->render("listeToDo.html.twig", array('todos' => $todos));
    }
}
