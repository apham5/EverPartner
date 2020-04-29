<template>
    <div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item"
                v-for="(course, index) in this.courses" :key=index 
                @click="[updateClass(index), selectedIndex = index, selectedCourse = course.id]">
                <a href="" class="nav-link" data-toggle="tab" :class="{ active: active(index) }">{{ course.classname }}</a>
            </li> 
            <li class="nav-item">
                <a :href="'/user/'+user_id+'/edit'" class="nav-link"><i class="fas fa-plus"></i>  Add a class</a>
            </li>
        </ul>
        <div class="row justify-content-between">
            <div class="col">
                <h1 margin-top="8px">Latest Posts in {{ classname }}</h1>
            </div>
            <div class="col-auto align-self-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Create Post</button>
            </div>
        </div>

        <create-post :class_id="selectedCourse"></create-post>

        <div class="card" v-for="(post, index) in this.courses[selectedIndex].posts" :key="index">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col">
                        <p class="card-text">{{ getPoster(post.poster_id) }}</p>
                    </div>
                    <div class="col-auto align-self-center">
                        <p class="card-text">{{ post.created_at.substring(0,10) }} {{ post.created_at.substring(11,19) }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-text">{{ classname }}: {{ post.assignment }}</h5>
                <h5 class="card-text">Partners needed: <b>{{ post.partner_num }}</b></h5>
                <h5 v-if="post.content.length<100" class="card-text text-muted">{{ post.content }}</h5>
                <h5 v-else class="card-text text-muted">{{ post.content.substring(0,100) }}...</h5>
                <a :href="'/post/' + post.id" class="stretched-link float-right">Details</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted????')
        },
        props: {
            courses: {},
            user_id: {}
        },
        data() {
            return{
                selectedCourse: 0,
                selectedIndex: 0,
                classname: this.courses[0].classname,
                posts: {},
                users: {}
            }
        },
        methods: {
            getPoster(poster_id) {
                for (var i=0; i<this.courses[this.selectedIndex].users.length; i++) {
                    if (this.courses[this.selectedIndex].users[i].id == poster_id) { 
                        return this.courses[this.selectedIndex].users[i].firstname + " " + this.courses[this.selectedIndex].users[i].lastname 
                    }
                }
            },
            updateClass(index) {
                this.classname = this.courses[index].classname
            },
            active(index) {
                if (this.selectedIndex == 0 & index == 0) return true
                if (this.selectedIndex == index) return true
                return false
            }
        }
    }
</script>

<style scoped>
    h1 {
        margin: 8px 0 
    }
    ul {
        margin-bottom: 8px
    }
</style>
<style>
    .card {
        margin: 8px 0 16px 0;
        border-color: #3490dc
    }
    .card-header {
        background-color: #3490dc;
        color: white
    }
</style>