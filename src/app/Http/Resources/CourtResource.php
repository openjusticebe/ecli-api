<?php

namespace App\Http\Resources;

class CourtResource extends BaseResource
{
    public function toArray($request)
    {
        return [
            'acronym' => $this->acronym,
            'name_nl' => $this->name_nl,
            'name_de' => $this->name_de,
            'name_fr' => $this->name_fr,
            'href' => null,
            'logo_href' => null,
            'category' => $this->category,
            'documents_count' => (int)$this->docsPerYear->sum('documents_count'),
            'first_year' => (int)$this->documents->min('year'),
            'last_year' =>  (int)$this->documents->max('year'),
            'year_count' => (int)$this->docsPerYear->count(),
            'type_count' => (int)$this->docsPerType->count(),
            // 'posts' => PostResource::collection($this->whenLoaded('posts')),
            'docsPerType' => $this->docsPerType(),
            'docsPerYear' => $this->docsPerYear(),
            // 'expires_at' => $this->whenPivotLoaded('role_user', function () {
            //     return $this->pivot->expires_at;
            // }),
        ];
    }
}
