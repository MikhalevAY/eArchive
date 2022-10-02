<?php

namespace App\Services;

use App\Models\AccessRequest;
use App\RepositoryInterfaces\AccessRequestRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function getDocumentIds(AccessRequest $accessRequest, array $params): array
    {
        $documents = [];
        foreach ($accessRequest->documents()->allRelatedIds()->toArray() as $document) {
            $documents[$document] = $params['document-' . $document] ?? 0;
        }

        return $documents;
    }
}
