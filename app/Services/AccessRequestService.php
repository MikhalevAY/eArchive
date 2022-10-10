<?php

namespace App\Services;

use App\Models\AccessRequest;
use App\RepositoryInterfaces\AccessRequestRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AccessRequestService
{
    public function __construct(public AccessRequestRepositoryInterface $repository)
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
        return $this->repository->update($params, $accessRequest);
    }

    public function store(array $params): array
    {
        $data = $this->repository->store($params);

        $this->attachDocuments($params, $data['accessRequest']);

        return $data;
    }

    public function getDocumentIds(AccessRequest $accessRequest, array $params): array
    {
        $documents = [];
        foreach ($accessRequest->documents()->allRelatedIds()->toArray() as $document) {
            $documents[$document] = $params['document-' . $document] ?? 0;
        }

        return $documents;
    }

    public function checkAccessRequests(Collection $documents): bool
    {
        return $this->repository->checkAccessRequests($documents);
    }

    private function attachDocuments(array $params, AccessRequest $accessRequest): void
    {
        foreach ($params['documents'] as $documentId) {
            $accessRequest->documents()->attach($documentId, [
                'user_id' => auth()->id(),
                'view' => isset($params['view'][$documentId]),
                'edit' => isset($params['edit'][$documentId]),
                'download' => isset($params['download'][$documentId]),
                'delete' => isset($params['delete'][$documentId]),
                'is_allowed' => null
            ]);
        }
    }
}
