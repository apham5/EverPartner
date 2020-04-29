<template>
     <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalCenterTitle">Create Post</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                         </button>
                    </div>
                    <form id="new_post" method="POST" action="/post">
                         <input type="hidden" name="_token" :value="csrf">
                         <div class="modal-body">
                              <input type="hidden" name="class_id" :value="class_id">
                              <div class="form-group">
                                   <label>Assignment</label>
                                   <input type="text" class="form-control" name="assignment" placeholder="What assignment is this post for?">
                              </div>
                              <div class="form-group">
                                   <label>Partners needed</label>
                                   <input type="number" class="form-control" name="partner_num" placeholder="How many group members are you looking for?">
                              </div>
                              <div class="form-group">
                                   <label>Details</label>
                                   <textarea 
                                        form="new_post"
                                        class="form-control" name="content" id="content" rows="6"
                                        placeholder="What are your project ideas? What are you looking for in your partners? How do you plan to do this project?" >
                                   </textarea>
                              </div>
                         </div>
                         <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                              <button type="submit" class="btn btn-primary">Submit</button>
                         </div>
                    </form>
               </div>
          </div>
     </div>
</template>

<script>
export default {
     props: {
          class_id: {},
     },
     data() {
          return {
               csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
     }
}
</script>