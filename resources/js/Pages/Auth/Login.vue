<template>
  <div class="login-container">
    <form @submit.prevent="submit" class="login">
      <h2>Welcome, User!</h2>
      <p>Please log in</p>

      <input type="email" v-model="form.email" placeholder="Email" />
      <div v-if="form.errors.email" class="error">{{ form.errors.email }}</div>

      <input type="password" v-model="form.password" placeholder="Password" />
      <div v-if="form.errors.password" class="error">{{ form.errors.password }}</div>

      <button class="submitButton" type="submit">
        <span v-if="loading">Logging in...</span>
        <span v-else>Login</span>
      </button>
      <div class="login-link">
        <p>Sign Up <a href="/register">Register here</a></p>
      </div>
    </form>
  </div>
</template>


<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/inertia-vue3'

const loading = ref(false)

const form = useForm({
  email: '',
  password: ''
})

const submit = () => {
  loading.value = true
  form.post('/login', {
    onFinish: () => {
      loading.value = false
    }
  })
}
</script>


<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: #f4f7fa;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.login {
  background: #ffffff;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 350px;
}

.login h2 {
  margin-bottom: 10px;
  color: #2c3e50;
  font-size: 26px;
  text-align: center;
}

.login p {
  margin-bottom: 30px;
  color: #555;
  text-align: center;
  font-size: 14px;
}

.login input {
  width: 100%;
  padding: 12px 15px;
  margin-bottom: 15px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 15px;
  transition: border 0.2s;
}

.login input:focus {
  border-color: #3498db;
  outline: none;
}

.submitButton {
  width: 100%;
  background-color: #3498db;
  color: #fff;
  border: none;
  padding: 12px;
  font-size: 16px;
  font-weight: 600;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.submitButton:hover {
  background-color: #2980b9;
}


.submitButton[disabled] {
  background-color: #a0c4db;
  cursor: not-allowed;
}


.error {
  color: #e74c3c;
  font-size: 13px;
  margin-bottom: 10px;
}
</style>
