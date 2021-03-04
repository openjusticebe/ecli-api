<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ESTrait;

class SearchController extends Controller
{
    use ESTrait;

    /**
     * @OA\Get(
     * path="/search/{needle}",
     * summary="Search method",
     * description="Search method",
     * @OA\Parameter(
     *          name="needle",
     *          description="needle",
     *          required=true,
     *          in="path",
     *          example="OR",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     * tags={"search"},
     * @OA\Response(
     *    response=200,
     *    description="Success"
     * )
     * )
     */
    public function search($needle)
    {
        $needle = rawurldecode($needle);
        $params = [
            'index' => 'ecli',
            'type' => 'documents',
            'body'  => [
                'query' => [
                    'match' => [
                        'text' => "$needle"  // "B. LETERME en mr. W. DERVEAUX"
                        ]
                    ],
                    'highlight' => [
                        'pre_tags' => "<span class='highlightText'>",
                        'post_tags' => "</span>",
                        'fields'    => [
                            "text" => new \stdClass() //title" => []   //NO.
                        ],
                        'require_field_match' => false
                    ]
                ],
        ];

      
        return $this->searchDocument($params);  // method from ESTrait
    }
}
