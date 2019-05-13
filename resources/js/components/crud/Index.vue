<template>
    <div class="box box-info dataTables_wrapper form-inline dt-bootstrap">
        <div class="box-body">
            <div class="table table-responsive">
                <filter-index 
                    @filter-applied="handleFilterApplied"
                    @filter-cleared="handleFilterCleared"
                    :filters="filters"
                >
                </filter-index>

                <table class="table no-margin" v-show="items.length">
                    <tbody>
                        <tr>
                            <th v-for="(label, field) in fields" @click="handleSort(field)">
                                <a href="#"><i :class="handleSortClass(field)"></i>&nbsp;{{ label }}</a>
                            </th>
                        </tr>
                        
                        <tr v-for="item in items">
                            <td v-for="(label, field) in fields">
                                <router-link v-if="field==idfield" :to="`${path}/${item.id}`" v-text="item[field]"></router-link>
                                <span v-else v-text="translateValue(field,item[field])"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="padding:8px">
                    <p v-if="! items.length && ! filtering">Please create a new {{ singular }} by clicking <router-link :to="`${path}/create`">HERE</router-link></p>
                    <p v-if="! items.length && filtering">No results found</p>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <router-link :to="`${path}/create`" class="btn btn-primary">Create</router-link>
        </div>
    </div>
</template>

<style>
    th a {
        color:black;
    }
</style>

<script>
    import moment from 'moment';
    import FilterIndex from './FilterIndex';
    export default {
        props: {
            path : String,
            singular : String,
            idfield : String,
            fields : Object,
            translate : Object,
            filters : Object
        },
        components : { FilterIndex },
        data() {
            return {
                items: [],
                filtering : false,
                filterName : '',
                filterValue : '',
                sort : 'updated_at',
                sort_dir : 'desc'
            }
        },
        created() {
            let uri = this.path;
            axios.get(uri).then(response => {
                this.items = response.data;
            });
        },
        methods : {
            handleSortClass(field) {
                if (this.sort == field) {
                    return this.sort_dir == 'desc' ? 'fa fa-sort-amount-desc' : 'fa fa-sort-amount-asc';
                } else {
                    return 'fa fa-sort';
                }
            },
            handleSort(field) {
                this.sort = field;
                this.sort_dir = this.sort_dir == 'desc' ? 'asc' : 'desc';
                let uri = this.path + '?filters=' + this.filterName + '&filter_value=' + this.filterValue + '&sort=' + this.sort + '&sort_dir=' + this.sort_dir;
                axios.get(uri).then(response => {
                    this.items = response.data;
                });
            },
            handleFilterApplied(filterName,filterValue) {
                this.filtering = true;
                this.filterName = filterName;
                this.filterValue = filterValue;
                let uri = this.path + '?filters=' + filterName + '&filter_value=' + filterValue;
                axios.get(uri).then(response => {
                    this.items = response.data;
                });
            },
            handleFilterCleared() {
                this.filtering = false;
                this.filterName = '';
                this.filterValue = '';
                let uri = this.path;
                axios.get(uri).then(response => {
                    this.items = response.data;
                });
            },
            translateValue(field,value) {
                if (Object.keys(this.translate).indexOf(field) !== -1) {
                    return this.translate[field][value];
                } else if (field == 'created_at' || field == 'updated_at' ) {
                    return moment.utc(value).fromNow();
                } else {
                    return value;      
                }
            }
        }
    }
</script>
