<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     *
     * @OA\Info(
     *  title="ECLI API of OpenJustice",
     *  description="This is the documentation of ECLI Api of OpenJustice.be",
     *  version="1.0.0",
     *    @OA\License(
     *     name="GNU General Public License v3",
     *     url="https://www.gnu.org/licenses/gpl-3.0.en.html"
     *   ),
     *   @OA\Contact(
     *    email="team@openjustice.be",
     *    name="Team of OpenJustice",
     *    )
     *   )
     *  )
     * @OA\Tag(
     *     name="ECLI",
     *     description="Everything about ECLI",
     * ),
     * @OA\Tag(
     *     name="court",
     *     description="Everything about Court",
     * ),
     *  @OA\Tag(
     *     name="category",
     *     description="Everything about category of courts",
     * ),
     *  @OA\Tag(
     *     name="stats",
     *     description="Everything about category of stats",
     * ),
     *  @OA\Tag(
     *     name="utus",
     *     description="Everything about Utus",
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     * ),
     * @OA\Response(
     *     response=403,
     *     description="Forbidden"
     * ),
     * @OA\Response(
     *     response=404,
     *     description="Resource Not Found"
     * ),
     * @OA\SecurityScheme(
     *     securityScheme="bearer",
     *     type="http",
     *     scheme="bearer",
     * ),
     * @OA\Server(url="https://api-ecli.openjustice.lltl.be/api/v1")
     */
}
