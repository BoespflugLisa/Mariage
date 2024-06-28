<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DonationPromise;
use App\Entity\Present;
use App\Entity\PresentCategory;
use App\Form\DonationPromiseFormType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class PresentController extends AbstractController
{
    // #[Route('/present', name: 'app_present')]
    // public function index(): Response
    // {
    //     return $this->render('present/present.html.twig', [
    //         'controller_name' => 'PresentController',
    //     ]);
    // }


    #[Route('/presents', name: 'app_present')]
    public function presentView(EntityManagerInterface $entityManager)
    {
        $allPresents = $entityManager->getRepository(Present::class)->findAll();
        $allCategories = $entityManager->getRepository(PresentCategory::class)->findAll();


        $categoriesByName = [];

        foreach ($allCategories as $category){
            array_push($categoriesByName, $category->getName());
        }

        $availablePresents = array();
        foreach ($allPresents as $present) {
            $present->setTotalAmount();
            $present->setProgression();

            if ($present->getTotalAmount() === $present->getPrice()) {
                $present->setComplete(true);
            } else {
                $present->setComplete(false);
            }
        }
        foreach ($allPresents as $present) {
            $parentId = $present->getParentId();

            if ($parentId) {
                $parent = $entityManager->getRepository(Present::class)->findById($parentId);
                if ($parent->isComplete()) {
                    array_push($availablePresents, $present);
                }
            } else {
                array_push($availablePresents, $present);
            }
        }

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getName();
            },
        ];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];
        $serializer = new Serializer($normalizers, $encoders);

        $allPresentsEncoded = $serializer->serialize($availablePresents, 'json');
        $categoriesByNameEncoded =  $serializer->serialize($categoriesByName, 'json');

        return $this->render('presents/presents.html.twig', [
            'availablePresents' => $allPresentsEncoded,
            'allCategories' => $categoriesByNameEncoded,
        ]);
    }

    #[Route('/presents/{id}/donation-promise-form', name: 'app_donationPromsiseForm')]
    public function donationPromiseForm(int $id, EntityManagerInterface $entityManager)
    {

        $present = $entityManager->getRepository(Present::class)->findById($id);
        $present->setTotalAmount();
        $present->setProgression();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getName();
            },
        ];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];
        $serializer = new Serializer($normalizers, $encoders);

        $presentEncoded = $serializer->serialize($present, 'json');

        return $this->render('presents/donationPromiseForm.html.twig', [
            'present' => $presentEncoded,
        ]);
    }

    #[Route('/post_donationpromise', name: 'post_donationPromsise', methods: ['POST'])]
    public function postDonationPromise(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $present = $entityManager->getRepository(Present::class)->findById($data["presentId"]);

        $dp = new DonationPromise();
        $dp->setName($data["name"]);
        $dp->setDonationAmount($data["donationAmount"]);
        $dp->setMessage($data["message"]);
        $dp->setEmail($data["email"]);
        $dp->setPresent($present);
        $dp->setView(false);

        $entityManager->persist($dp);
        $entityManager->flush();

        return new JsonResponse("Success", Response::HTTP_CREATED);
    }
}
