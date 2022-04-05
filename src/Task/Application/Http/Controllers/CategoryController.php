<?php

namespace Freelance\Task\Application\Http\Controllers;

use Freelance\Task\Application\Http\Resources\CategoryResource;
use Freelance\Task\Domain\Actions\Contracts\CreatesCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\DeletesCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\GetsPaginatedCategoriesAction;
use Freelance\Task\Domain\Actions\Contracts\ShowsCategoryAction;
use Freelance\Task\Domain\Actions\Contracts\UpdatesCategoryAction;
use Freelance\Task\Domain\Dtos\CategoryDto;
use Freelance\Task\Domain\ValueObjects\Id;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

final class CategoryController
{
    public function index(
        GetsPaginatedCategoriesAction $action,
    ): ResourceCollection {
        $paginated = $action->run();
        return CategoryResource::collection($paginated);
    }

    public function store(
        Request               $request,
        CreatesCategoryAction $action
    ): JsonResource {
        $dto = CategoryDto::create(
            $request->input('name'),
            $request->input('parent_id')
        );
        $entity = $action->run($dto);
        return new CategoryResource($entity);
    }

    public function show(
        Id $id,
        ShowsCategoryAction $action,
    ): JsonResource {
        $entity = $action->run($id);
        return new CategoryResource($entity);
    }

    public function update(
        Id $id,
        Request $request,
        UpdatesCategoryAction $action,
    ): JsonResource {
        $dto = CategoryDto::create(
            $request->input('name'),
            $request->input('parent_id')
        );

        $entity = $action->run($id, $dto);
        return new CategoryResource($entity);
    }

    public function destroy(Id $id, DeletesCategoryAction $action): Response
    {
        $action->run($id);
        return response()->noContent();
    }
}
