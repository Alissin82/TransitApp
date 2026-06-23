@props([
    'name',
    'label',
    'form',
])

<md-outlined-text-field
        {{ $attributes->merge([
            'id' => $name,
            'name' => $name,
            'label' => $label,
            'autocomplete' => 'off',
            'class' => 'w-100',
            'form' => $form
        ]) }}
        @error($name)
            error
            error-text="{{ $message }}"
        @enderror
>
    @error($name)
        <md-icon slot="trailing-icon">error</md-icon>
    @enderror
</md-outlined-text-field>
