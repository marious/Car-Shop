'{{ $modelLangFormat }}' => [
'title' => '{{ $titlePlural }}',

'actions' => [
'index' => '{{ $titlePlural }}',
'create' => 'New {{ $titleSingular }}',
'edit' => 'Edit :name',
@if($export)
    'export' => 'Export',
@endif
@if($containsPublishedAtColumn)
    'will_be_published' => '{{$modelBaseName}} will be published at',
@endif
],

'columns' => [
'id' => 'ID',
@foreach($columns as $col)'{{ $col['name'] }}' => '{{ $col['defaultTranslation'] }}',
@endforeach


],
],

// Do not delete me :) I'm used for auto-generation