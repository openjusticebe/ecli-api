<?php

namespace App\Http\Resources;

/**
 * @OA\Schema(
 *     title="DocMinimal",
 *     description="Document minumal resource",
 * @OA\Property(
 *     title="identifier",
 *     property="identifier",
 *     type="string",
 *     example="20200526.HBOJ"
 * ),
 * @OA\Property(
 *     title="type",
 *     property="type",
 *     type="string",
 *     example="DEC"
 * ),
 * @OA\Property(
*     title="type_identifier",
 *    property="type_identifier",
 *    description="Concatenation of type, '.' and identifier",
 *    type="string",
 *    example="DEC.20200526.HBOJ"
 * ),
 * @OA\Property(
 *     title="updated_at",
 *     property="updated_at",
 *     format="datetime",
 *     description="updated_at",
*      type="string"
* ),
*  @OA\Property(
*     title="updated_at_diff",
*     property="updated_at_diff",
*     description="updated_at field diff for humans",
*     type="string"
* )
 * ),

*/

class DocumentMinimalResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'identifier' => $this->identifier,
            'type' => $this->type,
            'type_identifier' => $this->type_identifier,
            'year' => (int)$this->year,
            'lang' => $this->lang,
            'ecli' => $this->ecli,
            'src' => $this->src,
            'self_link' => $this->self_link,
            'ref' => $this->ref,
            'link' => $this->link,
            'updated_at_diff'  => (string)$this->updated_at->diffForHumans(['parts' => 1])
            'created_at_diff'  => (string)$this->created_at->diffForHumans(['parts' => 1]),
        ];
    }
}
