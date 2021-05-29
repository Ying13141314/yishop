<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CarritoService
{
    private SessionInterface $session;
    
    private const KEY = 'carrito';

    /**
     * CarritoService constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->session->start();
    }

    public function addProducto(int $id, int $cantidad, ?string $talla = null): void
    {
        $producto[$id] = [
            $talla => $cantidad
        ];

        $this->session->start();
        
        $this->session->set(self::KEY, 'hola');
    }
    
    public function getProductos()
    {
        return $this->session->get(self::KEY);
    }
}