<template>
    <div>
        <div class="text-3xl font-bold text-red-800">{{ value }}</div>
        <div class="text-sm text-gray-600">{{ label }}</div>
    </div>
</template>

<script setup>
defineProps({
    value: String,
    label: String
})
</script>
