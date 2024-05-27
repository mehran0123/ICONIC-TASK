e
<template>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row">
      <div class="col">
        <div class="table-responsive">
          <button @click="logout" class="btn btn-danger" style="position: absolute; top: 10px; right: 10px;">Logout</button>

          <table class="table table-striped">
            <thead>
              <tr>
                <th>Title</th>
                <th>Category</th>
                <th>User</th>
                <th>Date</th>
                <th>Comments</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="feedback in feedbacks.data" :key="feedback.id">
                <td>{{ feedback.product_title }}</td>
                <td>{{ feedback.category }}</td>
                <td>{{ feedback.user.name }}</td>
                <td>{{ formatDate(feedback.created_at) }}</td>
                <td>           
                  <button class="btn btn-info" @click="addComments(feedback.id)">Add Comments</button>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <nav aria-label="Feedback Pagination">
            <!-- <ul class="pagination">
              <li class="page-item" :class="{ disabled: currentPage === 1 }">
                <button class="page-link" @click="prevPage" :disabled="currentPage === 1">
                  Previous
                </button>
              </li>
              <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                <button class="page-link" @click="changePage(page)">{{ page }}</button>
              </li>
              <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                <button class="page-link" @click="nextPage" :disabled="currentPage === totalPages">
                  Next
                </button>
              </li>
            </ul> -->
          </nav>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';


const router = useRouter();
const feedbacks = ref([]);
const currentPage = ref(1);
const perPage = 10; // Number of feedbacks per page

const addComments = (commentId) => {
  // router.push('/comments');
     router.push({ name: 'add-comment', params: { id: commentId } });
};



const fetchFeedbacks = async () => {
  try {
    const token = localStorage.getItem('token');
    const response = await axios.get(`http://127.0.0.1:8000/api/feedback/get-feedbacks?page=${currentPage.value}&perPage=${perPage}`, {
      headers: {
        Authorization: token, // Include the token in the Authorization header
      },
    });

    if (response.data._metadata.outcomeCode === 200) { 
      feedbacks.value = response.data.records;
    } else {
      throw new Error(response.data._metadata.message);
    }
  } catch (error) {
    console.error('Error fetching feedbacks:', error);
    // Handle error (e.g., show error message to user)
  }
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const options = { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
  return date.toLocaleDateString('en-GB', options);
};


const totalPages = computed(() => Math.ceil(feedbacks.value.total / perPage));

const changePage = (page) => {
  currentPage.value = page;
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const logout = async () => {
    const token = localStorage.getItem('token');
    const response = await axios.get(`http://127.0.0.1:8000/api/auth/logout`, {
      headers: {
        Authorization: token, // Include the token in the Authorization header
      },
    });
  localStorage.removeItem('token');
  router.push('/');
};

onMounted(fetchFeedbacks);
</script>
