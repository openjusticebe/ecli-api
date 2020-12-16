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
            'self_link' => $this->self_link,
            'parent_link' => $this->parent_link,
            'ref' => $this->ref,
            'links' => $this->links,
        ];
    }
}
