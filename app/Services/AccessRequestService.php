<?php

namespace App\Services;

use App\Models\AccessRequest;
use App\RepositoryInterfaces\AccessRequestRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AccessRequestService
{
    public function __construct(
        public AccessRequestRepositoryInterface $repository,
        public DocumentAccessService            $documentAccessService
    )
    {
    }

    public function getPaginated(array $params): LengthAwarePaginator
    {
        return $this->repository->getPaginated($params);
    }

    public function getOrderBy(array $params): array
    {
        return $this->repository->getOrderBy($params);
    }

    public function update(array $params, AccessRequest $accessRequest): array
    {
        if (isset($params['documents'])) {
            foreach ($accessRequest->documentAccesses as $documentAccess) {
                $this->documentAccessService->update([
                    'is_allowed' => $params['documents'][$documentAccess->document_id]
                ], $documentAccess);
            }
        }

        return $this->repository->update($params, $accessRequest);
    }

    public function store(array $params): array
    {
        $data = $this->repository->store($params);

        foreach ($params['documents'] as $documentId) {
            $this->documentAccessService->store([
                'user_id' => auth()->id(),
                'access_request_id' => $data['accessRequest']->id,
                'document_id' => $documentId,
                'view' => isset($params['view'][$documentId]),
                'edit' => isset($params['edit'][$documentId]),
                'download' => isset($params['download'][$documentId]),
                'delete' => isset($params['delete'][$documentId]),
                'is_allowed' => null
            ]);
        }

        return $data;
    }

    public function getDocumentIds(AccessRequest $accessRequest, array $params): array
    {
        $documents = [];
        foreach ($accessRequest->documentAccesses()->pluck('document_id')->toArray() as $document) {
            $documents[$document] = $params['document-' . $document] ?? 0;
        }

        return $documents;
    }
}
