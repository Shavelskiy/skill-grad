<?php

namespace App\Controller\Api;

use App\Cache\Keys;
use App\Cache\MemcachedClient;
use App\Dto\UpdateUserData;
use App\Entity\Category;
use App\Entity\Location;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\LocationRepository;
use App\Service\UpdateUserInterface;
use Exception;
use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

/**
 * @Route("/api/profile/settings")
 */
class ProfileSettingsController extends AbstractController
{
    protected CategoryRepository $categoryRepository;
    protected LocationRepository $locationRepository;
    protected UpdateUserInterface $updateUserService;

    public function __construct(
        CategoryRepository $categoryRepository,
        LocationRepository $locationRepository,
        UpdateUserInterface $updateUserService
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->locationRepository = $locationRepository;
        $this->updateUserService = $updateUserService;
    }

    /**
     * @Route("", methods={"GET"}, name="get.profile.settings")
     */
    public function getProfileSettings(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (in_array(User::ROLE_PROVIDER, $user->getRoles(), true)) {
            $data = $this->getProviderProfileInfo($user);
        } else {
            $data = $this->getUserProfileInfo($user);
        }

        return new JsonResponse($data);
    }

    protected function getProviderProfileInfo(User $user): array
    {
        if (($userInfo = $user->getUserInfo()) === null) {
            return [
                'full_name' => '',
                'email' => $user->getEmail(),
                'phone' => '',
            ];
        }

        return [
            'full_name' => $userInfo->getFullName(),
            'email' => $user->getEmail(),
            'phone' => $userInfo->getPhone(),
        ];
    }

    protected function getUserProfileInfo(User $user): array
    {
        $categories = [];

        /** @var Category $category */
        foreach ($this->categoryRepository->findRootCategories() as $category) {
            $categories[] = [
                'value' => $category->getId(),
                'title' => $category->getName(),
            ];
        }

        if (($userInfo = $user->getUserInfo()) === null) {
            return [
                'full_name' => '',
                'email' => $user->getEmail(),
                'description' => '',
                'phone' => '',
                'category' => null,
                'categories' => $categories,
                'image' => null,
            ];
        }

        return [
            'full_name' => $userInfo->getFullName(),
            'email' => $user->getEmail(),
            'description' => $userInfo->getDescription(),
            'phone' => $userInfo->getPhone(),
            'category' => ($userInfo->getCategory() !== null) ? $userInfo->getCategory()->getId() : null,
            'categories' => $categories,
            'image' => $userInfo->getImage() ? $userInfo->getImage()->getPublicPath() : null,
        ];
    }

    /**
     * @Route("", methods={"POST"}, name="save.profile.settings")
     */
    public function saveProfileSettings(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $updateUserData = (new UpdateUserData())
            ->setFullName($request->get('fullName'))
            ->setEmail($request->get('email'))
            ->setPhone($request->get('phone'))
            ->setOldPassword($request->get('oldPassword'))
            ->setNewPassword($request->get('newPassword'))
            ->setConfirmNewPassword($request->get('confirmNewPassword'));

        if (!in_array(User::ROLE_PROVIDER, $user->getRoles(), true)) {
            $updateUserData
                ->setDescription($request->get('description'))
                ->setOldImage($request->get('oldImage'))
                ->setImage($request->files->get('image'));

            if ($request->get('category') !== null) {
                $updateUserData->setCategory(
                    $this->categoryRepository->find($request->get('category'))
                );
            }
        }

        try {
            $this->updateUserService->updateUser($user, $updateUserData);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse([]);
    }

    /**
     * @Route("/categories", name="api.profile.settings.categories", methods={"GET"})
     */
    public function categoriesAction(): Response
    {
        $categories = [];

        /** @var Category $rootCategory */
        foreach ($this->categoryRepository->findRootCategories() as $rootCategory) {
            $childCategories = [];

            /** @var Category $childCategory */
            foreach ($rootCategory->getChildCategories() as $childCategory) {
                $childCategories[] = [
                    'value' => $childCategory->getId(),
                    'title' => $childCategory->getName(),
                ];
            }

            $categories[] = [
                'value' => $rootCategory->getId(),
                'title' => $rootCategory->getName(),
                'child_items' => $childCategories,
            ];
        }

        return new JsonResponse(['categories' => $categories]);
    }

    /**
     * @Route("/locations", name="api.profile.settings.locations", methods={"GET"})
     */
    public function locationsAction(): Response
    {
        $result = function () {
            $locations = [];

            /** @var Location $country */
            foreach ($this->locationRepository->findAllCountries() as $country) {
                $regions = [];

                /** @var Location $region */
                foreach ($country->getChildLocations() as $region) {
                    $cities = [];

                    /** @var Location $city */
                    foreach ($region->getChildLocations() as $city) {
                        $cities[] = [
                            'value' => $city->getId(),
                            'title' => $city->getName(),
                        ];
                    }

                    $regions[] = [
                        'value' => $region->getId(),
                        'title' => $region->getName(),
                        'cities' => $cities,
                    ];
                }

                $locations[] = [
                    'value' => $country->getId(),
                    'title' => $country->getName(),
                    'regions' => $regions,
                ];
            }

            return $locations;
        };

        try {
            $cache = MemcachedClient::getCache();

            /** @var CacheItemInterface $item */
            $item = $cache->getItem(Keys::ALL_LOCATIONS);

            if (!$item->isHit()) {
                $item->set($result());
                $item->expiresAfter(360000);
                $cache->save($item);
            }

            $locations = $item->get();
        } catch (Throwable $e) {
            $locations = [];
        }

        return new JsonResponse(['locations' => $locations]);
    }
}
