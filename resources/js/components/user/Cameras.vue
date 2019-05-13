<template>
    <div>
        <index 
            v-if="method == 'index'"
            path="/cameras"
            singular="camera"
            idfield="name"
            :fields="{ 
                'name' : 'Name', 
                'updated_at' : 'Updated At'
            }"
            :translate="{}"
            :filters="{
                'name' : 'Name',
                'intrinsic' : 'Intrinsic Parmas',
            }"
        ></index>
        <create-edit 
            v-if="method == 'create' || method == 'edit'"
            path="/cameras"
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
                    label : 'Camera Name',
                    placeholder : 'Camera Name',
                    type : 'inputtext',
                    name : 'name'
                },
                {
                    label : 'Intrinsic Parameters',
                    placeholder : 'Intrinsic Parameters',
                    type : 'textarea',
                    name : 'intrinsic'
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
            path="/cameras"
            :fields="[
                {
                    label : 'User',
                    name : 'user',
                    sub : 'name',
                    admin : true
                },
                {
                    label : 'Camera Name',
                    name : 'name'
                },
                {
                    label : 'Intrinsic Parameters',
                    name : 'intrinsic'
                },
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
