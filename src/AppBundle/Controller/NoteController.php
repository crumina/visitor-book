<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use AppBundle\Entity\User;
use AppBundle\Entity\Note;

/**
 * Class NoteController
 * @package AppBundle\Controller
 */
class NoteController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createFormBuilder(null, ['csrf_protection' => false])
            ->add('email', EmailType::class, ['constraints' => [new NotBlank(), new Email()]])
            ->add('body', TextareaType::class, ['constraints' => [new NotBlank(), new Length(['min' => 3])]])
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByEmail($data['email']);

            if(!$user) {
                $user = new User();
                $user->setEmail($data['email']);
                $em->persist($user);
                $em->flush();
            }

            $note = new Note();
            $note->setAuthor($user);
            $note->setBody($data['body']);
            $em->persist($note);
            $em->flush();

            return $this->redirect($this->generateUrl('app_home'));
        }

        return $this->render('AppBundle::index.html.twig', [
            'form' => $form->createView(),
            'notes' => $em->getRepository('AppBundle:Note')->findNewestNotes(),
        ]);
    }
}
