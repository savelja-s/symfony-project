<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Utils\UserUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class UserController extends AbstractController
{

    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userRepository = $entityManager->getRepository(User::class);
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @param Request                      $request
     * @param RoleHierarchyInterface       $roleHierarchy
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return Response
     * @throws \Exception
     */
    public function create(
        Request $request,
        RoleHierarchyInterface $roleHierarchy,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reachableRoles = $roleHierarchy->getReachableRoleNames($form->get('roles')->getData());
            $roles = array_unique($reachableRoles, SORT_REGULAR);
            if (empty($roles)) {
                throw new \Exception('You set no roles.');
            }
            $user->setRoles($roles);
            if (!empty($form->get('password')->getData())) {
                $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
            }
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/create.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    public function view(User $user): Response
    {
        return $this->render('user/view.html.twig', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/update.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
