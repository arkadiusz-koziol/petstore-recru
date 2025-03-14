<?php

namespace App\Http\Controllers;

use App\Services\PetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

class PetShowController extends Controller
{
    public function __invoke(
        Request $request,
        PetService $petService,
        LoggerInterface $logger,
        int $petId = null,
    ): RedirectResponse|Response
    {
        $petId = $petId ?? $request->input('petId');

        if (!$petId) {
            return $this->responseFactory->view('pets.show');
        }

        try {
            $pet = $petService->findPetById($petId);

            return $this->responseFactory->view('pets.show', compact('pet'));
        } catch (Exception $e) {
            $logger->error('Error fetching pet data: ' . $e->getMessage(), [
                'petId' => $petId,
                'exception' => $e
            ]);

            return $this->responseFactory->redirectToRoute('pet.show')
                ->with('error', __('Failed to load pet details. Please try again.'));
        }
    }
}
