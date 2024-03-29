<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class TaskController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/tasks", name="task_list")
     */
    public function Tasklist(TaskRepository $taskrepository): Response
    {
        $task =$taskrepository->findBy(['isDone'=>0]);

        return $this->render('task/listtask.html.twig', [
            'tasks' => $task,
        ]);
    }

    /**
     * @Route("/tasks-done", name="task_list_done")
     */
    public function listTaskDone(TaskRepository $taskrepository)
    {
        $task =$taskrepository->findBy(['isDone'=>1]);
        return $this->render('task/listtask.html.twig', ['tasks' => $task]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function makeTask(Request $request): Response
    {
        
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task->setCreatedAt(new \DateTime());
            $task->setUser($this->getUser());
            $this->em->persist($task);
            $this->em->flush();
            $this->addFlash('success', 'Votre tache a bien été envoyé');
        }
        return $this->render('task/maketask.html.twig', ['form' => $form->createView()]);
    }

      /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function updateTask(Request $request,Task $task): Response
    {
        $form = $this->createForm(TaskType::class,$task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                        
        


            
            $this->em->persist($task);
            $this->em->flush();
            $this->addFlash('msg', 'Votre tache a bien été modifié');


            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/update_task.html.twig',['form'=>$form->createView(),'task'=>$task]);    
    }

    


    /**
     *  @Route("/tasks/{id}/delete", name="task_delete")
     *  @IsGranted("ROLE_ADMIN")
     */
    public function deleteTask(Task $task): Response
    {
       

            $this->em->remove($task);
            $this->em->flush();
    
            $this->addFlash('success','la tache a bien été supprimé !');
            return $this->redirectToRoute('task_list');
                

    }

     /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     * 
     * 
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        
        $this->em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }



}