<script setup>

import {onMounted, onUnmounted, ref} from "vue";

const props = defineProps({
    fileTypes: {
        required: true,
        type: Array
    },
    max: {
      type: String,
      default: '10MB'
    },
    multi: {
        type: Boolean,
        default: false
    },
})

const emit = defineEmits(['files']);
const events = ['dragenter', 'dragover', 'dragleave', 'drop', 'change'];
const active = ref(false);
const error = ref({
    hasError: false,
    message: ''
});

function preventDefaults(e) {
    e.preventDefault()
}

onMounted(() => {
    events.forEach((eventName) => {
        document.body.addEventListener(eventName, preventDefaults)
    })
})

onUnmounted(() => {
    events.forEach((eventName) => {
        document.body.removeEventListener(eventName, preventDefaults)
    })
})

function setActive() {
    active.value = true
}

function setInactive() {
    active.value = false
}

function onDrop(e) {
    if (!props.multi && e.dataTransfer.files.length > 1) {
        error.value.hasError = true;
        error.value.message = 'Maximal 1 Datei erlaubt.';
        setInactive();
        return;
    }

    for (let i = 0; i < e.dataTransfer.items.length; i++) {
        const split = e.dataTransfer.items[i].type.split('/');
        let ext = split[split.length - 1];

        if (ext.includes('+')) {
            ext = ext.split('+')[0];
        }
        const lowered = props.fileTypes.map(item => item.toLowerCase());

        if (!lowered.includes(ext)) {
            error.value.hasError = true;
            error.value.message = 'Dieser File Typ ist nicht erlaubt.';
            setInactive();
            return
        }
    }

    emit('files', e.dataTransfer.files);
    setInactive()
}


function onChange(e) {
    emit('files', e.target.files);
}

</script>
<template>

    <div :data-active="active"
         @dragenter.prevent="setActive"
         @dragover.prevent="setActive"
         @dragleave.prevent="setInactive"
         @drop.prevent="onDrop"
         @change.prevent="onChange"
         class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
         :class="{ 'bg-red-50': active }">
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                 viewBox="0 0 48 48" aria-hidden="true">
                <path
                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="flex text-sm text-gray-600">
                <label for="file-upload"
                       class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                    <span>Datei hochladen</span>
                    <input id="file-upload" name="file-upload" type="file" class="sr-only">
                </label>
                <p class="pl-1">oder 'drag and drop'</p>
            </div>
            <p class="text-xs text-gray-500">{{ fileTypes.join(', ') }} bis zu {{ max }}</p>
        </div>
    </div>
    <div class="text-red-500" v-if="error.hasError">{{ error.message }}</div>

</template>
