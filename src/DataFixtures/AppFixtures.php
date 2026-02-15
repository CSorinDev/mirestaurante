<?php
namespace App\DataFixtures;

use App\Entity\Carta;
use App\Entity\Categoria;
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
        // 1. Crear el usuario Administrador (para que no te quedes fuera)
        $user = new User();
        $user->setEmail('csorin.dev@gmail.com');
        $user->setName('Sorin');
        $user->setPhone('642980754');
        $user->setIsVerified(true);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->hasher->hashPassword($user, 'parola'));
        $manager->persist($user);

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
                'nombre'    => 'Refresco de Cola',
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
