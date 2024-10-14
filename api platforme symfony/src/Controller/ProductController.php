<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use OpenApi\Annotations as OA;


#[Route('/api', name: '')]

class ProductController extends AbstractController
{   
       /**
     * @OA\Get(
     *     path="/products",
     *     summary="Liste des produits",
     *     @OA\Response(
     *         response=200,
     *         description="Retourne la liste des produits",
     *         @OA\JsonContent(type="array", @OA\Items(ref=@Model(type=Product::class)))
     *     )
     * )
     */
    #[Route('/products', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $products = $entityManager->getRepository(Product::class)->findAll();

        // Serialize the products with the specified group
        $jsonProducts = $serializer->serialize($products, 'json', ['groups' => ['product:read']]);

        return new JsonResponse($jsonProducts, 200, [], true); // Le dernier paramètre 'true' indique que les données sont déjà JSON
    }

    #[Route('/products/{id}', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            return $this->json(['message' => 'Product not found'], 404);
        }
        return $this->json($product);
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     summary="Créer un produit",
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref=@Model(type=Product::class))
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produit créé",
     *         @OA\JsonContent(ref=@Model(type=Product::class))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Erreur de validation"
     *     )
     * )
     */
    #[Route('/products', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setCode($data['code']);
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setImage($data['image']);
        $product->setCategory($data['category']);
        $product->setPrice($data['price']);
        $product->setQuantity($data['quantity']);
        $product->setInternalReference($data['internalReference']);
        $product->setShellId($data['shellId']);
        $product->setInventoryStatus($data['inventoryStatus']);
        $product->setRating($data['rating']);
        $product->setCreatedAt(new \DateTime()); // Set created date

        // Validation
        $errors = $validator->validate($product);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400); // Retourne les erreurs de validation
        }

        $entityManager->persist($product);
        $entityManager->flush();

        return $this->json($product, 201);
    }

    #[Route('/products/{id}', methods: ['PUT'])]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            return $this->json(['message' => 'Product not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $product->setCode($data['code'] ?? $product->getCode());
        $product->setName($data['name'] ?? $product->getName());
        $product->setDescription($data['description'] ?? $product->getDescription());
        $product->setImage($data['image'] ?? $product->getImage());
        $product->setCategory($data['category'] ?? $product->getCategory());
        $product->setPrice($data['price'] ?? $product->getPrice());
        $product->setQuantity($data['quantity'] ?? $product->getQuantity());
        $product->setInternalReference($data['internalReference'] ?? $product->getInternalReference());
        $product->setShellId($data['shellId'] ?? $product->getShellId());
        $product->setInventoryStatus($data['inventoryStatus'] ?? $product->getInventoryStatus());
        $product->setRating($data['rating'] ?? $product->getRating());
        $product->setUpdatedAt(new \DateTime()); // Update modified date

        $entityManager->flush();

        return $this->json($product);
    }

    #[Route('/products/{id}', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        if (!$product) {
            return $this->json(['message' => 'Product not found'], 404);
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->json(['message' => 'Product deleted successfully']);
    }
}
