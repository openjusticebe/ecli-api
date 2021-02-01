<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterDocsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
    *    @OA\Schema(
    *    schema="filterDocs",
    *       @OA\Property(
    *       property="lang[]",
    *       type="array",
    *       @OA\Items(type="string", example="french")
    *       ),
    *   @OA\Property(
    *       property="year[]",
    *       type="array",
    *       @OA\Items(type="string", example="2001")

    *       ),
    *   @OA\Property(
    *       property="type[]",
    *       type="array",
    *       @OA\Items(type="string", example="ARR")
    *      ),
    *      )
    *    )
    *
    */
    

    public function rules()
    {
        return [
          'type' => 'array|required',
          'year' => 'array|required',
          'lang' => 'array|required',
      ];
    }
}
