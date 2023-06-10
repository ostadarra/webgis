@props(['value'])

<!-- $attributes->merge will forward any attributes we pass to the component and merge the class attribute -->
<!-- with the tailwind classes defined here, this component will accept either a value attribute or a slot -->
<label
    {{ $attributes->merge(['class' => 'whitespace-nowrap block font-medium text-sm text-gray-700 mb-1']) }}>
    {{ $value ?? $slot }}
</label>