<script setup>
import {onBeforeMount, onMounted, ref, watch} from "vue";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import {component as CKEditor} from '@ckeditor/ckeditor5-vue';

const props = defineProps({
    modelValue: String,
    readOnly: Boolean

})

const emit = defineEmits(['update:modelValue'])

const editorConfig = ref({
    toolbar: (props.readOnly ? [] : ['undo','redo','|', 'heading', '|', 'bold', 'italic','|', 'link','inserttable', '|','bulletedList', 'numberedList', 'blockQuote','indent','outdent']) ,
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
        ]
    }
})


const editorData = ref(props.modelValue || '')

onMounted(() => {
    
})

watch(editorData, () => {
    emit('update:modelValue', editorData.value)
})




</script>

<template>
    <CKEditor :editor="ClassicEditor" v-model="editorData" :model-value="props.modelValue" :config="editorConfig" :disabled="readOnly"></CKEditor>
</template>

<style>
.ck-editor__editable{
    min-height: 260px;
}
</style>
