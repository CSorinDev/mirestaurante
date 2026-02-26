<?php
namespace App\DataFixtures;

use App\Entity\Carta;
use App\Entity\Categoria;
use App\Entity\Reserva;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // 1. Crear el usuario Administrador
        $user = new User();
        $user->setEmail('csorin.dev@gmail.com');
        $user->setName('Sorin');
        $user->setPhone('642980754');
        $user->setIsVerified(true);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->hasher->hashPassword($user, 'parola'));
        
        // Crear un usuario con role_user
        $user2 = new User();
        $user2->setEmail('ejemplo@gmail.com');
        $user2->setName('Ejemplo');
        $user2->setPhone('123456789');
        $user2->setIsVerified(true);
        $user2->setRoles(['ROLE_USER']);
        $user2->setPassword($this->hasher->hashPassword($user2, 'contraseña'));

        $manager->persist($user2);
        $manager->persist($user);

        // Crear reservas de ejemplo
        $reserva1 = new Reserva();
        $reserva1->setUser($user);
        $reserva1->setFecha(new \DateTime('2026-03-04'));
        $reserva1->setHora(new \DateTime('19:00'));
        $reserva1->setComensales(4);

        $reserva2 = new Reserva();
        $reserva2->setUser($user2);
        $reserva2->setFecha(new \DateTime('2026-02-04'));
        $reserva2->setHora(new \DateTime('19:00'));
        $reserva2->setComensales(2);

        $manager->persist($reserva1);
        $manager->persist($reserva2);

        // 2. Crear Categorías y guardarlas en un array para usarlas luego
        $categoriasData = [
            ['nombre' => 'Entrantes', 'orden' => 1],
            ['nombre' => 'Pizzas', 'orden' => 2],
            ['nombre' => 'Bebidas', 'orden' => 3],
        ];

        $objetosCategoria = [];

        foreach ($categoriasData as $data) {
            $categoria = new Categoria();
            $categoria->setNombre($data['nombre']);
            $categoria->setOrden($data['orden']);

            $manager->persist($categoria);
            $objetosCategoria[$data['nombre']] = $categoria; // Guardamos el objeto
        }

        // 3. Crear productos (Carta) relacionados con las categorías
        $productosData = [
            [
                'nombre'    => 'Pan de Ajo',
                'precio'    => 4.50,
                'categoria' => 'Entrantes',
                'desc'      => 'Pan tostado con ajo y perejil.',
                'img'       => 'pan-de-ajo.jpg',
            ],
            [
                'nombre'    => 'Pizza Margarita',
                'precio'    => 10.00,
                'categoria' => 'Pizzas',
                'desc'      => 'Tomate, mozzarella y albahaca fresca.',
                'img'       => 'pizza-margerita.jpg',
            ],
            [
                'nombre'    => 'Pizza Carbonara',
                'precio'    => 12.50,
                'categoria' => 'Pizzas',
                'desc'      => 'Nata, bacon, cebolla y huevo.',
                'img'       => 'pizza-carbonara.webp',
            ],
            [
                'nombre'    => 'Coca Cola',
                'precio'    => 2.50,
                'categoria' => 'Bebidas',
                'desc'      => 'Lata 33cl.',
                'img'       => 'coca-cola.jpg',
            ],
        ];

        foreach ($productosData as $p) {
            $carta = new Carta();
            $carta->setNombre($p['nombre']);
            $carta->setPrecio($p['precio']);
            $carta->setDescripcion($p['desc']);
            $carta->setImagen($p['img']);

            // Asignamos el objeto Categoría que guardamos antes
            $carta->setCategoria($objetosCategoria[$p['categoria']]);

            $manager->persist($carta);
        }

        // 4. Guardar todo en la base de datos
        $manager->flush();
    }
}
