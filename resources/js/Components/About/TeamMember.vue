<template>
    <div class="text-center">
        <div class="w-24 h-24 bg-red-100 rounded-full mx-auto mb-4 flex items-center justify-center">
            <svg class="w-10 h-10 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <h4 class="font-semibold text-gray-900">{{ name }}</h4>
        <p class="text-red-800 text-sm mb-2">{{ role }}</p>
        <p class="text-gray-600 text-sm">{{ desc }}</p>
    </div>
</template>

<script setup>
defineProps({
    name: String,
    role: String,
    desc: String
})
</script>
