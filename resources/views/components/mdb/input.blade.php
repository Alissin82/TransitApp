@props([
    'name',
    'label' => null,
    'inputType' => 'text',
    'placeholder' => null,
    'disabled' => false,
    'required' => false,
    'options' => [],
    'active' => false,
])

<div class="form-outline" {{ $inputType === 'select' ? '' : 'data-mdb-input-init' }}>
    @switch($inputType)
        @case('select')
            <select
                    {{ $attributes->merge([
                        'id' => $name,
                        'name' => $name,
                        'placeholder' => $placeholder,
                    ]) }}
                    @disabled($disabled)
                    @class([
                        'form-select',
                        'is-invalid' => $errors->has($name),
                    ])
            >
                <option value="">{{ $placeholder ?? __('Select an option') }}</option>
                @foreach ($options as $key => $optionLabel)
                    <option value="{{ $key }}">{{ $optionLabel }}</option>
                @endforeach
            </select>
        @break

        @case('textarea')
            <textarea
                    {{ $attributes->merge([
                        'id' => $name,
                        'name' => $name,
                        'type' => $inputType,
                        'placeholder' => $placeholder,
                    ]) }}
                    @disabled($disabled)
                    @class([
                        'form-control',
                        'is-invalid' => $errors->has($name),
                        'active' => !empty($slot),
                    ])
            >{{ $slot }}</textarea>
        @break

        @default
            <input
                    {{ $attributes->merge([
                        'id' => $name,
                        'name' => $name,
                        'type' => $inputType,
                        'placeholder' => $placeholder,
                        'autocomplete' => 'off',
                    ]) }}
                    @disabled($disabled)
                    @class([
                        'form-control',
                        'is-invalid' => $errors->has($name),
                        'active' => $active,
                    ])
            />
        @break
    @endswitch

    @if ($label)
        <label class="form-label" for="{{ $name }}">
            @if($required)
                <span class="text-danger">*</span>
            @endif
            {{ $label }}
        </label>
    @endif

    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
