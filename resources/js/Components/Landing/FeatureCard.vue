<template>
    <div class="text-center p-6 bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition">
        <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
            <component :is="iconComponent" class="w-8 h-8 text-red-800" />
        </div>
        <h3 class="text-xl font-semibold mb-2">{{ title }}</h3>
        <p class="text-gray-600">{{ desc }}</p>
    </div>
</template>

<script setup lang="ts">
import { BookOpenIcon, AcademicCapIcon, CheckBadgeIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
    title: String,
    desc: String,
    icon: String
})

const iconMap = {
    'book-open': BookOpenIcon,
    'academic-cap': AcademicCapIcon,
    'badge-check': CheckBadgeIcon,
}

const iconComponent = iconMap[props.icon] || BookOpenIcon
</script>