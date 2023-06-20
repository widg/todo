<template>
  <div>
    <h1>Todo List</h1>
    <form @submit.prevent="addTodo">
      <input type="text" v-model="newTodo" placeholder="Add Todo" />
      <button type="submit">Add</button>
    </form>

    <ul>
      <li v-for="todo in todos" :key="todo.id">
        {{ todo.title }}
        <button @click="deleteTodo(todo.id)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      todos: [],
      newTodo: '',
    };
  },
  methods: {
    async addTodo() {
      // Отправка запроса к API для создания нового Todo
      const response = await fetch('http://localhost:8000/api/tasks', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          title: this.newTodo,
        }),
      });

      if (response.ok) {
        // Обновление списка Todo после успешного создания
        this.fetchTodos();
        this.newTodo = '';
      }
    },
    async deleteTodo(todoId) {
      // Отправка запроса к API для удаления Todo по идентификатору
      const response = await fetch(`http://localhost:8000/api/tasks/${todoId}`, {
        method: 'DELETE',
      });

      if (response.ok) {
        // Обновление списка Todo после успешного удаления
        this.fetchTodos();
      }
    },
    async fetchTodos() {
      // Отправка запроса к API для получения списка Todo
      const response = await fetch('http://localhost:8000/api/tasks');


      const data = await response.json();

      if (response.ok) {
        this.todos = data;
      }
    },
  },
  mounted() {
    this.fetchTodos();
  },
};
</script>
