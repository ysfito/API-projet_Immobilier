<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sension\Bundle\FrameworkExtraBundle\Configuration\Method;


use FOS\RestBundle\Controller\Annotations as REST;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Bien;
use App\Entity\TypeBien;
use App\Entity\Localite;
use App\Entity\Client;
use App\Entity\Reservation;





class APIController extends Controller
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/APIController.php',
        ]);
    }


    /**
     *   Lists All Biens
     *
     * @REST\Get("/api/showCatalogue", name="Catalogue")
     *
     */

     public function showCatalogue()
     {
         $em= $this->getDoctrine()->getManager();
       $biens= $em->getRepository(Bien::class)->findAll();

       foreach($biens as $key=>$value){
          foreach($value->getImages() as $images){
              $images->setImages(base64_encode(stream_get_contents($images->getImages())));
          }
      }

        $data= $this->get('jms_serializer')->serialize($biens, 'json');


         if($data === null){

            $response= array(
                'success'=>false,
                'message'=>'Il n\'existe aucun bien',
                'error'=> 'données inexistants',
                'data'=>null
            );

            return $this->json($response, Response::HTTP_NOT_CONTENT);
        }

        else
        {
            $response= array(
                'success'=>true,
                'message'=>'La liste des biens',
                'error'=>null,
                'data'=> json_decode($data),
            );

            return $this->json($response, Response::HTTP_OK);

        }
     }



     /**
      *   Lists All TypeBiens
      *
      * @REST\Get("/api/showTypeBien", name="TypeBien")
      *
      */
      public function ShowTypeBien()
      {
          $em= $this->getDoctrine()->getManager();
        $TypeBien= $em->getRepository(TypeBien::class)->findAll();



        $data= $this->get('jms_serializer')->serialize($TypeBien, 'json');



         if($data === null){

            $response= array(
                'success'=>false,
                'message'=>'Il y a aucun Type déclaré',
                'error'=> 'données inexistants',
                'data'=>null
            );

            return $this->json($response, Response::HTTP_NOT_CONTENT);
        }

        else
        {
            $response= array(
                'success'=>true,
                'message'=>'La liste des biens',
                'error'=>null,
                'data'=>json_decode($data)
            );

            return $this->json($response, Response::HTTP_OK);

        }
      }

      /**
       *   Lists All Localites
       *
       * @REST\Get("/api/showLocalite", name="Localite")
       *
       */
       public function ShowLocalite()
       {

                   $em= $this->getDoctrine()->getManager();
                 $Localite= $em->getRepository(Localite::class)->findAll();

         $data= $this->get('jms_serializer')->serialize($Localite, 'json');


          if($data === null){

             $response= array(
                 'success'=>false,
                 'message'=>'Il y a aucune Localite enregistré',
                 'error'=> 'données inexistants',
                 'data'=>null
             );

             return $this->json($response, Response::HTTP_NOT_CONTENT);
         }

         else
         {
             $response= array(
                 'success'=>true,
                 'message'=>'La liste des biens',
                 'error'=>null,
                 'data'=>json_decode($data)
             );

             return $this->json($response, Response::HTTP_OK);

         }
       }


       /**
        *   Recherche un Bien selon le prix , la localité et/ou  le type
        *
        * @REST\Post ("/api/RechercheByCritere", name="Recherche")
        */
        public function Recherche(Request $request)
        {

                $prixLocation= $request->get('prix_location');
                $Localite= $request->get('localite');
                //$description= $request->get('description');
                $type= $request->get('TypeBien');

                    $em= $this->getDoctrine()->getManager();
                if( !empty($prixLocation) and !empty($Localite) /*and !empty($description)*/ and !empty($type))
                {

                  $biens= $em->getRepository(Bien::class)->findBy(['prixLocation'=>$prixLocation, 'localite'=> $Localite, /*'description'=> $description,*/ 'typebien'=>$type]);
                }

                if( empty($prixLocation) and !empty($Localite) /*and !empty($description)*/ and !empty($type))
                {
                  $biens= $em->getRepository(Bien::class)->findBy(['localite'=> $Localite, /*'description'=> $description,*/ 'typebien'=>$type]);
                }

                if( empty($prixLocation) and empty($Localite) /*and !empty($description)*/ and !empty($type))
                {
                  $biens= $em->getRepository(Bien::class)->findBy([/*'description'=> $description,*/ 'typebien'=>$type]);
                }

                if( empty($prixLocation) and empty($Localite) /*and empty($description)*/ and !empty($type))
                {
                  $biens= $em->getRepository(Bien::class)->findBy(['typebien'=>$type]);
                }

                if( empty($prixLocation) and empty($Localite) /*and empty($description) */ and empty($type))
                {
                  $biens = null;
                }


                $data= $this->get('jms_serializer')->serialize($biens, 'json');


                          if($data === null){

                             $response= array(
                                 'success'=>false,
                                 'message'=>'Il y a aucune Informations relative à votre recherche',
                                 'error'=> 'données inexistantes',
                                 'data'=>null
                             );

                             return $this->json($response, Response::HTTP_NO_CONTENT);
                         }

                         else
                         {
                             $response= array(
                                 'success'=>true,
                                 'message'=>'Informations relative à votre recherche',
                                 'error'=>null,
                                 'data'=>json_decode($data)
                             );

                             return $this->json($response, Response::HTTP_OK);

                         }

        }


        /**
         *   Recherche un Bien par id
         *
         * @REST\Get("/api/RechercheById/{id}", name="Recherche")
         *
         */
         public function RechercheById($id)
         {
             $em= $this->getDoctrine()->getManager();


             $biens= $em->getRepository(Bien::class)->findBy(['id'=>$id]);

             foreach($biens as $key=>$value){
                foreach($value->getImages() as $images){
                    $images->setImages(base64_encode(stream_get_contents($images->getImages())));
                }
            }

            $data= $this->get('jms_serializer')->serialize($biens, 'json');

              if($data === null){

                 $response= array(
                     'success'=>false,
                     'message'=>'Il n\'existe aucun bien',
                     'error'=> 'données inexistants',
                     'data'=>null
                 );

                 return $this->json($response, Response::HTTP_NOT_CONTENT);
             }

             else
             {
                 $response= array(
                     'success'=>true,
                     'message'=>'La liste des biens',
                     'error'=>null,
                     'data'=>json_decode($data)
                 );

                 return $this->json($response, Response::HTTP_OK);

             }

         }



         /**
          *   Ajouter une reservation via une Inscription
          *
          * @Rest\Post("/api/Reserver/Inscription/{id}", name="ReserverBienByInscription")
          *
          */
          public function ReserverBienByInscription(Request $request)
          {

                $data=$request->getContent();
                $objclient= $this->get('jms_serializer')->deserialize($data, 'App\Entity\Client', 'json');


                $id=$request->get('id');
                $numpiece=$request->get('num_piece');
            //ajout client
            /*var_dump($objclient);
            die();*/

            $em=$this->getDoctrine()->getManager();
/*$num=$objclient->getTel();
var_dump($num);
die();*/
               $client= new Client();

               $client->setNumPiece($numpiece);
               $client->setNomComplet($objclient->getNomComplet());
               $client->setTel($objclient->getTel());
               $client->setAdresse($objclient->getAdresse());
               $client->setEmail($objclient->getEmail());
               $client->setPassword($objclient->getPassword());
               $em->persist($client);
               $em->flush();

               $bien= $em->getRepository(Bien::class)->findBy(['id'=>$id]);
               //enregistrement reservation
                $reservation= new Reservation();
                $reservation->setDateReservation(new \DateTime('now') );
                $reservation->setEtat(false);
                $reservation->setBien($bien[0]);
                $reservation->setClient($client);

                $em->persist($reservation);
                $em->flush();


         return new Response ('success');

          }


          /**
           *   Ajouter une reservation une connexion
           *
           * @REST\POST("/api/Reserver/Connexion/{id}", name="ReserverBienByConnexion")
           *
           */

           public function ReserverBienByConnexion(Request $request, $id)
           {

                $email= $request->get('email');
                $password= $request->get('password');

                $id= $request->get('id');

              /* $email=$request->get('email');
               $password=$request->get('password');*/

                        //authentification
                     $client= new Client();

                $client=$this->getDoctrine()->getManager()
                    ->getRepository(Client::class)
                    ->findBy(array('email'=>$email, 'password'=>$password));
/*var_dump($client);
die();*/

                if($client){
                    //Reservation
                    $em=$this->getDoctrine()->getManager();

                        $reservation= new Reservation();

                         $bien = $this->getDoctrine()
                              ->getManager()
                              ->getRepository(Bien::class)
                              ->findBy( array('id'=>$id) );

                    $reservation->setDateReservation(new \DateTime('now'));
                    $reservation->setEtat(false);
                    $reservation->setBien($bien[0]);
                    $reservation->setClient($client[0]);


                    $em->persist($reservation);

                    $em->flush();

                    return new Response ('success');

                }

                else {

                    $response= array(
                        'success'=>false,
                        'message'=>'Il n\'existe aucun client correspondant a ces parametre',
                        'error'=> 'données inexistants',
                        'data'=>null
                    );

                    return $this->json($response, Response::HTTP_NOT_CONTENT);
                }

                   }


}
