<template>
<div class="container">
  <div class="comments-form">
    <h2>Add Comments</h2>
    <form @submit.prevent="saveComment">
      <!-- <div class="form-group">
        <label for="comment" class="form-label">Comment</label>
        <textarea class="form-control" id="comment" v-model="commentContent" rows="5" required></textarea>
      </div> -->
      <div class="editor-container">
    <ckeditor :editor="editor" v-model="commentContent" :config="editorConfig"></ckeditor>
  </div>
      <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
  </div>
</div>

</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter,useRoute } from 'vue-router';
import { CKEditor } from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Swal from 'sweetalert2';

const editor = ClassicEditor;
const commentContent = ref('');
const editorConfig = ref({
  // Add any configuration options here
});

const router = useRouter();
const route = useRoute();
const feedback_id = route.params.id;

const saveComment = async () => {
  const token = localStorage.getItem('token');
  if (!token) {
    // console.error('No token found in localStorage');
       Swal.fire('Error', 'No token found in localStorage', 'error');
    return;
  }
  if (commentContent.value.trim() == '' && commentContent.value.length == 0) {
      return Swal.fire('Error', 'Comment Required', 'error');
  }

  try {
    const response = await axios.post(
      'http://127.0.0.1:8000/api/comments/store-comment',
      {
        content: commentContent.value,
        feedback_id: feedback_id,
      },
      {
        headers: {
          Authorization: token, // Include the token in the Authorization header
        },
      }
    );
     // return  console.log(response);
    // Check if the comment was successfully stored
    if (response.data._metadata.outcomeCode === 200) {
  
      // alert(`Message:, ${response.data._metadata.message}`);
           Swal.fire('Success', 'Comment Added Successfully!', 'success');
      // Optionally, you can show a success message or update the UI
    } else {
      // console.error('Failed to save comment:', response.data._metadata.message);
        Swal.fire('Error', 'Login failed! Please try again.', response.data._metadata.message);
      // Optionally, you can show an error message or handle the error
    }
  } catch (error) {
    // console.error('Error saving comment:', error);
        Swal.fire('Error', 'Error saving comment:', error);
    
    // Handle any network errors or exceptions
  } finally {
    // Redirect back to the main page
   router.push('/dashboard');
  }
};
</script>

<style scoped>
/* Add custom styles for the form if needed */
</style>
