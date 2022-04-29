<?php

namespace Freelance\Task\Application\Http\Controllers\Client;

use Filterable\Dtos\FilterDto;
use Freelance\Task\Application\Http\Resources\Client\JobResource;
use Freelance\Task\Domain\Actions\Contracts\Job\CreatesJobAction;
use Freelance\Task\Domain\Actions\Contracts\Job\DeletesJobAction;
use Freelance\Task\Domain\Actions\Contracts\Job\GetsPaginatedJobsAction;
use Freelance\Task\Domain\Actions\Contracts\Job\ShowsJobAction;
use Freelance\Task\Domain\Actions\Contracts\Job\UpdatesJobAction;
use Freelance\Task\Domain\Dtos\JobDto;
use Freelance\Task\Domain\Models\Job;
use Freelance\Task\Domain\ValueObjects\Id;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

use function response;

final class JobController
{
    use AuthorizesRequests;

    public function index(
        Request                 $request,
        GetsPaginatedJobsAction $action,
    ): ResourceCollection {
        $this->authorize('index', Job::class);
        $filterDto = FilterDto::createFromArrayBag($request->all());
        $paginated = $action->run($filterDto);
        return JobResource::collection($paginated);
    }

    public function store(
        Request          $request,
        CreatesJobAction $action
    ): JsonResource {
        $this->authorize('create', Job::class);
        $dto = JobDto::create(
            $request->input('name'),
            $request->input('description'),
            $request->input('category_ids', []),
            $request->file('media', []),
        );
        $entity = $action->run($dto);
        return new JobResource($entity);
    }

    public function show(
        Id             $id,
        ShowsJobAction $action,
    ): JsonResource {
        $this->authorize('show', [Job::class, $id]);
        $entity = $action->run($id);
        return new JobResource($entity);
    }

    public function update(
        Id               $id,
        Request          $request,
        UpdatesJobAction $action,
    ): JsonResource {
        $this->authorize('update', [Job::class, $id]);
        $dto = JobDto::create(
            $request->input('name'),
            $request->input('description'),
            $request->input('category_ids', []),
            $request->file('media', []),
        );

        $entity = $action->run($id, $dto);
        return new JobResource($entity);
    }

    public function destroy(Id $id, DeletesJobAction $action): Response
    {
        $this->authorize('delete', [Job::class, $id]);
        $action->run($id);
        return response()->noContent();
    }
}
