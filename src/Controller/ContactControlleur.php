<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Contact;


class ContactControlleur extends AbstractController
{
    /**
     * @Route("/add_contact/", name="add_contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        //Déclaration d'un nouveau contact
        $contact= new Contact();

        $repository = $this->getDoctrine()->getRepository(Contact::class);
        $contacts= $repository->findAll();


        $form = $this->createFormBuilder($contact)
            ->add('nom', TextType::class)
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $contact = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('add_contact');
        }

        return $this->render('contact.html.twig', array(
            'form' => $form->createView(),'contacts'=>$contacts
        ));



    }
}
