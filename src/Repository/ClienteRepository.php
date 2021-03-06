<?php

namespace App\Repository;

use App\Entity\Cliente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Cliente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cliente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cliente[]    findAll()
 * @method Cliente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClienteRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $passwordEncoder;
    
    public function __construct(ManagerRegistry $registry ,UserPasswordEncoderInterface $passwordEncoder = null)
    {
        parent::__construct($registry, Cliente::class);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     * Código generado por symfony, sirve para actualizar la contraseña. No se usa
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Cliente) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @param UserInterface $cliente
     * @param array $datos
     * @throws ORMException
     * Actualizar el cliente a partir de los datos que recibimos
     */
    public function update(UserInterface $cliente, array $datos): void
    {
        if (!$cliente instanceof Cliente) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($cliente)));
        }
        
        //Actualizamos la contraseña si nos introduce una nueva. La encriptamos ante de actualizar.
        if($datos['password']!=''){
            $cliente->setPassword($this->passwordEncoder->encodePassword($cliente, $datos['password']));
        }
        
        $cliente->setNombre($datos['nombre']);
        $cliente->setApellidos($datos['apellidos']);
        $cliente->setEmail($datos['email']);
        $cliente->setTelefono($datos['telefono']);
        $cliente->setDni($datos['dni']);
        $cliente->setDireccion($datos['direccion']);
        $cliente->setCodigoPostal($datos['codigo']);
        $this->_em->persist($cliente);
        try {
            $this->_em->flush();
        } catch (OptimisticLockException $e) {
            die($e);
        } catch (ORMException $e) {
            die($e);
        }
    }

    /**
     * @return array
     * Obtenemos los clientes en una array asociativo de la forma nombre => id para poder mostrarla en el select del panel admin.
     */
    public function getChoices(): array
    {
        $lista = $this->createQueryBuilder('c', 'c.nombre')
            ->getQuery()->getArrayResult();

        foreach ($lista as $key => $item) {
            $lista[$key] = $item['id'];
        }

        return $lista;
    }
    
}
