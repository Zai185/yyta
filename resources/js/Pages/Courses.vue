<template>
    <GuestLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="space-y-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Our Courses</h2>
                    <p class="mt-4 text-lg text-gray-600">Discover our comprehensive range of online and on-campus
                        programs
                    </p>

                </div>

                <div class="flex items-center justify-end gap-4">

                    <div class="flex flex-wrap gap-4 justify-center">
                        <button @click="courseFilter = 'all'"
                            :class="courseFilter === 'all' ? 'bg-red-800 text-white' : 'bg-white text-gray-700 hover:bg-red-50'"
                            class="px-4 py-2 rounded-lg border border-gray-300 font-medium transition-colors">
                            All Courses
                        </button>
                        <button @click="courseFilter = 'online'"
                            :class="courseFilter === 'online' ? 'bg-red-800 text-white' : 'bg-white text-gray-700 hover:bg-red-50'"
                            class="px-4 py-2 rounded-lg border border-gray-300 font-medium transition-colors">
                            Online
                        </button>
                        <button @click="courseFilter = 'campus'"
                            :class="courseFilter === 'campus' ? 'bg-red-800 text-white' : 'bg-white text-gray-700 hover:bg-red-50'"
                            class="px-4 py-2 rounded-lg border border-gray-300 font-medium transition-colors">
                            On-Campus
                        </button>
                    </div>

                    <div class="flex justify-center">
                        <input v-model="searchQuery" type="text" placeholder="Search courses..."
                            class="w-full max-w-md ml-auto border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template v-for="(course, index) in filteredCourses" :key="course.id">
                        <Link :href="route('courses.detail', { id: course.id })"
                            class="transform transition duration-500 ease-out opacity-0 translate-y-4 animate-fade-up"
                            :style="{ animationDelay: `${index * 100}ms`, animationFillMode: 'forwards' }">
                        <CourseCard :course="course" />
                        </Link>
                    </template>

                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup lang="ts">
import CourseCard from '@/Components/Courses/CourseCard.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Course } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue'

const { courses } = defineProps<{
    courses: Course[]
}>()

defineEmits(['navigate', 'select-course'])

const courseFilter = ref('all')

// const filteredCourses = computed(() => {
//     if (courseFilter.value === 'all') {
//         return courses
//     }
//     return courses.filter(course => {
//         if (courseFilter.value == 'online') {
//             return course.is_online
//         } else {
//             return !course.is_online
//         }
//     })
// })

const searchQuery = ref('')

const filteredCourses = computed(() => {
    const query = searchQuery.value.toLowerCase()
    return courses.filter(course => {
        const matchesFilter =
            courseFilter.value === 'all' ||
            (courseFilter.value === 'online' && course.is_online) ||
            (courseFilter.value === 'campus' && !course.is_online)

        const matchesSearch =
            course.name.toLowerCase().includes(query) ||
            (course.description?.toLowerCase().includes(query) ?? false)

        return matchesFilter && matchesSearch
    })
})

</script>

<style scoped>
@keyframes fade-up {
    0% {
        opacity: 0;
        transform: translateY(16px);
    }

    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-up {
    animation: fade-up 0.6s ease-out forwards;
}
</style>
