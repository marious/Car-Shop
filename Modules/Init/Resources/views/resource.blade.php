@php echo "<?php";
@endphp

namespace {{ $resourceNamespace }};

use Illuminate\Http\Resources\Json\JsonResource;

class {{$resourceBaseName}} extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
@foreach($columnsToQuery as $col)
@if (!in_array($col, ['created_at', 'updated_at', 'deleted_at']))
            '{{$col}}' => $this->{{$col}},
@endif
@endforeach
        ];
    }
}
