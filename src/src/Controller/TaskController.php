<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class TaskController extends AbstractController
{
    #[Route(name: 'app_task_index', methods: ['GET'])]
    public function index(Request $request, TaskRepository $taskRepository): Response
    {
//        $show = $request->query->get('show');
//
//        if ($show) {
//            if ($show === 'completed') {
//                return $this->render('task/index.html.twig', [
//                    'tasks' => $taskRepository->findBy(['isCompleted' => true]),
//                ]);
//            }
//
//            if ($show === 'uncompleted') {
//                return $this->render('task/index.html.twig', [
//                    'tasks' => $taskRepository->findBy(['isCompleted' => false]),
//                ]);
//            }
//        }

        return $this->render('task/index.html.twig', [
            'amount' => $taskRepository->count(),
            'unstartedTasks' => $taskRepository->findAll(),
            'inProgressTasks' => $taskRepository->findAll(),
            'completedTasks' => $taskRepository->findAll(),
        ]);
    }

    #[Route('/task/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/task/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/task/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // remove all
            $cachedUsers = $task->getUsers();
            foreach ($cachedUsers as $user) {
                $user->removeTask($task);
                $task->removeUser($user);
            }

            // add new
            foreach ($task->getUsers() as $user) {
                $user->addTask($task);
                $task->addUser($user);
            }

            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }
//
//    #[Route('/task/{id}/complete', name: 'app_task_complete', methods: ['POST'])]
//    public function complete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
//    {
//        $task->setIsCompleted(true);
//        $entityManager->flush();
//
//        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
//    }
//
//    #[Route('/task/{id}/uncomplete', name: 'app_task_uncomplete', methods: ['POST'])]
//    public function uncomplete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
//    {
//        $task->setIsCompleted(false);
//        $entityManager->flush();
//
//        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
//    }

    #[Route('/task/{id}', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
