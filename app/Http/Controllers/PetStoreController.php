<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetRequest;
use App\Services\PetService;
use Illuminate\Http\RedirectResponse;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class PetStoreController extends Controller
{
    public function __invoke(
        StorePetRequest $request,
        PetService $petService,
        LoggerInterface $logger
    ): RedirectResponse
    {
        try {
            $response = $petService->handleCreatePet($request->validated());

            if ($response['code'] === Response::HTTP_OK) {
                return $this->responseFactory->redirectToRoute('pet.form')
                    ->with('success', __('Pet added successfully!'));
            }

            return $this->responseFactory->redirectToRoute('pet.form')
                ->with('error', __('Failed to add the pet. Please try again.'));
        } catch (Exception $e) {
            $logger->error('Error adding pet: ' . $e->getMessage(), [
                'request_data' => $request->validated(),
                'exception' => $e,
            ]);

            return $this->responseFactory->redirectToRoute('pet.form')
                ->with('error', __('An unexpected error occurred. Please contact support.'));
        }
    }
}
