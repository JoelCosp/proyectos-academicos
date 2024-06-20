<template>
    <div class="container-fluid homeFluidCont d-flex justify-content-center settings-page">
        <div class="container m-0 p-0 homeContainer d-flex justify-content-center align-items-center flex-column aboutContainer">
            <div class="options-content advices-txt">
                <h1><i class="pi pi-info-circle pe-3 pi-h1" style="font-size: 2rem"></i>{{ $t('advice_title') }}</h1>
                <h2>{{ $t('v_1') }}</h2>
                <h3>{{ $t('v_2') }}</h3>
                <p class="m-0">
                    {{ $t('v_3') }}
                </p>
                <h3>{{ $t('v_4') }}</h3>
                <p>{{ $t('v_5') }}</p>
                <ul>
                    <li><p>· {{ $t('v_6') }}</p></li>
                    <li><p>· {{ $t('v_7') }}</p></li>
                    <li><p>· {{ $t('v_8') }}</p></li>
                </ul>
                <h3>{{ $t('v_9') }}</h3>
                <p>{{ $t('v_10') }}</p>
                <h3>{{ $t('v_11') }}</h3>
                <p>{{ $t('v_12') }}</p>
                <h3>{{ $t('v_13') }}</h3>
                <p>{{ $t('v_14') }}</p>
            
                <h2>{{ $t('v_15') }}</h2>
                <h3>{{ $t('v_16') }}</h3>
                <p class="m-0">
                    {{ $t('v_17') }}
                </p>
                <p class="m-0"></p>
                <h3>{{ $t('v_18') }}</h3>
                <p>{{ $t('v_19') }}</p>
                <ul>
                    <li>
                        <p>{{ $t('v_20') }}</p>
                    </li>
                </ul>
                <h3>{{ $t('v_21') }}</h3>
                <p>{{ $t('v_22') }}</p>
                <ul>
                    <li><p>· {{ $t('v_23') }}</p></li>
                    <li><p>· {{ $t('v_24') }}</p></li>
                    <li><p>· {{ $t('v_25') }}</p></li>
                </ul>
                <h3>{{ $t('v_26') }}</h3>
                <p>{{ $t('v_27') }}</p>
                <ul>
                    <li><p>· {{ $t('v_28') }}</p></li>
                    <li><p>· {{ $t('v_29') }}</p></li>
                    <li><p>· {{ $t('v_30') }}</p></li>
                </ul>
                <h3>{{ $t('v_31') }}</h3>
                <p>{{ $t('v_32') }}</p>
                <h3>{{ $t('v_33') }}</h3>
                <p>{{ $t('v_34') }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue';

    const active = ref(0);
</script>