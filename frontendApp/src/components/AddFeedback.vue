<template>
<div class="container">
  <div class="comments-form">
    <h2>Add Feedback</h2>
    <form @submit.prevent="saveFeedback">
    <div class="form-group">
        <label for="comment" class="form-label">Product title</label>
        <input class="form-control" id="product_title" v-model="feedback.product_title" rows="5" required />
      </div>
      <div class="form-group">
        <label for="comment" class="form-label">Category</label>
        <input class="form-control" id="category" v-model="feedback.category" rows="5" required />
      </div>
      <div class="form-group">
        <label for="comment" class="form-label">Description</label>
        <textarea class="form-control" id="description" v-model="feedback.description" rows="5" required></textarea>
      </div>
      <div class="editor-container">
  </div>
      <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
  </div>
</div>

</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import Swal from 'sweetalert2';

const feedback = ref({
    product_title: '',
    description: '',
    category:''
});


const router = useRouter();

const saveFeedback = async () => {
  const token = localStorage.getItem('token');
  const errors = [];

  if (!token) {
    errors.push('No token found in localStorage');
  }


  if (errors.length > 0) {
    Swal.fire('Error', errors.join('<br>'), 'error');
    return;
  }

  try {
    const response = await axios.post(
      'http://127.0.0.1:8000/api/feedback/store-feedback',
      feedback.value,
      { headers: { Authorization: token } }
    );

    if (response.data._metadata.outcomeCode === 200) {
      Swal.fire('Success', 'Feedback stored successfully!', 'success');
      router.push('/dashboard');
    } else {
      Swal.fire('Error', 'Failed to save feedback', 'error');
    }
  } catch (error) {
    Swal.fire('Error', 'Error saving feedback', 'error');
    console.error('Error saving feedback:', error);
  }
};
</script>

<style scoped>
/* Add custom styles for the form if needed */
</style>
