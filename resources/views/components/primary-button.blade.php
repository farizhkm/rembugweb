<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md']) }}>
    {{ $slot }}
</button>
