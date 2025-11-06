{{-- resources/views/components/forms/date-and-time.blade.php --}}

@props([
    'label',          // The text for the label
    'name',           // The name attribute for the input (e.g., 'start_time')
    'id' => null,      // Optional ID; defaults to the name
    'value' => ''      // Optional default value
])

@php
    // Default the ID to be the same as the name if not provided
    $id = $id ?? $name;
@endphp

{{-- This wrapper div allows you to pass classes like 'grow' from the form --}}
<div {{ $attributes->only('class') }}>

    {{-- Use your existing label component --}}
    <x-forms.input-label :for="$id">{{ $label }}</x-forms.input-label>

    {{-- Use your existing input component, forcing the type --}}
    <x-forms.main-input
        :id="$id"
        :name="$name"
        type="datetime-local"
        :value="old($name, $value)"
        {{-- Merge any other attributes, ensuring the 'w-full' class --}}
        {{ $attributes->except('class')->merge(['class' => 'block w-full']) }}
    />

    {{-- Add validation error display --}}
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
