<template>
    <div
      class="dropzone-container"
      @dragover="dragover"
      @dragleave="dragleave"
      @drop="drop"
    >
      <input
        type="file"
        name="file"
        id="fileInput"
        class="hidden-input"
        @change="onChange"
        ref="refFiles"
        accept=".mp4" 
      />
  
      <div class="file-label text-center" v-if="thumbnail2 || modelValue">
        <div :key="thumbnail2.name" class="preview-card">
          <div>
            <video class="preview-video" v-bind:src="modelValue" controls></video> <!-- Cambia de img a video y agrega el atributo controls -->
            <p :title="thumbnail2.name">
              {{ makeName(thumbnail2.name) }}
            </p>
          </div>
          <div>
            <a
              href="javascript:void(0)"
              class="ml-2"
              type="button"
              @click="remove(index)"
              title="Remove file"
            >
              <b>&times;</b>
            </a>
          </div>
        </div>
      </div>
  
      <label for="fileInput" class="file-label text-center" v-if=" !thumbnail2 && !modelValue">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="50"
          height="50"
          fill="currentColor"
          class="bi bi-file-earmark-play"
          viewBox="0 0 16 16"
        >
          <path d="M13.38 3.634a.5.5 0 0 1 .5.866L9.125 8 13.88 11.5a.5.5 0 0 1 0 .866l-.5.5a.5.5 0 0 1-.866-.5l-.004-.008 0-.002L8.874 8.866l-.004-.002-.002-.004a.5.5 0 0 1 .002-.588l.002-.004L13.38 3.634zM12 4.158v7.684l-4.86-3.842L12 4.158z" />
        </svg>
        <div v-if="isDragging">Release to drop files here.</div>
        <div v-else>Drop files here or <u>click here</u> to upload.</div>
      </label>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref, watch } from "vue";
  
  const props = defineProps({
    modelValue: String
  });
  
  const thumbnail2 = ref('');
  const isDragging = ref(false);
  const refFiles = ref(null);
  let videoUrl = ref('');
  
  const emit = defineEmits(['update:modelValue']);
  
  const onChange = (() => {
    thumbnail2.value = refFiles.value.files;
    videoUrl = URL.createObjectURL(refFiles.value.files[0]);
  });
  
  const makeName = ((name) => {
    if (!props.modelValue) {
      return (
        name.split(".")[0].substring(0, 3) +
        "..." +
        name.split(".")[name.split(".").length - 1]
      );
    }
  });
  
  const remove = ((i) => {
    thumbnail2.value = '';
    videoUrl = '';
    emit('update:modelValue', '');
  });
  
  const dragover = ((e) => {
    e.preventDefault();
    isDragging.value = true;
  });
  
  const dragleave = (() => {
    isDragging.value = false;
  });
  
  const drop = ((e) => {
    e.preventDefault();
    refFiles.value.files = e.dataTransfer.files;
    onChange();
    isDragging.value = false;
  });
  
  watch(thumbnail2, () => {
    emit('update:modelValue', thumbnail2.value[0]);
  });
  </script>
  
  <style scoped>
  .dropzone-container {
    padding: 0rem;
    background: #f7fafc;
    border: 1px solid #e2e8f0;
  }
  
  .hidden-input {
    opacity: 0;
    overflow: hidden;
    position: absolute;
    width: 1px;
    height: 1px;
  }
  
  .file-label {
    font-size: 20px;
    display: block;
    cursor: pointer;
  }
  
  .preview-container {
    display: flex;
    margin-top: 2rem;
  }
  
  .preview-card {
    display: flex;
    border: 1px solid #a2a2a2;
    padding: 5px;
    margin-left: 5px;
    object-fit: cover;
  }
  
  .preview-video {
    height: 100%;
    width: 100%;
    border-radius: 5px;
    border: 1px solid #a2a2a2;
    background-color: #a2a2a2;
  }
  </style>
  