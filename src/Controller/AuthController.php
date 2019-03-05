<?php
/**
 * AuthController.php
 *
 * AUTH Controller
 *
 * @category   Controller
 * @author     DenmaSoft
 */

namespace App\Controller;
use App\Entity\Usuario;
use Doctrine\DBAL\DBALException;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Class AuthController
 *
 * @Route("/api")
 */
class AuthController extends FOSRestController
{
    /**
     * @Rest\Post("/login_check", name="user_login_check")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Usuario fue logeado satisfactoriamente"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Usuario no pudo ser logeado."
     * )
     *
     * @SWG\Parameter(
     *     name="_username",
     *     in="body",
     *     type="string",
     *     description="Nombre de usuario",
     *     schema={
     *     }
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="body",
     *     type="string",
     *     description="Contraseña",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Usuario")
     */
    public function getLoginCheckAction() {}

    /**
     * @Rest\Post("/register", name="user_register")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Usuario fué registrado satisfactoriamente."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="El usuario no pudo ser registrado."
     * )
     *
     * @SWG\Parameter(
     *     name="_name",
     *     in="body",
     *     type="string",
     *     description="Nombre Completo del usuario",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_email",
     *     in="body",
     *     type="string",
     *     description="Correo electrónico",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_username",
     *     in="body",
     *     type="string",
     *     description="Nombre de usuario para el login",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="query",
     *     type="string",
     *     description="Contraseña"
     * )
     *
     * @SWG\Tag(name="Usuario")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder) {

        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();

        $user = [];
        $message = "";

        try {
            $code = 200;
            $error = false;

            $name     = $request->request->get('_name');
            $email    = $request->request->get('_email');
            $username = $request->request->get('_username');
            $password = $request->request->get('_password');

            $user = new Usuario();
            $user->setName($name);
            $user->setEmail($email);
            $user->setUsername($username);
            $user->setPlainPassword($password);
            $user->setPassword($encoder->encodePassword($user, $password));

            $em->persist($user);
            $em->flush();

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to register the user - Error: {$ex->getMessage()}";
        } catch (DBALException $ex) {
            $code = 500;
            $error = true;
            $message = "An error has occurred trying to register the user. Username/email is in use.";
        }

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $user : $message,
        ];

        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Get("/v1/perfil", name="user_perfil")
     *
     * @SWG\Response(
     *     response=201,
     *     description="Perfil de usuario encontrado satisfactoriamente."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Peril no encontrado o token vencido."
     * )
     *
     * @SWG\Tag(name="Usuario")
     * @return Response
     * @internal param Request $request
     * @internal param UserPasswordEncoderInterface $encoder
     */
    public function getProfile () {
        $serializer = $this->get('jms_serializer');
        $response = [
            'code' => 200,
            'error' => false,
            'data' => $this->getUser()
        ];
        return new Response($serializer->serialize($response, "json"));
    }
}