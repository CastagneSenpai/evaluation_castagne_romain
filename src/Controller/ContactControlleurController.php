<?php

namespace App\Controller;

use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;
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

        $repository = $this->getDoctrine()->getRepository($contact::class);
        contacts= $repository->findAll();


        $form = $this->createFormBuilder($contact)
            ->add('name', TextType::class)
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
            'form' => $form->createView(),'contact'=>$contact
        ));



    }
}
