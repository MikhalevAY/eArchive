<?php

namespace App\Observers;

use App\Models\Document;
use App\Models\Log;
use App\Services\LogService;

class DocumentObserver
{
    private array $data = [
        'model' => 'App\\\Document',
        'text' => 'Документы',
    ];

    public function __construct(public LogService $logService)
    {
    }

    /**
     * Handle the Document "created" event.
     *
     * @param \App\Models\Document $document
     * @return void
     */
    public function created(Document $document)
    {
        $userId = $document->authorId();
        $this->logService->create(
            array_merge($this->data, [
                'user_id' => $userId,
                'model_id' => $document->id,
                'action' => Log::ACTION_CREATE,
            ])
        );
    }

    /**
     * Handle the Document "updated" event.
     *
     * @param \App\Models\Document $document
     * @return void
     */
    public function updated(Document $document)
    {
        $this->logService->create(
            array_merge($this->data, [
                'model_id' => $document->id,
                'action' => Log::ACTION_UPDATE,
            ])
        );
    }

    /**
     * Handle the Document "deleted" event.
     *
     * @param \App\Models\Document $document
     * @return void
     */
    public function deleted(Document $document)
    {
        $this->logService->create(
            array_merge($this->data, [
                'model_id' => $document->id,
                'action' => Log::ACTION_DELETE,
            ])
        );
    }

    /**
     * Handle the Document "restored" event.
     *
     * @param \App\Models\Document $document
     * @return void
     */
    public function restored(Document $document)
    {
        //
    }

    /**
     * Handle the Document "force deleted" event.
     *
     * @param \App\Models\Document $document
     * @return void
     */
    public function forceDeleted(Document $document)
    {
        //
    }
}
