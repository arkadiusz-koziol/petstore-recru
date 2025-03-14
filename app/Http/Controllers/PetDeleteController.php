<?php

namespace App\Http\Controllers;

use App\Services\PetService;
use Illuminate\Http\RedirectResponse;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class PetDeleteController extends Controller
{
    public function __invoke(
        int $petId,
        PetService $petService,
        LoggerInterface $logger
    ): RedirectResponse
    {
        try {
            $response = $petService->deletePet($petId);

            if ($response['code'] === Response::HTTP_OK) {
                return $this->responseFactory->redirectToRoute('pet.form')
                    ->with('success', __('Pet deleted successfully!'));
            }

            return $this->responseFactory->redirectToRoute('pet.form')
                ->with('error', __('Failed to delete the pet. Please try again.'));
        } catch (Exception $e) {
            $logger->error('Error deleting pet: ' . $e->getMessage(), [
                'petId' => $petId,
                'exception' => $e
            ]);

            return $this->responseFactory->redirectToRoute('pet.form')
                ->with('error', __('An unexpected error occurred. Please contact support.'));
        }
    }
}
