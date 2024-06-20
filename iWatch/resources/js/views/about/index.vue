<template>
    <div class="container-fluid homeFluidCont d-flex justify-content-center">
        <div class="container m-0 p-0 homeContainer d-flex justify-content-center align-items-center flex-column aboutContainer">
            <div class="bannerContent d-flex align-items-center">
                <!-- <img class="mainLogo" src="/images/iWatchLogo.svg" alt="">
                <img class="mainBanner" width="100%" src="https://lumiere-a.akamaihd.net/v1/images/5up_presssiteheaderimage-pre_4352afc3.jpeg?region=0,0,2850,1194" alt=""> -->
                <img class="mainBanner" width="100%" src="/images/defBanner.jpg" alt="">
            </div>
            <div class="aboutContent d-flex justify-content-center align-items-center flex-column inf-about-us">
                <div class="firstText">
                    <h1>{{ $t('about_title_1') }} <span class="remarkable">{{ $t('about_title_2') }}</span></h1>
                    <p>{{ $t('txt_1') }}</p>
                    <p>{{ $t('txt_2') }}</p>
                    <h1>{{ $t('n_servicios') }}</h1>
                    <p>{{ $t('txt_servicios') }}</p>
                    <ul>
                        <li>{{ $t('txt_li_1') }}</li>
                        <li>{{ $t('txt_li_2') }}</li>
                        <li>{{ $t('txt_li_3') }}</li>
                    </ul>
                    <div class="horiImg">
                        <img class="horizontalImg" src="/images/pirates.jpg" alt="">
                    </div>
                    <p>{{ $t('txt_gracias') }}</p>
                </div>
            </div>
        </div>
    </div>
</template>