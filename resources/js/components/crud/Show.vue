<template>
    <div class="box box-info">
        <div class="box-body">
            <div v-if="Object.keys(item).length">
                <div v-for="(field) in fields">
                    <div v-if="(admin == 'admin' && field.admin) || ! field.admin">
                        <label v-text="field.label"></label>
                        <div v-if="field.name == 'files'">
                            <a v-for="file in item[field.name]" :href="`/stls/${file.filename}`">{{file.filename}}</a>
                        </div>
                        <div v-else>
                            <p v-text="processField(field,item)"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <router-link :to="`${this.path}/${item.id}/edit`" class="btn btn-primary">Edit</router-link>
            <button type="input" class="btn btn-danger" @click="deleteItem()">Delete</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            path : String,
            fields : Array,
            translate : Object
        },
        data() {
            return {
                item: {},
                admin : admin
            }
        },
        created() {
            let uri = `${this.path}/${this.$route.params.id}`;
            axios.get(uri).then(response => {
                this.item = response.data;
            });
        },
        methods: {
            processField(field,item) {
                try {
                    if (field.sub) {
                        return this.translateValue(field.name,item[field.name][field.sub]);
                    } else {
                        return this.translateValue(field.name,item[field.name]);
                    }    
                } catch(e) {
                    console.log('An error in one of the fields');
                }
                
            },
            translateValue(field,value) {
                if (Object.keys(this.translate).indexOf(field) !== -1) {
                    return this.translate[field][value];
                } else if (field == 'created_at' || field == 'updated_at' ) {
                    return moment.utc(value).fromNow();
                } else {
                    return value;      
                }
            },
            deleteItem() {
                axios
                    .delete(`${this.path}/${this.$route.params.id}`)
                    .then((response) => {
                        this.$router.push({ path: this.path });
                    })
            }
        }
    }
</script>
