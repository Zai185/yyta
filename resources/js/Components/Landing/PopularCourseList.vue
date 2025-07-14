<template>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div v-for="course in sampleCourses" :key="course.id"
            class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <span :class="course.is_online ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'"
                    class="px-2 py-1 rounded-full text-xs font-medium">
                    {{ course.is_online ? 'Online' : 'On-Campus' }}
                </span>
                <span class="text-2xl font-bold text-red-800">${{ course.fee }}</span>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ course.name }}</h3>
            <p class="text-gray-600 mb-4">{{ course.short_description }}</p>
            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                <span>{{ course.duration }}</span>
                <span>{{ course.modules }} modules</span>
            </div>
            <button @click="$emit('navigate')"
                class="w-full bg-red-800 text-white py-2 rounded-lg hover:bg-red-900 transition-colors">
                Learn More
            </button>
        </div>
    </div>
</template>

<script setup>
const sampleCourses = [
    { id: 1, name: 'Data Science & Analytics', short_description: 'Master data analysis, machine learning, and statistical modeling', fee: 1299, duration: '12 weeks', modules: 8, is_online: true },
    { id: 2, name: 'Web Development Bootcamp', short_description: 'Full-stack development with modern technologies', fee: 899, duration: '16 weeks', modules: 8, is_online: true },
    { id: 3, name: 'Business Administration MBA', short_description: 'Comprehensive MBA program for professionals', fee: 45000, duration: '2 years', modules: 8, is_online: false },
]
</script>