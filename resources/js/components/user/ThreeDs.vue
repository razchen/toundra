<template>
    <div>
        <index 
            v-if="method == 'index'"
            path="/models"
            singular="model"
            idfield="name"
            :fields="{ 
                'name' : 'Model Name', 
                'updated_at' : 'Updated At'
            }"
            :translate="{}"
            :filters="{
                'name' : 'Name',
            }"
        ></index>
        <create-edit 
            v-if="method == 'create' || method == 'edit'"
            path="/models"
            routename="three_d"
            :method ="method"
            :fields="[
                {
                    label : 'Choose a User',
                    placeholder : 'Users',
                    type : 'select',
                    name : 'user_id',
                    settingname : 'users',
                    admin : true
                },
                {
                    label : 'Model Name',
                    placeholder : 'Model Name',
                    type : 'inputtext',
                    name : 'name'
                },
                {
                    label : 'Description',
                    placeholder : 'Description',
                    type : 'textarea',
                    name : 'description'
                },
                {
                    label : 'Upload File',
                    placeholder : 'Upload File',
                    type : 'file',
                    name : '3dfile'
                },
            ]"
            :selectssettings="[
                {
                    route : '/users',
                    name : 'users',
                    admin : true
                }
            ]"
        ></create-edit>
        <show 
            v-if="method == 'show'"
            path="/models"
            routename="three_d"
            :fields="[
                {
                    label : 'User',
                    name : 'user',
                    sub : 'name',
                    admin : true
                },
                {
                    label : 'Model Name',
                    name : 'name'
                },
                {
                    label : 'Description',
                    name : 'description'
                },
                {
                    label : 'Uploaded Files',
                    name : 'files'
                }
            ]"
            :translate="{}"
        ></show>
    </div>
</template>

<script>
    import Index from '../crud/Index.vue';
    import CreateEdit from '../crud/CreateEdit.vue';
    import Show from '../crud/Show.vue';
    export default {
        props : {
            method : String
        },
        components : { Index, CreateEdit, Show }
    }
</script>
