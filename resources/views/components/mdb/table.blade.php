@props([
    'recordsCount' => 0,
])

<div class="table-responsive">
    <table class="table table-striped table-hover table-group-divider align-middle">
        <thead class="table-light">
        <tr>
            {{ $header }}
        </tr>
        </thead>
        <tbody>
            @if($recordsCount == 0)
                <tr>
                    <td {{ $notFound->attributes->merge([
                        'class' => "text-center text-muted py-4",
                    ]) }}>
                        {{ $notFound }}
                    </td>
                </tr>
            @else
                {{ $body }}
            @endif
        </tbody>
    </table>
</div>
