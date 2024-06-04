<?php

namespace App\Http\Traits;

trait HttpResponses
{
    public function modalSaveError(object $messages, string $modal = '')
    {
        $triggerHeader = json_encode([
            'save-error' => [
                'errorMessages' => $messages,
                'modal' => $modal,
            ],
        ]);

        return response(view('components.noContent', []),
            200, ['HX-Trigger' => $triggerHeader]);
    }
}
