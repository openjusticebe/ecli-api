<?php

namespace App\Http\Resources;

class DocumentResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'identifier' => $this->identifier,
            'type' => $this->type,
            'type_identifier' => $this->type_identifier,
            'year' => (int)$this->year,
            'lang' => $this->lang,
            'court' => new CourtMinimalResource($this->whenLoaded('court')),
            'ecli' => $this->ecli,
            'src' => $this->src,
            'meta' => json_decode($this->metadata),
            'text' => $this->markdown,
            'self_link' => $this->self_link,
            'parent_link' => $this->parent_link,
            'ref' => $this->ref,
            'link' => $this->link,
            'updated_at' => $this->updated_at,
            'updated_at_diff'  => (string)$this->updated_at->diffForHumans(['parts' => 1]),
            'created_at' => $this->created_at,
            'created_at_diff'  => (string)$this->created_at->diffForHumans(['parts' => 1]),
        ];
    }
}
