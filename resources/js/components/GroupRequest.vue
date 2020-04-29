<template>
     <div>
          <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
               <li class="nav-item"><a href="" class="nav-link" data-toggle="tab" @click="num=0" :class="{ active: num == 0 }"><h3>Received</h3></a></li>
               <li class="nav-item"><a href="" class="nav-link" data-toggle="tab" @click="num=1" :class="{ active: num == 1 }"><h3>Sent</h3></a></li>
          </ul>
          <div class="card" v-for="(request, index) in this.getRequests" :key="index">
               <div class="card-body">
                    <div class="row justify-content-between">
                         <div class="col">
                              <p class="card-text"><a :href="'/user/'+getCardUserId(index)">{{ getCardUser(index) }}</a></p>
                         </div>
                         <div class="col-md-auto">
                              <p class="card-text">{{ request.created_at.substring(0,10) }} {{ request.created_at.substring(11,19) }}</p>
                         </div>
                    </div>
                    <p class="card-text"><a :href="'/post/'+request.post_id">{{ getAss(index) }}</a></p>
                    <p class="card-text">{{ request.note }}</p>
                    <div class="float-right">
                         <div style="display: flex;" v-if="request.status == 0 && num == 0">
                              <form id="refuse-request" method="POST" action="/grouprequest">
                                   <input type="hidden" name="_token" :value="csrf">
                                   <input type="hidden" name="status" value="2">
                                   <button type="submit" class="btn btn-danger">Refuse</button>
                              </form>
                              &nbsp;
                              <form id="accept-request" method="POST" action="/grouprequest">
                                   <input type="hidden" name="_token" :value="csrf">
                                   <input type="hidden" name="status" value="1">
                                   <button type="submit" class="btn btn-success">Accept</button>
                              </form>
                         </div>
                         <p v-else-if="request.status == 0 && num == 1" class="card-text">Status: <span class="badge badge-secondary">Pending</span></p>
                         
                         <button type="button" class="btn btn-success" disabled v-else-if="request.status == 1 && num == 0">Accepted</button>
                         
                         <button type="button" class="btn btn-danger" disabled v-else-if="request.status == 2 && num == 0">Refused</button>

                         <p class="card-text" v-else-if="request.status == 1 && num == 1">Status: <span class="badge badge-success">Accepted</span></p>

                         <p class="card-text" v-else>Status: <span class="badge badge-danger">Refused</span></p>
                         
                    </div>
               </div>
          </div>
     </div>
</template>

<script>
     export default {
          props: {
               received: {},
               sent: {}
          },
          data() {
               return {
                    num: 0,
                    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
               }
          },
          methods: {
               getCardUserId(index) {
                    if (this.num == 0) {
                         return this.received[index].requester_id
                    } else {
                         return this.sent[index].requestee_id
                    }
               },
               getCardUser(index) {
                    if (this.num == 0) {
                         return this.received[index].requester.firstname + " " + this.received[index].requester.lastname
                    } else {
                         return this.sent[index].user.firstname + " " + this.sent[index].user.lastname
                    }
               },
               getAss(index) {
                    if (this.num == 0) {
                         return this.received[index].post.course.classname + ": " + this.received[index].post.assignment
                    } else {
                         return this.sent[index].post.course.classname + ": " + this.sent[index].post.assignment
                    }
               }
          },
          computed: {
               getRequests() {
                    if (this.num == 0) {
                         return this.received
                    } else {
                         return this.sent
                    }
               }
          }
     }
</script>