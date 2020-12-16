<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
 * @OA\Server(url="https://api-ecli.openjustice.lltl.be/api/v1")
 *
 * @OA\Info(
 *   title="ECLI API of OpenJustice",
 *  version="1.0.0",
 *   @OA\Contact(
 *    email="team@openjustice.be",
 *    name="Team of OpenJustice",
 *  )
 * )
 */
}
