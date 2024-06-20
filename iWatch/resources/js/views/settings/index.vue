<template>
    <div class="container-fluid homeFluidCont d-flex justify-content-center settings-page">
        <div class="container m-0 p-0 homeContainer d-flex justify-content-center align-items-center flex-column aboutContainer">
            <div class="options-content">
                <h1><i class="pi pi-cog pe-3 pi-h1" style="font-size: 2rem"></i>{{ $t('settings2') }}</h1>
                <ul class="p-3">
                    <li class="section-title pt-0"><i class="pi pi-user p-2 me-3" style="font-size: 1rem"></i>{{ $t('CUENTA') }}</li>
                    <router-link to="/profile">
                        <li><p>{{ $t('actu_inf_personal') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    </router-link>
                    <li><p>{{ $t('cambiar_contra') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <router-link to="/subscriptions">
                        <li><p>{{ $t('m_plan') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    </router-link>
                    <li><p>{{ $t('control_parental') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <li><p>{{ $t('conf_dispositivos') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <li><p>{{ $t('historial_visu') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <hr>
                    <li class="section-title"><i class="pi pi-caret-right p-2 me-3" style="font-size: 1rem"></i>{{ $t('REPRODUCCION') }}</li>
                    <li><p>{{ $t('calidad_rep') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <li><p>{{ $t('conf_subs') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <li><p>{{ $t('conf_calidad_audio') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <li><p>{{ $t('conf_calidad_video') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <hr>
                    <li class="section-title"><i class="pi pi-check-circle p-2 me-3" style="font-size: 1rem"></i>{{ $t('PREFERENCIAS_USUARIO') }}</li>
                    <li><p>{{ $t('rep_automatica') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <li><p>{{ $t('idioma_subtitulos') }}</p><LocaleSwitcher /></li>
                    <hr>
                    <li class="section-title"><i class="pi pi-arrow-circle-down p-2 me-3" style="font-size: 1rem"></i>{{ $t('DESCARGAS_ALMACENAMIENTO') }}</li>
                    <li><p>{{ $t('descargas') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <li><p>{{ $t('conf_alm') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <li><p>{{ $t('gestion_descargas') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <hr>
                    <li class="section-title"><i class="pi pi-comment p-2 me-3" style="font-size: 1rem"></i>{{ $t('NOTIFICACIONES') }}</li>
                    <li><p>{{ $t('conf_noti_correo') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <li><p>{{ $t('conf_noti_push') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <hr>    
                    <li class="section-title"><i class="pi pi-lock p-2 me-3" style="font-size: 1rem"></i>{{ $t('PRIVACIDAD') }}</li>
                    <li><p>{{ $t('conf_privacidad_cuenta') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <li><p>{{ $t('pref_privacidad_datos') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    <hr>
                    <li class="section-title pt-0"><i class="pi pi-user p-2 me-3" style="font-size: 1rem"></i>{{ $t('INFORMACIÓN_ADICIONAL') }}</li>
                    <router-link to="/about">
                        <li><p>{{ $t('sob_nos') }}</p><i class="pi pi-angle-right right-arrow p-2" style="font-size: 1rem"></i></li>
                    </router-link>
                </ul>
                <hr class="mb-4 mt-5">
                <p>{{ $t('delete_account_inf_1') }} <span class="remarkable">{{ $t('delete_account_inf_2') }}</span></p>
            </div>
        </div>
    </div>
</template>

<script setup>
    import LocaleSwitcher from "../../components/LocaleSwitcher.vue";
</script>