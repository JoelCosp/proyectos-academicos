<template>
    <div class="container d-flex justify-content-center align-items-center registerContent">
        <div class="row justify-content-center my-5">
            <div class="contenedorInputs col-md-6">
                <div class="card registerCard border-0 shadow-sm">
                    <div class="card-body">
                        <router-link class="d-flex align-items-center registerTitle" :to="{name: 'auth.login'}">
                            <img class="me-2 mt-1" src="/images/registerArrow.svg" alt="">
                            <h2 class="mb-3 loginTitle">{{ $t('register') }}</h2>
                        </router-link>
                        <form @submit.prevent="submitRegister">
                            <div class="">
                                <!-- Email -->
                                <div class="mb-3 d-flex">
                                    <div class="me-3">
                                        <input v-model="registerForm.name" id="name" type="text" class="form-control reqInfo" placeholder="Nombre" autofocus>
                                        <!-- Validation Errors -->
                                        <div class="text-danger mt-1">
                                            <div v-for="message in validationErrors?.name">
                                                {{ message }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <input v-model="registerForm.apellido" id="apellido" type="text" class="form-control reqInfo" placeholder="Apellido" autofocus>
                                        <!-- Validation Errors -->
                                        <div class="text-danger mt-1">
                                            <div v-for="message in validationErrors?.apellido">
                                                {{ message }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input v-model="registerForm.phone" id="phone" type="number" class="form-control reqInfo" placeholder="Número de telefono" autofocus>
                                    <!-- Validation Errors -->
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.phone">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input v-model="registerForm.email" id="email" type="email" class="form-control reqInfo" placeholder="Correo electrónico" autocomplete="username">
                                    <!-- Validation Errors -->
                                    <div class="text-danger mt-1">
                                        <div v-for="message in validationErrors?.email">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Password Component -->
                                <!-- <div class="mb-3 register-password">
                                    <Password v-model="registerForm.password" toggleMask  class="form-control reqInfo" placeholder="Contraseña"/>
                                </div> -->
                                <!-- Password -->
                                <div class="mb-4">
                                    <input v-model="registerForm.password" id="password" type="password" class="form-control reqInfo" placeholder="Contraseña" autocomplete="current-password">
                                    <div class="text-danger-600 mt-1">
                                        <div v-for="message in validationErrors?.password">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Password confirmation Component -->
                                <!-- <div class="mb-3 register-password">
                                    <Password v-model="registerForm.password_confirmation" toggleMask  class="form-control reqInfo" placeholder="Confirma la contraseña"/>
                                </div> -->

                                <div class="mb-4">
                                    <input v-model="registerForm.password_confirmation" id="password_confirmation" type="password" class="form-control reqInfo" placeholder="Confirmar contraseña" autocomplete="current-password">
                                    <div class="text-danger-600 mt-1">
                                        <div v-for="message in validationErrors?.password_confirmation">
                                            {{ message }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex items-center justify-end mt-4">
                                    <button class="btn btn-primary accion" :class="{ 'opacity-25': processing }" :disabled="processing">
                                        {{ $t('register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import useAuth from '@/composables/auth'

const { registerForm, validationErrors, processing, submitRegister } = useAuth();

</script>
