<template>
    <div class="overflow-hidden bg-white h-full rounded-lg shadow-md hover:shadow-lg transition-shadow cursor-pointer">
        <img :src="course.img_url ? course.img_url : 'https://shengdongzhao.com/assets/blog/placeholder-image.jpeg'"
            alt="" class="w-full object-cover h-48 border-b">
        <div class="p-6 flex flex-col h-full">
            <div class="flex-1">
                <div class="flex items-center justify-between mb-4">
                    <span :class="course.is_online ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'"
                        class="px-2 py-1 rounded-full text-xs font-medium">
                        {{ course.is_online ? 'Online' : 'On-Campus' }}
                    </span>
                    <span class="text-2xl font-bold text-red-800">${{ course.fee.toLocaleString() }}</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ course.name }}</h3>
                <p class="text-gray-600 mb-4 line-clamp-3" v-html="course.description"></p>
            </div>

            <div class="flex items-center justify-between text-sm text-gray-500">
                <span>Duration: {{ course.duration }}</span>
                <span>{{ course.modules.length }} modules</span>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Course } from '@/types';

defineProps<{
    course: Course
}>()
</script>