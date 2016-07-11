<?php

namespace Sorin\Bundle\RestaurantBundle\Controller\Api;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Request\ParamReader;
use Sorin\Bundle\RestaurantBundle\Controller\MyController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Sorin\Bundle\RestaurantBundle\Entity\User;
use Sorin\Bundle\RestaurantBundle\Entity\CustomerUser;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

class CustomerRestController extends MyController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function putCustomerAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $email = $request->get('email');
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $password = $request->get('password');

        /** @var EntityRepository $userRepository */
        $userRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\User');
        /** @var array $users */
        $users = $userRepository->findBy(
            array(
                'email'     =>  $email,
                'userType'  =>  User::USER_TYPE_CUSTOMER,
            )
        );

        if(count($users))
        {
            return static::throwError(
                sprintf(
                    "User with email %s already exists!",
                    $email
                )
            );
        }

        $factory = $this->get('security.encoder_factory');
        $user = new User();
        /** @var BCryptPasswordEncoder $encoder */
        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword($password, $user->getSalt());

        $user->setEmail($email)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setPassword($password)
            ->setCreatedAt(new \DateTime())
            ->setUserType(User::USER_TYPE_CUSTOMER);
        $em->persist($user);
        $em->flush();

        return static::returnSerializedResponse($user);
    }

    /**
     * @return JsonResponse
     */
    public function patchCustomerEditAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user= $this->get('security.token_storage')->getToken()->getUser();

        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $password = $request->get('password');

        /** @var EntityRepository $userRepository */
        $userRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\User');
        /** @var User $requestUser */
        $requestUser = $userRepository->find($request->get('userId'));

        if(!$user || !$requestUser || $user->getId() != $requestUser->getId())
        {
            return static::throwError(
                sprintf(
                    "Invalid user: %s",
                    $request->get('userId')
                )
            );
        }

        $factory = $this->get('security.encoder_factory');
        /** @var BCryptPasswordEncoder $encoder */
        $encoder = $factory->getEncoder($requestUser);
        $password = $encoder->encodePassword($password, $user->getSalt());

        $requestUser->setFirstName($firstName);
        $requestUser->setLastName($lastName);
        $requestUser->setPassword($password);

        $em->persist($requestUser);
        $em->flush();

        return static::returnSerializedResponse($user);
    }

    /**
     * @param $request Request
     * @return JsonResponse
     */
    public function deleteCustomerRemoveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user= $this->get('security.token_storage')->getToken()->getUser();

        /** @var EntityRepository $userRepository */
        $userRepository = $em->getRepository('Sorin\Bundle\RestaurantBundle\Entity\User');
        /** @var User $requestUser */
        $requestUser = $userRepository->find($request->get('userId'));

        if(!$user || !$requestUser || $user->getId() != $requestUser->getId())
        {
            return static::throwError(
                sprintf(
                    "Invalid user: %s",
                    $request->get('userId')
                )
            );
        }

        $requestUser->setIsActive(User::USER_STATUS_INACTIVE);

        $em->persist($requestUser);
        $em->flush();

        return static::returnSerializedResponse($user);
    }
}