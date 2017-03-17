<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\User;

/**
 * Class SecurityController
 * @package AppBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('AppBundle::login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registrationAction(Request $request)
    {
        $form = $this->createFormBuilder(null, ['csrf_protection' => false])
            ->add('email', EmailType::class, ['constraints' => [new NotBlank(), new Email()]])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ))
            ->add('register', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByEmail($data['email']);

            if($user) {
                if($user->getPassword()){
                    /**
                     * TODO Set flash message "User already exists"
                     */
                    return $this->redirectToRoute('app_login');
                }

            }else{
                $user = new User();
                $user->setEmail($data['email']);
            }

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $data['password']);
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            /**
             * TODO Set flash message "User already exists"
             */
            return $this->redirectToRoute('app_login');
        }

        return $this->render('AppBundle::registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
