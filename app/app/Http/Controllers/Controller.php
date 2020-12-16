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
     *   version="1.0.0",
     *    @OA\License(
     *     name="GNU General Public License v3",
     *     url="https://www.gnu.org/licenses/gpl-3.0.en.html"
     *   ),
     *   @OA\Contact(
     *    email="team@openjustice.be",
     *    name="Team of OpenJustice",
     *  )
     * )
     * )
     */
}
