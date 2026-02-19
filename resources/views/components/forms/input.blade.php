@props([
    'name',
    'label' => null,
    'inputType' => 'text',
    'placeholder' => null,
    'disabled' => false,
    'required' => false,
    'options' => [],
])

@php
    $errorKey = str_replace(['[', ']'], ['', ''], $name);
    $errorClass = $errors->has($errorKey) ? 'is-invalid' : '';
    $isSelect = $inputType === 'select';
@endphp

<div class="form-outline" {{ $isSelect ? '' : 'data-mdb-input-init' }}>
    @if ($isSelect)
        <select
                id="{{ $name }}"
                name="{{ $name }}"
                {{ $attributes->merge(['class' => "form-select $errorClass"]) }}
                @disabled($disabled)
        >
            <option value="">{{ $placeholder ?? __('Select an option') }}</option>
            @foreach ($options as $key => $optionLabel)
                <option value="{{ $key }}">{{ $optionLabel }}</option>
            @endforeach
        </select>
    @elseif ($inputType === 'textarea')
        <textarea
                id="{{ $name }}"
                name="{{ $name }}"
                {{ $attributes->merge(['class' => "form-control $errorClass"]) }}
                placeholder="{{ $placeholder }}"
                @disabled($disabled)
        >{{ $slot }}</textarea>
    @else
        <input
                type="{{ $inputType }}"
                id="{{ $name }}"
                name="{{ $name }}"
                {{ $attributes->merge(['class' => "form-control $errorClass"]) }}
                placeholder="{{ $placeholder }}"
                @disabled($disabled)
        />
    @endif

    @if ($label)
        <label class="form-label" for="{{ $name }}">
            @if($required)
                <span class="text-danger">*</span>
            @endif
            {{ $label }}
        </label>
    @endif

    @error($errorKey)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
