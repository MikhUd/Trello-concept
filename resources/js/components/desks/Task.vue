<template>
    <div class="task" draggable="true">
        <div class="card-header">{{taskTitle}}</div>
    </div>
</template>

<script>
export default {
    data(){
        return{
        
        }
},    
    props:{
        taskTitle:null
    },
   
}
</script>
<style scoped>
.task{
    box-shadow: inset 2px 2px 5px rgba(154, 147, 140, 0.5), 1px 1px 5px rgba(255, 255, 255, 1);
    background: bisque;
}
</style>