<template>
    
    <section>
        <div class="container d-flex justify-content-center align-items-center">
            <Navbar/>
            <div class="row justify-content-center my-5 w-100">
                <div class="contenedorInputs card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="w-100 d-flex justify-content-center align-items-center mb-5">
                                <img class="logoImgLogin" src="/images/iWatchLogo.svg" alt="">
                            </div>
                            <h2 class="mb-3 loginTitle">{{ $t('login') }}</h2>
                            <form @submit.prevent="submitLogin">
                                <div class="">
                                    <!-- Email -->
                                    <div class="mb-3">
                                        <input v-model="loginForm.email" id="email" type="email" class="form-control reqInfo" :placeholder="$t('email')" required autofocus autocomplete="username">
                                        <!-- Validation Errors -->
                                        <div class="text-danger mt-1">
                                            <div v-for="message in validationErrors?.email">
                                                {{ message }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Password -->
                                    <div class="mb-4">
                                        <input v-model="loginForm.password" id="password" type="password" class="form-control reqInfo" :placeholder="$t('password')" required autocomplete="current-password">
                                        <!-- Validation Errors -->
                                        <div class="text-danger-600 mt-1">
                                            <div v-for="message in validationErrors?.password">
                                                {{ message }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Buttons -->
                                    <button class="accion mb-4" :class="{ 'opacity-25': processing }" :disabled="processing">
                                        {{ $t('login') }}
                                    </button>
                                    <router-link class="createAccount d-flex justify-content-between align-items-center mb-4" :to="{name: 'auth.register'}"><p>Crear cuenta</p></router-link>
                                </div>
                                
                                <router-link :to="{name: 'auth.forgot-password'}"><p class="txtLog">{{ $t('forgot_password')}}</p></router-link>
                                <!-- Remember me -->
                                <div class="form-check mt-5 pt-5">
                                    <input class="form-check-input" type="checkbox" name="remember" v-model="loginForm.remember" id="flexCheckIndeterminate">
                                    <label class="form-check-label" for="flexCheckIndeterminate">
                                        {{ $t('remember_me') }}
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <section>
        <div class="row flex box shadow-4 justify-content-center border-round animation-duration-2000 p-0 m-0">
        <div class="container d-flex p-0">
            <div class="row m-0 infoRow d-flex justify-content-center">
                <a class="arrow d-flex justify-content-center" href="#firstPart">
                    <img class="downArrow" src="images/linkArrow.svg" alt="">
                </a>
            </div>
        </div>
    </div>



    <!-- NUEVO ESTILO SECCIONES LOGIN -->



    <section id="firstPart" v-animateonscroll="{ enterClass: 'fadein', leaveClass: 'fadeout' }">
        <div class="frst-sect-img d-flex justify-content-center align-items-center flex-column">
            <h1 class="m-0 mb-3 f-el">DISFRUTA EN TU <span class="remarkable">TELEVISIÓN</span></h1>
            <h2 class="m-0">El mejor contenido para Smart TV, Playstation, Xbox, Chromecast, Apple TV, reproductores Blu-ray y muchos más.</h2>
            <img src="/images/devices.jpg" alt="">
            <h1 class="m-0 mb-3">USA <span class="remarkable">CUALQUIER</span> DISPOSITIVO</h1>
            <h2 class="m-0 l-el">Ve en streaming todas las películas y series en tu móvil, tableta, ordenador y televisor.</h2>
        </div>
    </section>



    <!-- ********* -->



    <!-- <div id="firstSection" v-animateonscroll="{ enterClass: 'fadein', leaveClass: 'fadeout' }" class="row flex box shadow-4 justify-content-center border-round animation-duration-2000 p-0 m-0">
        <div class="container d-flex p-0 mb-3 mt-4">
            <div class="row m-0 infoRow infoSection1">
                <div class="text p-0 col-sm-12 col-md-12 col-lg-6 d-flex flex-column justify-content-center login1-container">
                    <h1 class="login-text1 login-h1">DISFRUTA EN TU <span class="remarkable">TELEVISIÓN</span></h1>
                    <h2 class="login-text1 login-h2">El mejor contenido para Smart TV, Playstation, Xbox, Chromecast, Apple TV, reproductores Blu-ray y muchos más.</h2>
                </div>
                <div class="marketingImage p-0 col-sm-12 col-md-12 col-lg-6 d-flex justify-content-center">
                    <img class="infoImg" src="images/watchContent.svg" alt="">
                </div>
            </div>
        </div>
    </div>
    <div v-animateonscroll="{ enterClass: 'fadein', leaveClass: 'fadeout' }" class="row flex box shadow-4 justify-content-center border-round animation-duration-2000 p-0 m-0">
        <div class="container d-flex p-0 mt-4 mb-4">
            <div class="row m-0 infoRow infoSection2">
                <div class="marketingImage p-0 col-sm-12 col-md-12 col-lg-6 d-flex justify-content-center">
                    <img class="infoImg" src="images/robotFilm.svg" alt="">
                </div>
                <div class="text p-0 col-sm-12 col-md-12 col-lg-6 d-flex flex-column justify-content-center login2-container">
                    <h1 class="login-text2 login-h1">USA <span class="remarkable">CUALQUIER</span> DISPOSITIVO</h1>
                    <h2 class="login-text2 login-h2">Ve en streaming todas las películas y series en tu móvil, tableta, ordenador y televisor.</h2>
                </div>
            </div>
        </div>
    </div> -->
    <div v-animateonscroll="{ enterClass: 'fadein', leaveClass: 'fadeout' }" class="row flex box shadow-4 justify-content-center border-round animation-duration-2000 p-0 m-0">
        <div class="container p-0">
            <div class="row m-0 infoQuestions d-flex justify-content-center align-items-center">
                <h1>PREGUNTAS FRECUENTES</h1>
                <Accordion activeIndex="0" class="w-50 col-sm-12 col-md-12 col-lg-6">
                    <AccordionTab header="¿Qué es iWatch?">
                        <p class="m-0">
iWatch es una plataforma de transmisión de películas en línea que ofrece a los usuarios acceso a una amplia variedad de contenido audiovisual, desde clásicos atemporales hasta los últimos lanzamientos de Hollywood. Con características innovadoras como perfiles personalizados y recomendaciones basadas en el historial de visualización, iWatch brinda una experiencia de entretenimiento única y conveniente. Su interfaz intuitiva y funciones de navegación fluidas hacen que sea fácil de usar, y su compromiso con la calidad se refleja en su extenso catálogo y actualizaciones periódicas de contenido nuevo. En resumen, iWatch se destaca como una opción líder en el mercado de transmisión de películas, ofreciendo una experiencia completa y satisfactoria para los amantes del cine.</p>
                    </AccordionTab>
                    <AccordionTab header="¿Cuánto cuesta iWatch?">
                        <p class="m-0">Disfruta de iWatch en tu smartphone, tableta, Smart TV, ordenador o dispositivo de streaming, todo por una tarifa mensual fija y a un precio regalado. Planes desde 9,95 € a 19,95 € al mes. Sin cargos adicionales ni contratos.</p>
                    </AccordionTab>
                    <AccordionTab header="¿Dónde puedo ver iWatch?">
                        <p class="m-0">iWatch es una plataforma de streaming de películas que puedes disfrutar en línea desde la comodidad de tu hogar. Para acceder a iWatch, simplemente visita su sitio web oficial o descarga la aplicación desde la tienda de aplicaciones de tu dispositivo. Una vez registrado, podrás explorar su extenso catálogo de películas y series, que abarca desde éxitos de taquilla hasta contenido exclusivo y producciones originales. ¡Prepárate para sumergirte en un mundo de entretenimiento cinematográfico sin límites con iWatch!</p>
                    </AccordionTab>
                    <AccordionTab header="¿Cómo cancelo mi suscripción?">
                        <p class="m-0"> Cancelar tu suscripción en iWatch es fácil y conveniente. Simplemente inicia sesión en tu cuenta de iWatch desde el sitio web oficial o la aplicación móvil. Dirígete a la sección de configuración o ajustes de tu cuenta, donde encontrarás la opción para administrar tu suscripción. Desde allí, podrás cancelar tu suscripción con unos pocos clics. Una vez cancelada, seguirás disfrutando de iWatch hasta el final del período de facturación actual, y tu acceso se desactivará automáticamente al finalizar ese período. ¡Esperamos verte de vuelta pronto en iWatch!</p>
                    </AccordionTab>
                    <AccordionTab header="¿Qué contenido puedo ver?">
                        <p class="m-0">En iWatch, ofrecemos una amplia variedad de contenido para satisfacer todos los gustos y preferencias. Nuestra plataforma cuenta con una extensa biblioteca de películas de diversos géneros, incluyendo acción, aventura, comedia, drama, ciencia ficción, terror, y mucho más. Además, también puedes disfrutar de series de televisión populares, documentales fascinantes y contenido original exclusivo. Con iWatch, siempre tendrás algo emocionante para ver, ya sea solo o en compañía de tus seres queridos.</p>
                    </AccordionTab>
                </Accordion>
            </div>
        </div>
    </div>

    

    <!-- <Accordion :multiple="true" :activeIndex="[0]">
        <AccordionTab header="Header I">
            <p class="m-0">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.
            </p>
        </AccordionTab>
        <AccordionTab header="Header II">
            <p class="m-0">
                Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo
                enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Consectetur, adipisci velit, sed quia non numquam eius modi.
            </p>
        </AccordionTab>
        <AccordionTab header="Header III">
            <p class="m-0">
                At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in
                culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.
            </p>
        </AccordionTab>
    </Accordion> -->

    

    
    <!-- AIMACION PARA COPIAR -->
        <!-- <div v-animateonscroll="{ enterClass: 'fadein', leaveClass: 'fadeout' }" class="flex box shadow-4 justify-content-center align-items-center h-10rem w-10rem sm:h-15rem sm:w-15rem border-round animation-duration-1000">
            <span class="text-3xl font-bold">fade-in</span>
        </div> -->
</section>

<div class="form-check form-switch form-mode d-none">
    <input class="form-check-input" type="checkbox" id="darkModeSwitch" v-model="isDarkModeLogin">
    <label class="form-check-label" :for="isDarkModeLogin ? 'darkModeSwitch' : 'lightModeSwitch'">
        <span>
            <i class="pi pi-moon"></i>
        </span>
        <span>
            <i class="pi pi-sun"></i>
        </span>
    </label>
</div>
</template>



<script setup>
// import Navbar from '@/layouts/Nav.vue'
import useAuth from '@/composables/auth'
import 'primeicons/primeicons.css';
import { computed, ref, watchEffect, onMounted } from "vue";
const isDarkModeLogin = ref('true');

const { loginForm, validationErrors, processing, submitLogin } = useAuth();

watchEffect(() => {
        if (isDarkModeLogin.value) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
});

</script>

<style scoped>
    .body {
        background-image: url("C:\xampp\htdocs\Laravel\iWatch\public\images\fondoLogin.jpg");
        background-repeat: no-repeat;
        background-size: cover;
        z-index: -1; /* Coloca el pseudo-elemento detrás del contenido */
        filter: blur(1px) brightness(46%);
        -webkit-filter: blur(1px) brightness(46%);
        -moz-filter: blur(1px) brightness(46%);
    }

    .container{
        padding-top: 120px;
    }

    /* estilos acordeon */

    .p-accordion .p-accordion-content{
        background-color: pink;
    }

    .p-accordion .p-accordion-header {
        background-color: green !important;
    }
</style>
