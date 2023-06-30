<template>
  <div>
    <form @submit.prevent="createJob" v-if="!editing">
      <input v-model="formData.title" type="text" placeholder="Название" required>
      <textarea v-model="formData.description" placeholder="Описание" required></textarea>
      <input v-model="formData.price" type="number" placeholder="Цена" required>
      <button type="submit">Создать</button>
    </form>

    <form @submit.prevent="updateJob" v-if="editing">
      <input v-model="editFormData.title" type="text" placeholder="Название" required>
      <textarea v-model="editFormData.description" placeholder="Описание" required></textarea>
      <input v-model="editFormData.price" type="number" placeholder="Цена" required>
      <button type="submit">Сохранить</button>
      <button @click="cancelEditing">Отмена</button>
    </form>

    <ul>
      <li v-for="job in jobs" :key="job.id">
        <h3>{{ job.title }}</h3>
        <p>{{ job.description }}</p>
        <p>Цена: {{ job.price }}</p>
        <button @click="startEditing(job.id)">Изменить</button>
        <button @click="deleteJob(job.id)">Удалить</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      jobs: [],
      formData: {
        title: '',
        description: '',
        price: ''
      },
      editing: false,
      editFormData: {
        id: null,
        title: '',
        description: '',
        price: ''
      }
    };
  },
  created() {
    this.fetchJobs();
  },
  methods: {
    fetchJobs() {
      fetch('http://localhost:8000/api/jobs')
        .then(response => response.json())
        .then(data => {
          this.jobs = data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    fetchCreatedJob(jobId) {
      fetch(`http://localhost:8000/api/jobs/${jobId}`)
        .then(response => response.json())
        .then(data => {
          this.jobs.push(data);
        })
        .catch(error => {
          console.error(error);
        });
    },
    createJob() {
      fetch('http://localhost:8000/api/jobs', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(this.formData)
      })
      .then(response => response.json())
      .then(data => {
        this.fetchCreatedJob(data.id);
        this.formData.title = '';
        this.formData.description = '';
        this.formData.price = '';
      })
      .catch(error => {
        console.error(error);
      });
    },
    startEditing(jobId) {
      const job = this.jobs.find(job => job.id === jobId);
      if (!job) {
        console.error(`Задание с идентификатором ${jobId} не найдено.`);
        return;
      }

      this.editing = true;
      this.editFormData.id = job.id;
      this.editFormData.title = job.title;
      this.editFormData.description = job.description;
      this.editFormData.price = job.price;
    },
    cancelEditing() {
      this.editing = false;
      this.editFormData.id = null;
      this.editFormData.title = '';
      this.editFormData.description = '';
      this.editFormData.price = '';
    },

    updateJob() {
      const { id, title, description, price } = this.editFormData;

      fetch(`http://localhost:8000/api/jobs/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title, description, price }),
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Ошибка при обновлении задания');
          }
          // Обновление списка заданий после успешного обновления
          this.fetchJobs();
          this.cancelEditing();
        })
        .catch(error => {
          console.error('Ошибка при обновлении задания:', error);
        });
    },
    deleteJob(jobId) {
      fetch(`http://localhost:8000/api/jobs/${jobId}`, {
        method: 'DELETE',
      })
      .then(response => response.json())
      .then(() => {
        this.jobs = this.jobs.filter(job => job.id !== jobId);
      })
      .catch(error => {
        console.error(error);
      });
    }
  }
};
</script>
