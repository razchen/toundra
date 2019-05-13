<template>
    <div class="filter-wrapper">
        Filter by &nbsp;
        <select class="form-control" v-model="filterName">
            <option v-for="label,filter in filters" :value="filter">{{ label }}</option>
        </select>

        <input type="text" class="form-control" placeholder="filter value" v-model="filterValue" />

        <button class="btn btn-default" @click="handleClick">
            <span class="fa fa-search"></span>
        </button>

        <button v-show="filtering" class="btn btn-default" @click="clear">
            <span class="fa fa-minus-square"></span>
        </button>
    </div>
</template>

<style>
    .filter-wrapper {
        padding:8px;
    }
</style>

<script>
    export default {
        props: {
            filters : Object
        },
        data() {
            return {
                filterName : '',
                filterValue : '',
                filtering : false
            }
        },
        methods : {
            handleClick() {
                this.filtering = true;
                this.$emit('filter-applied',this.filterName,this.filterValue);
            },
            clear() {
                this.filtering = false;
                this.filterName = '';
                this.filterValue = '';
                this.$emit('filter-cleared');
            }
        }
    }
</script>
