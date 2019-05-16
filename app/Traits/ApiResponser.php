<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ApiResponser
{
	function successResponse($data, $code = 200)
	{
		return response()->json($data, $code);
	}

	function errorResponse($message, $code = 400)
	{
		return response()->json(
			[
				'error' => 
				[
					'message' => $message,
					'code' => $code
				]
			], $code
		);
	}

	function showAll($collection, $code = 200)
	{
		// if ($collection instanceof Collection) 
		// {
		// 	return $this->paginateCollection($collection)->response()->setStatuscode($code);
		// }

		return $collection->response()->setStatuscode($code);

	}

	function paginateCollection(Collection $collection)
	{
		$perPage = $this->determinePageSize();

		$page = LengthAwarePaginator::resolveCurrentPage();

		$results = $collection->slice((($page-1) * $perPage), $perPage)->values();

		$paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
			'page' => LengthAwarePaginator::resolveCurrentPath()
		]);

		$paginated->appends(request()->query());

		return $paginated;
	}

	function determinePageSize()
	{
		$perPage = request()->validate([
			'per_page' => 'integer|min:1|max:50'

		]);

		return !empty($perPage) ? $perPage['per_page'] : 15;
	}

	function showOne(Model $instancia, $code = 200)
	{
		return $this->successResponse(['data' => $instancia], $code);
	}

	function showMessage($message, $code = 200)
	{
		return $this->successResponse(['data' => $message], $code);
	}

	function sendHttp($code = 422, $text = "Please specify at least one different value.")
	{
		throw new HttpException($code, $text);
	}
	function sendNoOwnerError($code = 422, $text = "No puedes modificar un producto que no te pertenece.")
	{
		throw new HttpException($code, $text);
	}
	
}