<?php

namespace App\Http\Resources;

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
        ];
    }
}
