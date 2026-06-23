@props([
    'name',
    'label',
    'form',
    'headline',
    'options' => [],
])

<md-outlined-select
        {{ $attributes->merge([
            'id' => $name,
            'name' => $name,
            'label' => $label,
            'class' => 'w-100',
            'form' => $form,
        ]) }}
        @error($name)
            error
            error-text="{{ $message }}"
        @enderror
>
    @error($name)
        <md-icon slot="trailing-icon">error</md-icon>
    @enderror
    <md-select-option value="" disabled>
        <div slot="headline">{{ $headline }}</div>
    </md-select-option>
    @foreach($options as $value => $label)
        <md-select-option value="{{ $value }}">
            <div slot="headline">{{ $label }}</div>
        </md-select-option>
    @endforeach
</md-outlined-select>
