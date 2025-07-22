<template>
    <GuestLayout>
        <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-lg">
            <h2 class="text-2xl font-bold mb-6">Purchase Course: {{ course.title }}</h2>

            <div class="mb-6">
                <p><strong>Price:</strong> ${{ course.fee.toFixed(2) }}</p>
                <p><strong>Duration:</strong> {{ course.duration }}</p>
                <p><strong>Mode:</strong> {{ course.is_online ? 'Online' : 'On-Campus' }}</p>
            </div>

            <form @submit.prevent="submit">
                <!-- Student info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input v-model="form.name" type="text" placeholder="Student Name" class="input"
                        :class="{ 'border-red-500': errors.name }" />
                    <input v-model="form.email" type="email" placeholder="Email" class="input"
                        :class="{ 'border-red-500': errors.email }" />
                    <input v-model="form.phone_number" type="text" placeholder="Phone Number" class="input"
                        :class="{ 'border-red-500': errors.phone_number }" />
                    <input v-model="form.address" type="text" placeholder="Address" class="input"
                        :class="{ 'border-red-500': errors.address }" />
                </div>

                <!-- Hidden course_id and amount -->
                <input type="hidden" v-model="form.course_id" />
                <input type="hidden" v-model="form.amount" />

                <!-- Payment Method Tabs -->
                <div class="mt-6">
                    <p class="font-semibold mb-2">Select Payment Method:</p>
                    <div class="flex space-x-6">
                        <label v-for="method in paymentMethods" :key="method"
                            class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="payment_method" :value="method" v-model="form.payment_method"
                                class="cursor-pointer" />
                            <span>{{ formatMethod(method) }}</span>
                        </label>
                    </div>
                    <p v-if="errors.payment_method" class="text-red-600 text-sm mt-1">{{ errors.payment_method }}</p>
                </div>

                <button type="submit" class="mt-6 bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700"
                    :disabled="processing">
                    Submit Transaction
                </button>
            </form>
        </div>
    </GuestLayout>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

const props = defineProps({
    course: Object,
})

const paymentMethods = ['cash', 'credit_card', 'bank_transfer']

const form = useForm({
    name: '',
    email: '',
    address: '',
    phone_number: '',
    course_id: props.course.id,
    amount: props.course.price,
    payment_method: '',
})

const processing = ref(false)

function formatMethod(method: string) {
    return method.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase())
}

function submit() {
    processing.value = true
    form.post(route('transactions.store'), {
        onFinish: () => (processing.value = false),
        onSuccess: () =>
            form.reset('name', 'email', 'address', 'phone_number', 'payment_method'),
    })
}

const errors = form.errors
</script>

<style scoped>
.input {
    @apply w-full px-4 py-2 border border-gray-300 rounded;
}
</style>
