<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePetRequest;
use App\Services\PetService;
use Illuminate\Http\RedirectResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class PetUpdateController extends Controller
{
    public function __invoke(
        UpdatePetRequest $request,
        PetService $petService,
        LoggerInterface $logger
    ): RedirectResponse
    {
        try {
            $petService->updatePet($request->validated());

            return $this->responseFactory->redirectToRoute('pet.form')
                ->with('success', __('Pet updated successfully!'));
        } catch (Exception $e) {
            $logger->error('Error updating pet: ' . $e->getMessage(), [
                'request_data' => $request->validated(),
                'exception' => $e
            ]);

            return $this->responseFactory->redirectToRoute('pet.form')
                ->with('error', __('An unexpected error occurred. Please contact support.'));
        }
    }
}
