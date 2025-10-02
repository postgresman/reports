<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import axios from 'axios';
import InputError from '@/Components/InputError.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Login" />
    <div class="mx-auto max-w-xl sm:px-2 lg:px-3">
        <div class="overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)]">
            <div class="relative flex w-full flex-10 items-stretch">
                <div class="absolute -bottom-16 -left-16 h-40 w-[calc(100%+8rem)] bg-gradient-to-b from-transparent via-white to-white dark:via-zinc-900 dark:to-zinc-900"></div>
            </div>
            <div class="relative items-center w-full"> 
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-black dark:text-white">Welcome Reports Dashboard</h1>
                    <p class="text-sm text-black/50 dark:text-white/50">Please log in to continue.</p>
                </div>
                <div class="mt-6 text-gray-800">   
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="email" value="Email" />
                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                autofocus
                                required
                                autocomplete="email"
                            />
                            <InputError class="mt-2" :message="errors.email" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="password" value="Password" />
                            <TextInput
                                id="password"
                                type="password"
                                class="mt-1 block w-full"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />
                            <InputError class="mt-2" :message="errors.password" />
                        </div>
                        <InputError class="mt-2" :message="message" />
                        <div class="mt-4 flex items-center justify-end">
                            <PrimaryButton class="ms-4" >Log in</PrimaryButton> 
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </div>
</template>

<script>
export default {
    created() {
        if (this.getToken()) {
            this.$router.push({ name: 'Dashboard' });
        }
    },
    data() {
        return {
            form: {
                email: '',
                password: '',
                remember: false,
            },
            errors: [],
            message: null,
        };
    },
    methods: {
        submit() {
            this.errors = {};
            this.message = null;

            axios
                .post(route('api.auth.login'), this.form)
                .then((response) => {
                    this.setToken(response.data.token);
                    this.$router.push({ name: 'Dashboard' });
                })
                .catch((error) => {
                    if (error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    } else if (error.response.data.message) {
                        this.message = error.response.data.message;
                    }
                });
        },
    },
};
</script>