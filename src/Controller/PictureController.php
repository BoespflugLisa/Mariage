<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Length;

class PictureController extends AbstractController
{
    #[Route('/pictures', name: 'app_picture')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('pictures/index.html.twig');
    }

    #[Route('/add-pictures', name: 'app_addpictures')]
    public function addPicturesRoute(): Response
    {
        return $this->render('pictures/addPictures.html.twig');
    }

    #[Route("/get_pictures/{id}", name: "get_pictures", methods: ['GET'])]
    public function getPictures(Request $request, int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $roles = $request->query->get('roles');

        if (str_contains($roles, "ROLE_SUPERADMIN") || str_contains($roles, "ROLE_ADMIN")) {
            $visiblePictures = $entityManager->getRepository(Picture::class)->findFromId($id);
        } else {
            $visiblePictures = $entityManager->getRepository(Picture::class)->findVisibleFromId($id);
        }

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getId();
            },
        ];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];
        $serializer = new Serializer($normalizers, $encoders);
        $visiblePicturesEncoded = $serializer->serialize($visiblePictures, 'json');

        return new JsonResponse($visiblePicturesEncoded, Response::HTTP_OK);
    }

    #[Route("/post_pictures", name: "post_pictures", methods: ['POST'])]
    public function postPictures(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $tagRepository = $entityManager->getRepository(Tag::class);

        foreach ($data["pictures"] as $el) {
            if ($el["tags"] !== "") {
                $tags = explode(',', $el["tags"]);
                foreach ($tags as $tagName) {
                    $tag = $tagRepository->findOneByName(trim($tagName));
                    if ($tag === null) {
                        $newTag = new Tag();
                        $newTag->setName(trim($tagName));

                        $entityManager->persist($newTag);
                        $entityManager->flush();
                    }
                }
            }
        }

        foreach ($data["pictures"] as $el) {
            $picture = new Picture();
            $picture->setImg($el["image"]);
            $picture->setPublisher($data["publisher"]);
            $picture->setVisibility(true);

            if ($el["tags"] !== "") {
                $tagsArray = explode(',', $el["tags"]);

                foreach ($tagsArray as $tagName) {
                    $tag = $tagRepository->findOneByName(trim($tagName));
                    if ($tag !== null) {
                        $picture->addTag($tag);
                    }
                }
            }
            $entityManager->persist($picture);
            $entityManager->flush();
        }
        return new JsonResponse("Success", Response::HTTP_CREATED);
    }

    #[Route("/update_pictures_visibility", name: "update_pictures_visibility", methods: ['PUT'])]
    public function updatePicturesVisibility(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        foreach ($data as $el) {
            $picture = $entityManager->getRepository(Picture::class)->findById($el["id"]);
            $picture->setVisibility($el["visibility"]);
            $entityManager->flush();
        }
        return new JsonResponse("Success", Response::HTTP_ACCEPTED);
    }

    #[Route("/update_pictures_tags", name: "update_pictures_tags", methods: ['PUT'])]
    public function updatePicturesTags(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $tagRepository = $entityManager->getRepository(Tag::class);

        foreach ($data as $el) {
            if ($el["newTags"] !== "") {
                $tags = explode(',', $el["newTags"]);

                for ($i = 0; $i < count($tags); $i++) {
                    $tags[$i] = trim($tags[$i]);
                }

                foreach ($tags as $tagName) {
                    $tag = $tagRepository->findOneByName($tagName);
                    if ($tag === null) {
                        $newTag = new Tag();
                        $newTag->setName($tagName);

                        $entityManager->persist($newTag);
                        $entityManager->flush();
                    }
                }
            }
        }

        foreach ($data as $el) {
            $picture = $entityManager->getRepository(Picture::class)->findById($el["id"]);
            $newTags = explode(',', $el["newTags"]);
            $oldTags = $picture->getTags();

            for ($i = 0; $i < count($newTags); $i++) {
                $newTags[$i] = trim($newTags[$i]);
            }

            foreach ($oldTags as $oldTag) {
                if (!in_array($oldTag->getName(), $newTags)) {
                    $picture->removeTag($oldTag);
                }
            }

            foreach ($newTags as $newTag) {
                if ($newTag !== "") {
                    $tag = $tagRepository->findOneByName($newTag);
                    if (!$picture->hasTag($tag)) {
                        $picture->addTag($tag);
                    }
                }
            }

            $entityManager->flush();
        }

        return new JsonResponse("Success", Response::HTTP_ACCEPTED);
    }

    #[Route("/delete_pictures", name: "delete_pictures", methods: ['DELETE'])]
    public function deletePictures(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        foreach ($data as $el) {
            $picture = $entityManager->getRepository(Picture::class)->findById($el["id"]);
            $entityManager->remove($picture);
            $entityManager->flush();
        }

        return new JsonResponse("Success", Response::HTTP_ACCEPTED);
    }
}
