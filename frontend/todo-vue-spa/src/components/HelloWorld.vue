<template>
  <div>
    <h1>Todo List</h1>
    <form @submit.prevent="addTodo">
      <input type="text" v-model="newTodo" placeholder="Add Todo" />
      <button type="submit">Add</button>
    </form>

    <ul>
      <li v-for="todo in todos" :key="todo.id">
        <div v-if="!todo.editing">
          <span @click="editTodo(todo)">{{ todo.title }}</span>
          <button @click="deleteTodo(todo.id)">Delete</button>
        </div>
        <div v-else>
          <input v-model="todo.title" />
          <input v-model="todo.description" />
          <input type="checkbox" v-model="todo.is_completed" />
          <button @click="saveTodo(todo)">Save</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
const API_BASE_URL = 'http://localhost:8000/api/tasks/';

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
    async editTodo(todo) {
      todo.editing = true;
    },
    async saveTodo(todo) {
    try {
      const response = await fetch(API_BASE_URL + todo.id, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          title: todo.title,
          description: todo.description,
          is_completed: todo.is_completed,
        }),
      });

      if (response.ok) {
        // Задача успешно сохранена
        todo.editing = false;
      } else {
        // Обработка ошибки сохранения задачи
      }
    } catch (error) {
      // Обработка ошибки сети
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
