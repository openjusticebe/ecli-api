<?php

namespace App\Http\Resources;

class DocumentResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'num' => $this->num,
            'type' => $this->type,
            'type_num' => $this->type_num,
            'year' => (int)$this->year,
            'lang' => $this->lang,
            'court' => new CourtMinimalResource($this->whenLoaded('court')),
            'ecli' => $this->ecli,
            'src' => $this->src,
            'href' => $this->href,

            'ref' => $this->ref,
            'links' => $this->links
        ];
    }
}
