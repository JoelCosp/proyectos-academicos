<template>
    <div class="container-fluid homeFluidCont d-flex justify-content-center">
      <div class="container m-0 p-0 homeContainer">
        <div class="row">
          <div class="col-md-6">
            <div class="text-white p-3 mb-3">
                <h1>Bienvenido a nuestra página de soporte!</h1>
            </div>
          </div>
          <div class="col-md-6 complain-box">
            <div class="text-white p-3 mb-3 d-flex">
                <input type="text" class="form-control reqInfo" id="name" placeholder="Nombre">
                <input type="text" class="form-control reqInfo" id="name" placeholder="Apellido">
            </div>
            <div class="text-white p-3 mb-3 d-flex">
                <input type="email" class="form-control reqInfo" id="name" placeholder="Nombre">
                <input type="number" class="form-control reqInfo" id="name" placeholder="Apellido">
            </div>
            <div class="text-white p-3 mb-3 d-flex">
                <Textarea v-model="value" autoResize rows="5" cols="30" placeholder="Mensaje" />
            </div>
            <div class="text-white p-3 mb-3 d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center">
                    <input type="checkbox">
                    <p>Acepto los Términos de uso y la Política de privacidad</p>
                </div>
                <button class="mainReproducerBtn2">Enviar mensaje</button>
            </div>
          </div>
        </div>
        <h1>hola</h1>
        <h1>hola</h1>
        <h1>hola</h1>
        <h1>hola</h1>
        <h1>hola</h1>
        <h1>hola</h1>
        <h1>hola</h1>
      </div>
    </div>
  </template>
  