<template>
  <div class="dropzone-container">
    <input
      type="file"
      @change="handleFileChange"
      accept="image/*"
    />
    <div v-if="imagePreview" class="preview-container">
      <img :src="imagePreview" class="preview-img" />
    </div>
    <p v-if="imageName">{{ imageName }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const imageFile = ref(null);
const imagePreview = ref('');
const imageName = ref('');

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    imageFile.value = file;
    imageName.value = file.name;
    imagePreview.value = URL.createObjectURL(file);
  }
};

const clearImage = () => {
  imageFile.value = null;
  imagePreview.value = '';
  imageName.value = '';
};

const getImageData = () => ({
  file: imageFile.value,
  name: imageName.value,
  preview: imagePreview.value,
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

.preview-img {
  height: 100%;
  width: 100%;
  object-fit: cover;
  border-radius: 5px;
  border: 1px solid #a2a2a2;
  background-color: #a2a2a2;
}
</style>
