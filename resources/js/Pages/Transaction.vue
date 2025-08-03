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
                <!-- Student Info -->
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

                <!-- Payment Method -->
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

                <!-- Credit Card Fields -->
                <div v-if="form.payment_method === 'credit_card'" class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input v-model="form.card_number" type="text" inputmode="numeric" maxlength="16"
                        placeholder="Card Number" class="input" :class="{ 'border-red-500': errors.card_number }"
                        @input="form.card_number = form.card_number.replace(/\D/g, '').slice(0, 16)" />
                    <input v-model="form.card_name" type="text" placeholder="Name on Card" class="input"
                        :class="{ 'border-red-500': errors.card_name }"
                        @input="form.card_name = form.card_name.replace(/[^A-Za-z\s]/g, '')" />
                    <input v-model="form.expiry_date" type="text" maxlength="5" placeholder="Expiry Date (MM/YY)"
                        class="input" :class="{ 'border-red-500': errors.expiry_date }" @input="formatExpiryDate" />
                    <input v-model="form.cvv" type="text" inputmode="numeric" maxlength="4" placeholder="CVV"
                        class="input" :class="{ 'border-red-500': errors.cvv }"
                        @input="form.cvv = form.cvv.replace(/\D/g, '').slice(0, 4)" />
                </div>

                <!-- Bank Transfer Info -->
                <div v-if="form.payment_method === 'bank_transfer'" class="mt-4 bg-blue-50 p-4 rounded border">
                    <p class="font-semibold mb-2 text-blue-900">Please transfer to the following account:</p>
                    <p><strong>Bank:</strong> KBZ Bank</p>
                    <p><strong>Account Name:</strong> Y-Max University</p>
                    <p><strong>Account Number:</strong> 9833 9384 8384 9384</p>
                    <p class="mt-2 text-sm text-gray-600">After the transfer, we will contact you to confirm your
                        enrollment.</p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="mt-6 bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700"
                    :disabled="processing">
                    Submit Transaction
                </button>
            </form>
        </div>
    </GuestLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
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

    // Credit Card Fields
    card_number: '',
    card_name: '',
    expiry_date: '',
    cvv: '',
})

const processing = ref(false)

function formatMethod(method: string) {
    return method.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase())
}

function formatExpiryDate() {
    let value = form.expiry_date.replace(/\D/g, '').slice(0, 4)
    form.expiry_date = value.length >= 3
        ? `${value.slice(0, 2)}/${value.slice(2)}`
        : value
}

function submit() {
    processing.value = true
    form.post(route('transactions.store'), {
        onFinish: () => (processing.value = false),
        onSuccess: () =>
            form.reset(
                'name',
                'email',
                'address',
                'phone_number',
                'payment_method',
                'card_number',
                'card_name',
                'expiry_date',
                'cvv'
            ),
    })
}

const errors = form.errors
</script>

<style scoped>
.input {
    @apply w-full px-4 py-2 border border-gray-300 rounded;
}
</style>
