<?php

namespace App\Http\Resources;

class DocumentResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'num' => $this->num,
            'type' => $this->type,
            'year' => (int)$this->year,
            'lang' => $this->lang,
            'court' => $this->court,
            'elci' => $this->elci,
            'src' => $this->src,
            'href' => $this->href,
            'links' => [
                'default' => null,
                'text' => null,
                'pdf' =>  null,
            ]
        ];
    }
}


// 'logo': 'https://www.rechtbanken-tribunaux.be/themes/custom/hoverech/logo.svg',
// 'website': 'https://iubel.be/IUBELhome/welkom',

//         'logo': 'https://openjustice.be/wp-content/uploads/2020/10/cropped-Open-Justice.png',
// 'website': 'https://openjustice.be/',

//             'logo': 'https://www.const-court.be/images/titre_index3.gif',
// 'website': 'https://www.const-court.be/',

//             'logo': 'http://www.raadvst-consetat.be/a/s/logo.gif',
// 'website': 'http://www.raadvst-consetat.be/',
