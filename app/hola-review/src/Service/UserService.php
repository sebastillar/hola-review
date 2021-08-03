<?php

namespace App\Service;

use App\Entity\User as User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserService
 * @package App\Service
 */
class UserService
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $encoder){
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $encoder;
    }


    /**
     * @param string $username
     * @return User
     * @throws EntityNotFoundException
     */
    public function getUser(string $username): User
    {
        $user = $this->userRepository->findOneByUsername($username);
        if (!$user) {
            throw new EntityNotFoundException('User with username '.$username.' does not exist!');
        }
        return $user;
    }

    /**
     * @return array|null
     */
    public function getAllUsers(): ?array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param string $name
     * @param string $username
     * @param string $password
     * @param string $role
     * @return User
     */
    public function addUser( array $user_arr ) : string
    {
        if ( $this->hasEmptyFields( $user_arr ) ) {
            throw new EntityNotFoundException('All fields are required.');
        }

        if ($this->getUser($user_arr["username"])) {
            throw new EntityNotFoundException('User with username '.$user_arr["username"].' already exists!');
        }

        $user = new User($user_arr["name"], $user_arr["username"], $user_arr["role"]);
        $password_encoded = $this->encodePassword($user,$user_arr["password"]);
        $user->setPassword($password_encoded);
        $this->userRepository->save($user);
    }

    /**
     * @param array $user_arr
     * @return User
     * @throws EntityNotFoundException
     */
    public function updateUser($user_arr)
    {
        $user = $this->getUser($user_arr["username"]);
        if (!$user) {
            throw new EntityNotFoundException('User with username '.$user_arr["username"].' does not exist!');
        }

        foreach($user_arr as $key => $value){
            if($key == "password"){
                $password_encoded = $this->encodePassword($user,$value);
                $user->setPassword($password_encoded);
            }
            else{
                $this->{'set'.ucwords($key)}($value);
            }
        }

        $this->userRepository->save($user);
    }

    /**
     * @param string $username
     * @throws EntityNotFoundException
     */
    public function deleteUser(string $username)
    {
        $user = $this->getUser($username);
        if (!$user) {
            throw new EntityNotFoundException('User with name '.$username.' does not exist!');
        }
        $this->userRepository->delete($user);
    }

    /**
     * @param array $user_arr
     * @return bool
     */
    public function hasEmptyFields(array $user_arr) : bool {
        $retorno = true;
        $required_keys = array("role","name","username","password");

        if (count(array_intersect_key(array_flip($required_keys), $user_arr)) === count($required_keys)) {
            $retorno = false;
        }

        return $retorno;
    }

    /**
     * @param string $password
     * @param User $user
     * @return string $password_encoded
     */
    public function encodePassword(string $password, User $user) : string {
        $password_encoded = $this->passwordEncoder->encodePassword($user,$password);
        return $password_encoded;
    }
}