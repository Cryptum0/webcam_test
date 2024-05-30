<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Vich\UploaderBundle\FileAbstraction\ReplacingFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebcamController extends AbstractController
{
    #[Route('/', name: 'app_webcam')]
    public function index(EntityManagerInterface $entityManagerInterface): Response
    {

        if (isset($_FILES['webcam']['tmp_name'])) {

            $tmpName = $_FILES['webcam']['tmp_name'];
        
            $imageName = 'img/temp/'.date('Y.m.d') . ' - '.date('h.i.sa').' .jpeg';

        
            move_uploaded_file($tmpName, $imageName);
        
            $product = new Personne();
            $product->setimageFile( new ReplacingFile($imageName) );
            // ...
    
            $entityManagerInterface->persist($product);
            $entityManagerInterface->flush();
        
        }

        return $this->render('webcam/index.html.twig', [
            'controller_name' => 'WebcamController',
        ]);
    }
}
