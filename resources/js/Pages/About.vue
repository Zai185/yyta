<template>
    <GuestLayout>
        <!-- Hero Banner -->
        <section class="relative h-96 bg-red-900 text-white">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1504817343863-5092a923803e?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8dW5pdmVyc2l0aWVzfGVufDB8fDB8fHww" alt="YMax University Campus"
                    class="w-full h-full object-cover opacity-20" />
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">About YMax University University</h1>
                <p class="text-xl text-red-100">Empowering minds, shaping futures</p>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 space-y-20">
            <!-- Our Story -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Our Story</h2>
                    <p class="text-gray-600 mb-4">
                        Founded in 1985, YMax University University has been at the forefront of innovative education,
                        combining academic
                        excellence with cutting-edge technology to deliver world-class learning experiences online and
                        on campus.
                    </p>
                    <p class="text-gray-600">
                        With over 35 years of experience, we’ve educated thousands of students who are now leaders
                        driving global
                        change.
                    </p>
                </div>
                <div class="bg-red-50 p-8 rounded-2xl shadow-sm">
                    <div class="grid grid-cols-2 gap-6 text-center">
                        <StatBox value="50,000+" label="Graduates" />
                        <StatBox value="200+" label="Courses" />
                        <StatBox value="95%" label="Success Rate" />
                        <StatBox value="24/7" label="Support" />
                    </div>
                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <MissionCard title="Our Mission" icon="lightning-bolt"
                    desc="To provide accessible, high-quality education that empowers individuals to achieve their personal and professional goals." />
                <MissionCard title="Our Vision" icon="eye"
                    desc="To be a leading global institution bridging traditional education with modern industry needs, fostering innovation and lifelong learning." />
            </div>

            <!-- Why Choose Us -->
            <section class="bg-gray-900 text-white rounded-2xl p-10">
                <h2 class="text-2xl font-bold text-center mb-10">Why Choose YMax University?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <WhyCard icon="academic-cap" title="Expert Faculty"
                        desc="Learn from industry professionals and academic experts" />
                    <WhyCard icon="device-mobile" title="Flexible Learning"
                        desc="Study online or on-campus at your pace" />
                    <WhyCard icon="badge-check" title="Accredited Programs"
                        desc="Earn internationally recognized degrees" />
                </div>
            </section>

            <!-- Leadership -->
            <div class="bg-white rounded-2xl shadow-md p-10">
                <h2 class="text-2xl font-bold text-center text-gray-900 mb-10">Leadership Team</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <TeamMember name="Dr. Sarah Johnson" role="President & CEO"
                        desc="25+ years in higher education leadership" />
                    <TeamMember name="Prof. Michael Chen" role="Academic Director"
                        desc="Expert in curriculum and e-learning" />
                    <TeamMember name="Lisa Rodriguez" role="Student Success Director"
                        desc="Focuses on student and career support" />
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import MissionCard from '@/Components/About/MissionCard.vue';
import StatBox from '@/Components/About/StatBox.vue';
import TeamMember from '@/Components/About/TeamMember.vue';
import WhyCard from '@/Components/About/WhyCard.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue'
</script>
