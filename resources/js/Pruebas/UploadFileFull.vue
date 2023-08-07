<template>
    <div class="example-full">


        <div v-show="$refs.upload && $refs.upload.dropActive" class="drop-active">
            <h3>Drop files to upload</h3>
        </div>
        <div v-if="!files.length">
            <div class="text-center p-5">
                <h4>Drop files anywhere to upload<br />or</h4>
                <label :for="name" class="btn btn-lg btn-primary">Select Files</label>
            </div>
        </div>

        <div v-if="files.length">
            <ul>
                <li v-for="(file, index) in files" :key="file.id">
                    <img class="td-image-thumb" v-if="file.thumb" :src="file.thumb" />
                                    <span v-else>No Image</span>
                                    <div class="filename">
                                        {{ file.name }}
                                    </div>
                    <span v-if="file.error">{{ file.error }}</span>
                    <span v-else-if="file.success">success</span>
                    <span v-else-if="file.active">active</span>
                    <span v-else></span>
                    <a class="dropdown-item" href="#"
                                @click.prevent="$refs.upload.remove(file)">Remove</a>
                </li>
            </ul>
        </div>

        <div class="upload" v-show="!isOption">

            <div class="example-foorer">
                <div class="footer-status float-right">
                    Drop: {{ $refs.upload ? $refs.upload.drop : false }},
                    Active: {{ $refs.upload ? $refs.upload.active : false }},
                    Uploaded: {{ $refs.upload ? $refs.upload.uploaded : true }},
                    Drop active: {{ $refs.upload ? $refs.upload.dropActive : false }}
                </div>
                <div class="btn-group">
                    <file-upload class="btn btn-primary dropdown-toggle" :post-action="postAction" :put-action="putAction"
                        :extensions="extensions" :accept="accept" :multiple="multiple" :directory="directory"
                        :create-directory="createDirectory" :size="size || 0"
                        :thread="thread < 1 ? 1 : (thread > 5 ? 5 : thread)" :headers="headers" :data="data" :drop="drop"
                        :drop-directory="dropDirectory" :add-index="addIndex" v-model="files" @input-filter="inputFilter"
                        @input-file="inputFile" ref="upload">
                        <i class="fa fa-plus"></i>
                        Select
                    </file-upload>
                    <div class="dropdown-menu">
                        <label class="dropdown-item" :for="name">Add files</label>
                        <a class="dropdown-item" href="#" @click="onAddFolder">Add folder</a>
                        <a class="dropdown-item" href="#" @click.prevent="addData.show = true">Add data</a>
                    </div>
                </div>
                <button type="button" class="btn btn-success" v-if="!$refs.upload || !$refs.upload.active"
                    @click.prevent="$refs.upload.active = true">
                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                    Start Upload
                </button>
                <button type="button" class="btn btn-danger" v-else @click.prevent="$refs.upload.active = false">
                    <i class="fa fa-stop" aria-hidden="true"></i>
                    Stop Upload
                </button>
            </div>
        </div>





        <div class="option" v-show="isOption">
            <div class="form-group">
                <label for="accept">Accept:</label>
                <input type="text" id="accept" class="form-control" v-model="accept">
                <small class="form-text text-muted">Allow upload mime type</small>
            </div>
            <div class="form-group">
                <label for="extensions">Extensions:</label>
                <input type="text" id="extensions" class="form-control" v-model="extensions">
                <small class="form-text text-muted">Allow upload file extension</small>
            </div>
            <div class="form-group">
                <label>PUT Upload:</label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="put-action" id="put-action" value=""
                            v-model="putAction"> Off
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="put-action" id="put-action" value="/upload/put"
                            v-model="putAction"> On
                    </label>
                </div>
                <small class="form-text text-muted">After the shutdown, use the POST method to upload</small>
            </div>
            <div class="form-group">
                <label for="thread">Thread:</label>
                <input type="number" max="5" min="1" id="thread" class="form-control" v-model.number="thread">
                <small class="form-text text-muted">Also upload the number of files at the same time (number of
                    threads)</small>
            </div>
            <div class="form-group">
                <label for="size">Max size:</label>
                <input type="number" min="0" id="size" class="form-control" v-model.number="size">
            </div>
            <div class="form-group">
                <label for="minSize">Min size:</label>
                <input type="number" min="0" id="minSize" class="form-control" v-model.number="minSize">
            </div>
            <div class="form-group">
                <label for="autoCompress">Automatically compress:</label>
                <input type="number" min="0" id="autoCompress" class="form-control" v-model.number="autoCompress">
                <small class="form-text text-muted" v-if="autoCompress > 0">More than {{ autoCompress }} files
                    are automatically compressed</small>
                <small class="form-text text-muted" v-else>Set up automatic compression</small>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" id="add-index" class="form-check-input" v-model="addIndex"> Start position to
                        add
                    </label>
                </div>
                <small class="form-text text-muted">Add a file list to start the location to add</small>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" id="drop" class="form-check-input" v-model="drop"> Drop
                    </label>
                </div>
                <small class="form-text text-muted">Drag and drop upload</small>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" id="drop-directory" class="form-check-input" v-model="dropDirectory"> Drop
                        directory
                    </label>
                </div>
                <small class="form-text text-muted">Not checked, filter the dragged folder</small>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" id="create-directory" class="form-check-input" v-model="createDirectory">
                        Create Directory
                    </label>
                </div>
                <small class="form-text text-muted">The directory file will send an upload request. The mime type is
                    <code>text/directory</code></small>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="checkbox" id="upload-auto" class="form-check-input" v-model="uploadAuto"> Auto start
                    </label>
                </div>
                <small class="form-text text-muted">Automatically activate upload</small>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg btn-block"
                    @click.prevent="isOption = !isOption">Confirm</button>
            </div>
        </div>
















    </div>
</template>
<style>
.example-full .btn-group .dropdown-menu {
    display: block;
    visibility: hidden;
    transition: all .2s
}

.example-full .btn-group:hover>.dropdown-menu {
    visibility: visible;
}

.example-full label.dropdown-item {
    margin-bottom: 0;
}

.example-full .btn-group .dropdown-toggle {
    margin-right: .6rem
}

.td-image-thumb {
    max-width: 4em;
    max-height: 4em;
}

.example-full .filename {
    margin-bottom: .3rem
}

.example-full .btn-is-option {
    margin-top: 0.25rem;
}

.example-full .example-foorer {
    padding: .5rem 0;
    border-top: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
}


.example-full .edit-image img {
    max-width: 100%;
}

.example-full .edit-image-tool {
    margin-top: .6rem;
}

.example-full .edit-image-tool .btn-group {
    margin-right: .6rem;
}

.example-full .footer-status {
    padding-top: .4rem;
}

.example-full .drop-active {
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    position: fixed;
    z-index: 9999;
    opacity: .6;
    text-align: center;
    background: #000;
}

.example-full .drop-active h3 {
    margin: -.5em 0 0;
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    font-size: 40px;
    color: #fff;
    padding: 0;
}
</style>

<script>
import Cropper from 'cropperjs'
import ImageCompressor from '@xkeshi/image-compressor'
import FileUpload from 'vue-upload-component'
export default {
    components: {
        FileUpload,
    },

    data() {
        return {
            files: [],
            accept: 'image/png,image/gif,image/jpeg,image/webp',
            extensions: 'gif,jpg,jpeg,png,webp',
            // extensions: ['gif', 'jpg', 'jpeg','png', 'webp'],
            // extensions: /\.(gif|jpe?g|png|webp)$/i,
            minSize: 1024,
            size: 1024 * 1024 * 10,
            multiple: true,
            directory: false,
            drop: true,
            dropDirectory: true,
            createDirectory: false,
            addIndex: false,
            thread: 3,
            name: 'file',
            postAction: '/upload/post',
            putAction: '/upload/put',
            headers: {
                'X-Csrf-Token': 'xxxx',
            },
            data: {
                '_csrf_token': 'xxxxxx',
            },

            autoCompress: 1024 * 1024,
            uploadAuto: false,
            isOption: false,

            addData: {
                show: false,
                name: '',
                type: '',
                content: '',
            },


            editFile: {
                show: false,
                name: '',
            }
        }
    },

    watch: {
        'editFile.show'(newValue, oldValue) {
            // 关闭了 自动删除 error
            if (!newValue && oldValue) {
                this.$refs.upload.update(this.editFile.id, { error: this.editFile.error || '' })
            }

            if (newValue) {
                this.$nextTick(() => {
                    if (!this.$refs.editImage) {
                        return
                    }
                    let cropper = new Cropper(this.$refs.editImage, {
                        autoCrop: false,
                    })
                    this.editFile = {
                        ...this.editFile,
                        cropper
                    }
                })
            }
        },

        'addData.show'(show) {
            if (show) {
                this.addData.name = ''
                this.addData.type = ''
                this.addData.content = ''
            }
        },
    },

    methods: {
        inputFilter(newFile, oldFile, prevent) {
            if (newFile && !oldFile) {
                // Before adding a file
                // 添加文件前

                // Filter system files or hide files
                // 过滤系统文件 和隐藏文件
                if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
                    return prevent()
                }

                // Filter php html js file
                // 过滤 php html js 文件
                if (/\.(php5?|html?|jsx?)$/i.test(newFile.name) && newFile.type !== "text/directory") {
                    return prevent()
                }

                // Automatic compression
                // 自动压缩
                if (newFile.file && newFile.error === "" && newFile.type.substr(0, 6) === 'image/' && this.autoCompress > 0 && this.autoCompress < newFile.size) {
                    newFile.error = 'compressing'
                    const imageCompressor = new ImageCompressor(null, {
                        convertSize: 1024 * 1024,
                        maxWidth: 512,
                        maxHeight: 512,
                    })
                    imageCompressor.compress(newFile.file)
                        .then((file) => {
                            this.$refs.upload.update(newFile, { error: '', file, size: file.size, type: file.type })
                        })
                        .catch((err) => {
                            this.$refs.upload.update(newFile, { error: err.message || 'compress' })
                        })
                }
            }


            if (newFile && newFile.error === "" && newFile.file && (!oldFile || newFile.file !== oldFile.file)) {
                // Create a blob field
                // 创建 blob 字段
                newFile.blob = ''
                let URL = (window.URL || window.webkitURL)
                if (URL) {
                    newFile.blob = URL.createObjectURL(newFile.file)
                }

                // Thumbnails
                // 缩略图
                newFile.thumb = ''
                if (newFile.blob && newFile.type.substr(0, 6) === 'image/') {
                    newFile.thumb = newFile.blob
                }
            }

            // image size
            // image 尺寸
            if (newFile && newFile.error === '' && newFile.type.substr(0, 6) === "image/" && newFile.blob && (!oldFile || newFile.blob !== oldFile.blob)) {
                newFile.error = 'image parsing'
                let img = new Image();
                img.onload = () => {
                    this.$refs.upload.update(newFile, { error: '', height: img.height, width: img.width })
                }
                img.οnerrοr = (e) => {
                    this.$refs.upload.update(newFile, { error: 'parsing image size' })
                }
                img.src = newFile.blob
            }
        },

        // add, update, remove File Event
        inputFile(newFile, oldFile) {
            if (newFile && oldFile) {
                // update

                if (newFile.active && !oldFile.active) {
                    // beforeSend

                    // min size
                    if (newFile.size >= 0 && this.minSize > 0 && newFile.size < this.minSize && newFile.type !== "text/directory") {
                        this.$refs.upload.update(newFile, { error: 'size' })
                    }
                }

                if (newFile.progress !== oldFile.progress) {
                    // progress
                }

                if (newFile.error && !oldFile.error) {
                    // error
                }

                if (newFile.success && !oldFile.success) {
                    // success
                }
            }


            if (!newFile && oldFile) {
                // remove
                if (oldFile.success && oldFile.response.id) {
                    // $.ajax({
                    //   type: 'DELETE',
                    //   url: '/upload/delete?id=' + oldFile.response.id,
                    // })
                }
            }


            // Automatically activate upload
            if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error) {
                if (this.uploadAuto && !this.$refs.upload.active) {
                    this.$refs.upload.active = true
                }
            }
        },


        alert(message) {
            alert(message)
        },


        onEditFileShow(file) {
            this.editFile = { ...file, show: true }
            this.$refs.upload.update(file, { error: 'edit' })
        },

        onEditorFile() {
            if (!this.$refs.upload.features.html5) {
                this.alert('Your browser does not support')
                this.editFile.show = false
                return
            }

            let data = {
                name: this.editFile.name,
                error: '',
            }
            if (this.editFile.cropper) {
                let binStr = atob(this.editFile.cropper.getCroppedCanvas().toDataURL(this.editFile.type).split(',')[1])
                let arr = new Uint8Array(binStr.length)
                for (let i = 0; i < binStr.length; i++) {
                    arr[i] = binStr.charCodeAt(i)
                }
                data.file = new File([arr], data.name, { type: this.editFile.type })
                data.size = data.file.size
            }
            this.$refs.upload.update(this.editFile.id, data)
            this.editFile.error = ''
            this.editFile.show = false
        },

        // add folder
        onAddFolder() {
            if (!this.$refs.upload.features.directory) {
                this.alert('Your browser does not support')
                return
            }
            let input = document.createElement('input')
            input.style = "background: rgba(255, 255, 255, 0);overflow: hidden;position: fixed;width: 1px;height: 1px;z-index: -1;opacity: 0;"
            input.type = 'file'
            input.setAttribute('allowdirs', true)
            input.setAttribute('directory', true)
            input.setAttribute('webkitdirectory', true)
            input.multiple = true
            document.querySelector("body").appendChild(input)
            input.click()
            input.onchange = (e) => {
                this.$refs.upload.addInputFile(input).then(function () {
                    document.querySelector("body").removeChild(input)
                })
            }
        },

        onAddData() {
            this.addData.show = false
            if (!this.$refs.upload.features.html5) {
                this.alert('Your browser does not support')
                return
            }

            let file = new window.File([this.addData.content], this.addData.name, {
                type: this.addData.type,
            })
            this.$refs.upload.add(file)
        }
    }
}
</script>
