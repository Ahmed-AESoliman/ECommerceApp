<template>
<div class="main">
    <div class="dropzone-container" @dragover="dragover" @dragleave="dragleave" @drop="drop" :style="isDragging && 'border-color: green;'">
        <input type="file" multiple name="file" id="fileInput" class="hidden-input" @change="onChange" ref="file" accept=".pdf,.jpg,.jpeg,.png" />

        <label for="fileInput" class="file-label">
            <div v-if="isDragging">Release to drop files here.</div>
            <div v-else>Drop files here or <u>click here</u> to upload.</div>
        </label>
    </div>
    <div class="preview-container mt-4" v-if="files.length||existsPath.length">
        <div v-for="file in files" :key="file.name" class="preview-card">
            <img class="preview-img" :src="generateURL(file) " />
            <i class="bi bi-trash" @click="remove(files.indexOf(file))"></i>
        </div>
        <div v-for="(path,index) in existsPath" :key="index" class="preview-card">
            <img class="preview-img" :src="`${getUlOrigin}/storage/${path}`" />
            <i class="bi bi-trash" @click="remove(files.indexOf(file))"></i>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
        existsPath: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            isDragging: false,
            files: [],
            filePaths: [],
        };
    },
    methods: {
        dragover(e) {
            e.preventDefault();
            this.isDragging = true;
        },
        dragleave() {
            this.isDragging = false;
        },
        drop(e) {
            e.preventDefault();
            this.$refs.file.files = e.dataTransfer.files;
            this.onChange();
            this.isDragging = false;
        },
        remove(i) {
            // this.files.splice(i, 1);
            // this.filePaths.splice(i, 1);
            console.log(this.files[i]);
        },
        generateURL(file) {
            let fileSrc = URL.createObjectURL(file);
            setTimeout(() => {
                URL.revokeObjectURL(fileSrc);
            }, 1000);
            return fileSrc;
        },
        onChange() {
            const self = this;
            let incomingFiles = Array.from(this.$refs.file.files);
            const fileExist = self.files.some((r) =>
                incomingFiles.some(
                    (file) => file.name === r.name && file.size === r.size
                )
            );
            if (fileExist) {
                self.showMessage = true;
                alert("New upload contains files that already exist");
            } else {
                incomingFiles.forEach(file => {
                    const form = new FormData();
                    form.append('image', file)
                    this.$http.post(`/api/product/upload-attachment`, form, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            "Authorization": `Bearer ${this.$cookies.get('token')}`
                        }
                    }).then((res) => {
                        this.filePaths.push(res.data.data)
                        file.path = res.data.data
                        self.files.push(file);
                    })
                });
            }
        },
    },
    computed: {
        getUlOrigin() {
            return window.location.origin
        }
    }
};
</script>

<style scoped>
.main {
    text-align: center;
}

.dropzone-container {
    padding: 4rem;
    background: #f7fafc;
    border: 2px dashed;
    border-color: #9e9e9e;

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
    padding: 5px;
    margin-left: 5px;
    width: 200px;
    position: relative;
    height: 225px;
}

.preview-img {
    width: 100%;
    height: 100%;
    border-radius: 5px;
    border: 1px solid #a2a2a2;
    background-color: #a2a2a2;

}

.bi.bi-trash {
    font-size: 1.5rem;
    color: #c20606;
    position: absolute;
    right: 15px;
    cursor: pointer;
}
</style>
