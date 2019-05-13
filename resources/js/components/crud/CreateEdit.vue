<template>
    <div class="box box-info">
        <form @submit.prevent="onSubmit" @keydown="form.errors.clear()">
            <div class="box-body">
                <div class="form-group" v-for="field in fields">
                    <label v-show="(field.admin && admin == 'admin') || ! field.admin" v-text="field.label"></label>

                    <input 
                        v-if="handleFieldType(field,'inputtext')"
                        type="text" 
                        class="form-control" 
                        value=""
                        :name="field.name" 
                        :placeholder="field.placeholder" 
                        v-model="form[field.name]" />
                    <textarea 
                        v-if="handleFieldType(field,'textarea')"
                        class="form-control" 
                        :name="field.name" 
                        :placeholder="field.placeholder" 
                        v-model="form[field.name]"
                        ></textarea>
                    <select 
                        v-if="handleFieldType(field,'select')"
                        class="form-control" 
                        :name="field.name" 
                        :placeholder="field.placeholder" 
                        v-model="form[field.name]"
                        >
                        
                        <option v-for="options in selects[field.settingname]" :value="options.value" v-text="options.label"></option>
                    </select>
                    <FilePond 
                        v-if="handleFieldType(field,'file')"
                        @processfile="processFile"
                        @init="handleFilePondInit"
                        ref="pond"
                    />

                    <span class="text-danger small" 
                          v-if="form.errors.has(field.name)" 
                          v-text="form.errors.get(field.name)"></span>
                </div>
            </div>

            <div class="box-footer">
                <input class="btn btn-primary" type="submit" value="Submit" :disabled="form.errors.any()" />
            </div>
        </form>
    </div>
</template>

<script>
    // Import Vue FilePond
    import vueFilePond, { setOptions } from 'vue-filepond';

    setOptions({
        server: {
            url : "/upload-3d-json",
            load: null,
            process: {
                method: 'POST',
                ondata: (formData) => {
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    return formData;
                }
            }
        }
    });

    // Import FilePond styles
    import 'filepond/dist/filepond.min.css';
    const FilePond = vueFilePond();

    export default {
        props : {
            fields : Array,
            selectssettings : Array,
            path : String,
            method : String,
        },
        data() {
            return {
                admin : admin,
                form: new Form(this.initForm()),
                selects : {}
            }
        },
        components: {
            FilePond
        },
        methods: {
            handleFieldType(field,inputType) {
                if (field.admin && admin != 'admin') {
                    return false;
                } else if (field.type == inputType) {
                    return true;
                } else {
                    return false;
                }
            },
            handleFilePondInit() {
                // console.log(this.$refs.pond);
            },
            processFile: function(err, file){
                if (err) {
                    console.log({error : 'An error had occurred'});
                } else if (file.serverId.indexOf('error') !== -1) {
                    let json = JSON.parse(file.serverId);
                    if (json.error) {
                        console.log({error : json.error});
                    } else {
                        console.log({error : 'An error had occurred'});
                    }
                } else {
                    let json = JSON.parse(file.serverId);
                    let done_file = json.file.replace('"','').replace('"','');
                    this.form['3dfile'] = done_file;
                }
                console.log("on process ", err, file.serverId);
                
                console.log(file.serverID);
                
            },
            initForm() {
                let obj = {};
                this.fields.forEach((field) => {
                    obj[field.name] = ''
                })
                return obj;
            },
            getSelect() {
                this.selectssettings.forEach((setting) => {
                    this.$set(this.selects, setting.name, []);
                    if (setting.route) {
                        axios.get(setting.route).then(response => {
                            response.data.forEach((row) => {
                                this.selects[setting.name].push({ label : row.name, value: row.id })
                            });
                        });      
                    } else {
                        this.$set(this.selects, setting.name, setting.predefined);
                    }
                })
            },
            onSubmit() {
                if (this.method == 'edit') {
                    this.form
                        .patch(`${this.path}/${this.$route.params.id}`)
                        .then((response) => {
                            this.$router.push({ path: this.path });
                        })
                } else {
                    this.form
                        .post(this.path)
                        .then((response) => {
                            this.$router.push({ path: this.path });
                        })
                }
            }
        },
        mounted() {
            this.getSelect();

            if (this.method == 'edit') {
                let uri = `${this.path}/${this.$route.params.id}`;
                axios.get(uri).then(response => {
                    this.fields.forEach((field) => {
                        this.form[field.name] = response.data[field.name]
                    });
                });
            }
        }
    }
</script>
